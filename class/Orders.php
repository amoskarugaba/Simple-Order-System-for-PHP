<?php

namespace CyanideSystems\Orders;

class Orders {

	public function __construct(){
		$this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	}

	public function getProducts(){
		$query = $this->db->query('SELECT sku, name, price
			FROM `products`
		');
		return $query->fetchAll();
	}

	public function setOrder($order_array){ // $_POST


	}

}

