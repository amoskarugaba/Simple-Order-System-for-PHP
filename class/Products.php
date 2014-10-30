<?php

namespace CyanideSystems;
use \PDO;

class Products {

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

}
