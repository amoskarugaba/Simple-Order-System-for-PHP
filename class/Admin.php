<?php

namespace CyanideSystems\OrderSystem;
use \PDO;

class Admin {

	public function __construct(){
		$this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	}

	public function getProducts(){
		try {
			$query = $this->db->query('SELECT sku, product_name, price, vat_rate, stock_quantity
				FROM `products`
				WHERE stock_quantity > 0
			');
			return $query->fetchAll();
		} catch (PDOException $e) {
			ExceptionErrorHandler($e);
			return false;
		}
	}

	public function newProduct($sku, $product_name, $price, $vat_rate, $stock_quantity){
		$stock_quantity = (int)$stock_quantity;
		try {
			$query = $this->db->prepare('INSERT INTO `products` (sku, product_name, price, vat_rate, stock_quantity)
				VALUES (:sku, :product_name, :price, :vat_rate, :stock_quantity)
			');

			$query->bindValue(':sku', $sku, PDO::PARAM_STR);
			$query->bindValue(':product_name', $product_name, PDO::PARAM_STR);
			$query->bindValue(':price', $price, PDO::PARAM_STR);
			$query->bindValue(':vat_rate', $vat_rate, PDO::PARAM_STR);
			$query->bindValue(':stock_quantity', $stock_quantity, PDO::PARAM_INT);

			$query->execute();
			return true;
		} catch (PDOException $e) {
			ExceptionErrorHandler($e);
			return false;
		}
	}

	public function editProduct($sku, $product_name, $price, $vat_rate, $stock_quantity){
		$stock_quantity = (int)$stock_quantity;
		try {
			$query = $this->db-prepare('UPDATE `products`
				SET product_name = :product_name,
					price = :price,
					vat_rate = :vat_rate,
					stock_quantity = :stock_quantity
				WHERE sku = :sku
			');

			$query->bindValue(':sku', $sku, PDO::PARAM_STR);
			$query->bindValue(':product_name', $product_name, PDO::PARAM_STR);
			$query->bindValue(':price', $price, PDO::PARAM_STR);
			$query->bindValue(':vat_rate', $vat_rate, PDO::PARAM_STR);
			$query->bindValue(':stock_quantity', $stock_quantity, PDO::PARAM_INT);

			$query->execute();
			return true;
		} catch (PDOException $e) {
			ExceptionErrorHandler($e);
			return false;
		}
	}

	// Returns all proformas which are not invoiced
	public function getProformas(){
		try {
			$query = $this->db->query('SELECT proforma_id, date, discount, order_total, customer_id
				FROM `proforma_main`
				WHERE invoiced = 0
			');
			return $query->fetchAll();
		} catch (PDOException $e) {
			ExceptionErrorHandler($e);
			return false;
		}
	}

	// Returns specific proforma based on proforma_id
	public function getProformaMain($proforma_id){
		$proforma_id = (int)$proforma_id;
		try {
			$query = $this->db->prepare('SELECT `proforma_main`.proforma_id,
					`proforma_main`.date,
					`proforma_main`.discount,
					`proforma_main`.order_total,
					`proforma_main`.customer_id,
					`customer_details`.email,
					`customer_details`.firstname,
					`customer_details`.lastname,
					`customer_details`.company,
					`customer_details`.address1,
					`customer_details`.address2,
					`customer_details`.town,
					`customer_details`.county,
					`customer_details`.postcode,
					`customer_details`.phone,
					`customer_details`.notes
				FROM `proforma_main`, `customer_details`
				WHERE `proforma_main`.customer_id = `customer_details`.customer_id
				AND `proforma_main`.proforma_id = :proforma_id
			');
			$query->bindValue(':proforma_id', $proforma_id, PDO::PARAM_INT);
			$query->execute();
			return $query->fetch();
		} catch (PDOException $e) {
			ExceptionErrorHandler($e);
			return false;
		}
	}

	// Returns specific proforma lines based on proforma_id
	public function getProformaLines($proforma_id){
		$proforma_id = (int)$proforma_id;
		try {
			$query = $this->db->prepare('SELECT date, product_sku, quantity, line_price, vat_rate, quantity*line_price AS line_total, quantity*line_price*(vat_rate/100) AS vat_net
				FROM proforma_lines
				WHERE invoice_id = :proforma_id
				ORDER BY line_id ASC
			');
			$query->bindValue(':proforma_id', $proforma_id, PDO::PARAM_INT);
			$query->execute();
			return $query->fetchAll();
		} catch (PDOException $e) {
			ExceptionErrorHandler($e);
			return false;
		}
	}

	// Creates invoice once proforma has been paid, and marks the proforma as invoiced
	public function createInvoice($proforma_id){
		$proforma_id = (int)$proforma_id;
		$this->db->beginTransaction(); // Begin TRANSACTION so that if one query fails, the other will ROLLBACK
		try {
			$query = $this->db->prepare('INSERT INTO `invoice_main` (discount, order_total, proforma_id, customer_id)
				SELECT discount, order_total, proforma_id, customer_id
				FROM `proforma_main`
				WHERE proforma_id = :proforma_id
				AND invoiced = 0
			');

			$query->bindValue(':proforma_id', $proforma_id, PDO::PARAM_INT);
			$query->execute();

			$invoice_id = $this->db->lastInsertId();

			$query = $this->db->prepare('UPDATE `proforma_main`
				SET invoiced = 1
				WHERE proforma_id = :proforma_id
				AND invoiced = 0
			');

			$query->bindValue(':proforma_id', $proforma_id, PDO::PARAM_INT);

			$query->execute();

			// These SQL statements should probably be cleaned up a bit and merged
			$query = $this->db->prepare('INSERT INTO `invoice_lines` (invoice_id)
				VALUES (:invoice_id)
			');

			$query->bindValue(':invoice_id', $invoice_id, PDO::PARAM_INT);
			$query->execute();

			$query = $this->db->prepare('UPDATE `invoice_lines`, `proforma_lines`
				SET `invoice_lines`.product_sku = `proforma_lines`.product_sku,
					`invoice_lines`.quantity = `proforma_lines`.quantity,
					`invoice_lines`.line_price = `proforma_lines`.line_price,
					`invoice_lines`.vat_rate = `proforma_lines`.vat_rate,
					`invoice_lines`.customer_id = `proforma_lines`.customer_id
				WHERE `invoice_lines`.invoice_id = :invoice_id
			');

			$query->bindValue(':invoice_id', $invoice_id, PDO::PARAM_INT);
			$query->execute();

			$this->db->commit();

			return true;
		} catch (PDOException $e) {
			$this->db->rollback();
			ExceptionErrorHandler($e);
			return false;
		}
	}

	public function getInvoices(){
		try {
			$query = $this->db->query('SELECT proforma_id, date, discount, order_total, customer_id
				FROM `invoice_main`
			');
			return $query->fetchAll();
		} catch (PDOException $e) {
			ExceptionErrorHandler($e);
			return false;
		}
	}

	public function getInvoiceMain($invoice_id){
		$invoice_id = (int)$invoice_id;
		try {
			$query = $this->db->prepare('SELECT `invoice_main`.invoice_id,
					`invoice_main`.date,
					`invoice_main`.discount,
					`invoice_main`.order_total,
					`invoice_main`.customer_id,
					`customer_details`.email,
					`customer_details`.firstname,
					`customer_details`.lastname,
					`customer_details`.company,
					`customer_details`.address1,
					`customer_details`.address2,
					`customer_details`.town,
					`customer_details`.county,
					`customer_details`.postcode,
					`customer_details`.phone,
					`customer_details`.notes
				FROM `invoice_main`, `customer_details`
				WHERE `invoice_main`.customer_id = `customer_details`.customer_id
				AND `invoice_main`.invoice_id = :invoice_id
			');
			$query->bindValue(':invoice_id', $invoice_id, PDO::PARAM_INT);
			$query->execute();
			return $query->fetch();
		} catch (PDOException $e) {
			ExceptionErrorHandler($e);
			return false;
		}
	}

	public function getInvoiceLines($invoice_id){
		$invoice_id = (int)$invoice_id;
		try {
			$query = $this->db->prepare('SELECT date, product_sku, quantity, line_price, vat_rate, quantity*line_price AS line_total, quantity*line_price*(vat_rate/100) AS vat_net
				FROM invoice_lines
				WHERE invoice_id = :invoice_id
				ORDER BY line_id ASC
			');
			$query->bindValue(':invoice_id', $invoice_id, PDO::PARAM_INT);
			$query->execute();
			return $query->fetchAll();
		} catch (PDOException $e) {
			ExceptionErrorHandler($e);
			return false;
		}
	}

}
