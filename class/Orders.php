<?php

namespace CyanideSystems;
use \PDO;
class Orders {

	public function __construct($customer_id){
		$this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
		$this->customer_id = (int)$customer_id;
	}

	public function getProducts(){
		$query = $this->db->query('SELECT sku, product_name, price
			FROM `products`
		');
		return $query->fetchAll();
	}

	public function createProforma($proforma_array){ // $_POST
		$this->db->beginTransaction(); // Begin TRANSACTION so that if one query fails, the other will ROLLBACK
		try {
			$query = $this->db->prepare('INSERT INTO `proforma_main` (customer_id)
				VALUES (:customer_id)
			');

			$query->bindValue(':customer_id', $this->customer_id, PDO::PARAM_INT);
			$query->execute();

			$proforma_id = $this->db->lastInsertId();

			$query = $this->db->prepare('INSERT INTO `proforma_lines` (product_sku, quantity, customer_id, proforma_id)
				VALUES (:product_sku, :quantity, :customer_id, :proforma_id)
			');

			$query->bindValue(':customer_id', $this->customer_id, PDO::PARAM_INT); // bindValue as the customer_id will remain the same
			$query->bindParam(':product_sku', $product_sku, PDO::PARAM_STR); // bindParam as the proforma_line will be different for each line
			$query->bindParam(':quantity', $quantity, PDO::PARAM_STR); // bindParam as the proforma_line will be different for each line
			$query->bindValue(':proforma_id', $proforma_id, PDO::PARAM_INT); // bindValue as the proforma_id will remain the same

			foreach($proforma_array as $product_sku=>$quantity){
				$query->execute();
			}

			// UPDATEs price from `products` table
			$query = $this->db->prepare('UPDATE `proforma_lines`
				INNER JOIN `products`
				ON `products`.sku = `proforma_lines`.product_sku
				SET `proforma_lines`.line_price = `products`.price
				WHERE `proforma_lines`.proforma_id = :proforma_id
			');

			$query->bindValue(':proforma_id', $proforma_id);
			$query->execute();

			$query = $this->db->prepare('UPDATE `proforma_main` m
				INNER JOIN (
					SELECT customer_id, proforma_id, SUM(line_price*quantity) as order_total
					FROM `proforma_lines`
					WHERE proforma_id = :proforma_id
					AND customer_id = :customer_id
				) l ON m.proforma_id = l.proforma_id
				SET m.order_total = l.order_total
				WHERE l.proforma_id = :proforma_id
				AND l.customer_id = :customer_id
			');

			$query->bindValue(':proforma_id', $proforma_id);
			$query->bindValue(':customer_id', $this->customer_id);
			$query->execute();

			$this->db->commit();

			return true;
			//return $proforma_id;
		} catch (PDOException $e) {
			$this->db->rollback();
			ExceptionErrorHandler($e);
			return false;
		}
	}

	public function getProformaMain($proforma_id){
		$proforma_id = (int)$proforma_id;
		try {
			$query = $this->db->prepare('SELECT proforma_id, date, discount, order_total
				FROM proforma_main
				WHERE invoiced = 0
				AND proforma_id = :proforma_id
				AND customer_id = :customer_id
				ORDER BY date DESC
				LIMIT 1
			');
			$query->bindValue(':proforma_id', $proforma_id, PDO::PARAM_INT);
			$query->bindValue(':customer_id', $this->customer_id, PDO::PARAM_INT);
			$query->execute();
			return $query->fetch();
		} catch (PDOException $e) {
			ExceptionErrorHandler($e);
			return false;
		}
	}

	public function getProformaLines($proforma_id){
		$proforma_id = (int)$proforma_id;
		try {
			$query = $this->db->prepare('SELECT date, product_sku, quantity, line_price
				FROM proforma_lines
				WHERE proforma_id = :proforma_id
				AND customer_id = :customer_id
				ORDER BY line_id DESC
			');
			$query->bindValue(':proforma_id', $proforma_id, PDO::PARAM_INT);
			$query->bindValue(':customer_id', $this->customer_id, PDO::PARAM_INT);
			$query->execute();
			return $query->fetchAll();
		} catch (PDOException $e) {
			ExceptionErrorHandler($e);
			return false;
		}
	}

	public function createInvoice($proforma_id){
		$proforma_id = (int)$proforma_id;
		$this->db->beginTransaction(); // Begin TRANSACTION so that if one query fails, the other will ROLLBACK
		try {
			$query = $this->db->prepare('INSERT INTO `invoice_main` (discount, order_total, customer_id)
				SELECT discount, order_total, customer_id
				FROM `proforma_main`
				WHERE proforma_id = :proforma_id
				AND customer_id = :customer_id
				AND invoiced != 1
			');

			$query->bindValue(':proforma_id', $proforma_id, PDO::PARAM_INT);
			$query->bindValue(':customer_id', $this->customer_id, PDO::PARAM_INT);
			$query->execute();

			$query = $this->db->prepare('UPDATE `proforma_main`
				SET invoiced = 1
				WHERE proforma_id = :proforma_id
			');

			$query->bindValue(':proforma_id', $proforma_id, PDO::PARAM_INT);

			$query->execute();

			$this->db->commit();

			return true;
		} catch (PDOException $e) {
			$this->db->rollback();
			ExceptionErrorHandler($e);
			return false;
		}
	}

}

