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
			$query = $this->db->query('SELECT proforma_id, customer_id, date
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
			$query = $this->db->prepare('SELECT m.proforma_id,
					m.date,
					m.discount,
					m.total_net,
					m.total_vat_net,
					m.total_gross,
					m.delivery_quantity,
					m.delivery_total,
					c.email,
					c.firstname,
					c.lastname,
					c.company,
					c.address1,
					c.address2,
					c.town,
					c.county,
					c.postcode,
					c.phone,
					c.notes
				FROM `customer_details` c, `proforma_main` m
				WHERE m.proforma_id = :proforma_id
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
				WHERE proforma_id = :proforma_id
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
			// These can probably be cleaned up a bit and merged into a single SQL statement!
			$query = $this->db->prepare('INSERT INTO `invoice_main` (total_net, total_vat_net, total_gross, discount, delivery_quantity, delivery_total, proforma_id, customer_id)
				SELECT total_net, total_vat_net, total_gross, discount, delivery_quantity, delivery_total, proforma_id, customer_id
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

			$query = $this->db->prepare('INSERT INTO `invoice_lines` (invoice_id, product_sku, quantity, line_price, vat_rate, customer_id, proforma_id)
				SELECT :invoice_id, product_sku, quantity, line_price, vat_rate, customer_id, proforma_id
				FROM `proforma_lines`
				WHERE proforma_id = :proforma_id
			');

			$query->bindValue(':invoice_id', $invoice_id, PDO::PARAM_INT);
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

	public function getInvoices(){
		try {
			$query = $this->db->query('SELECT invoice_id, date, total_net, total_vat_net, total_gross, discount, delivery_quantity, delivery_total, customer_id
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
			$query = $this->db->prepare('SELECT m.invoice_id,
					m.date,
					m.discount,
					m.total_net,
					m.total_vat_net,
					m.total_gross,
					m.delivery_quantity,
					m.delivery_total,
					c.email,
					c.firstname,
					c.lastname,
					c.company,
					c.address1,
					c.address2,
					c.town,
					c.county,
					c.postcode,
					c.phone,
					c.notes
				FROM `customer_details` c, `invoice_main` m
				WHERE m.invoice_id = :invoice_id
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

	public function registerAdminUser($email, $password, $permissions = 0){
		$permissions = (int)$permissions;
		if($this->validateEmail($email)){
			if($this->emailAvailable($email)){
				$hash = password_hash($password, PASSWORD_DEFAULT);
				$query = $this->db->prepare('INSERT INTO `admin_logins` (email, hash, permissions)
					VALUES (:email, :hash, :permissions)
				');
				$query->bindValue(':email', $email, PDO::PARAM_STR);
				$query->bindValue(':hash', $hash, PDO::PARAM_STR);
				$query->bindValue(':permissions', $permissions, PDO::PARAM_INT);
				if($query->execute()){
					// This makes sure that the person logged in is the same as accessing the restricted page (include 'private/restricted.php' at the top of each page)
					$r = $_SERVER['REMOTE_ADDR'];
					$h = getenv('HTTP_X_FORWARDED_FOR');
					$a = $_SERVER['HTTP_USER_AGENT'];
					// $_SESSION['check'] checks against the $check variable in 'private/restricted.php'
					$_SESSION['admin_check'] = hash('sha256', $r . $h . $a);
					$_SESSION['permissions'] = $permissions;
					$_SESSION['admin'] = true;
					return true;
				} else {
					error_log('Database Error: Failed to INSERT registration details into `admin_logins`', 0);
					$_SESSION['user_message'] = REGISTRATION_DATABASE_INSERT_ERROR; // Returns message if registration NOT successful due to database insert error
					return false;
				}
			} else {
				$_SESSION['user_message'] = REGISTRATION_EMAIL_UNAVAILABLE_ERROR; // Returns message if the email address is already in the database
				return false;
			}
		} else {
			$_SESSION['user_message'] = RESGISTRATION_EMAIL_NOT_VALID; // Returns message if the email address doesn't pass validation (ie. it doesn't look like a real email address)
			return false;
		}
	}

	private function emailAvailable($email){
		try {
			$query = $this->db->prepare('SELECT email
				FROM `site_logins`
				WHERE email = :email
			');
			$query->bindValue(':email', $email, PDO::PARAM_STR);
			$query->execute();
			if($query->rowCount() > 0){
				return false;
			} else {
				return true;
			}
		} catch (PDOException $e) {
			ExceptionErrorHandler($e);
			return false;
		}
	}

	private function validateEmail($email){
		$filter_email = filter_var($email, FILTER_SANITIZE_EMAIL);
		if($email == $filter_email && filter_var($email, FILTER_VALIDATE_EMAIL)){
			return true;
		} else {
			return false;
		}
	}

	public function verifyAdminLogin($email, $password){
		// Returns true on correct email/password
		$hash = $this->getHash($email);
		if(password_verify($password, $hash)){
			// This makes sure that the person logged in is the same as accessing the restricted page (include 'private/restricted.php' at the top of each page)
			$r = $_SERVER['REMOTE_ADDR'];
			$h = getenv('HTTP_X_FORWARDED_FOR');
			$a = $_SERVER['HTTP_USER_AGENT'];
			// $_SESSION['check'] checks against the $check variable in 'private/restricted.php'
			$_SESSION['admin_check'] = hash('sha256', $r . $h . $a);
			$_SESSION['permissions'] = $this->getAdminPermissions($email);
			$_SESSION['admin'] = true;
			return true;
		} else {
			$_SESSION['user_message'] = INCORRECT_LOGIN_CREDENTIALS;
			return false;
		}
	}

	private function getHash($email){
		try {
			$query = $this->db->prepare('SELECT hash
				FROM `admin_logins`
				WHERE email = :email
			');
			$query->bindValue(':email', $email, PDO::PARAM_STR);
			$query->execute();
			$check = $query->fetch();
			return $check->hash;
		} catch (PDOException $e) {
			ExceptionErrorHandler($e);
			return false;
		}
	}

	private function getAdminPermissions($email){
		try {
			$query = $this->db->prepare('SELECT permissions
				FROM `admin_logins`
				WHERE email = :email
			');
			$query->bindValue(':email', $email, PDO::PARAM_STR);
			$query->execute();
			$check = $query->fetch();
			return $check->permissions;
		} catch (PDOException $e) {
			ExceptionErrorHandler($e);
			return false;
		}
	}

	// Sets up tables for initial install (database details *must* be set in private/config.php)
	public function setupDatabase(){
		$this->db->beginTransaction(); // Begin TRANSACTION so that if one query fails, the other will ROLLBACK
		try {
			$this->db->query('CREATE TABLE `site_logins` (
					customer_id INT(11) NOT NULL AUTO_INCREMENT,
					email VARCHAR(255) NOT NULL,
					hash VARCHAR(255) NOT NULL,
					PRIMARY KEY (customer_id)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1
			');

			$this->db->query('CREATE TABLE `admin_logins` (
					email VARCHAR(255) NOT NULL,
					hash VARCHAR(255) NOT NULL,
					permissions TINYINT(1) NOT NULL DEFAULT 0,
					PRIMARY KEY (email)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1
			');

			$this->db->query('CREATE TABLE `customer_details` (
					customer_id INT(11) NOT NULL,
					email VARCHAR(255) NOT NULL,
					firstname VARCHAR(100) NOT NULL,
					lastname VARCHAR(100) NOT NULL,
					company VARCHAR(100) NOT NULL,
					address1 VARCHAR(255) NOT NULL,
					address2 VARCHAR(255) NOT NULL,
					town VARCHAR(65) NOT NULL,
					county VARCHAR(30) NOT NULL,
					postcode VARCHAR(9) NOT NULL,
					phone VARCHAR(15) NOT NULL,
					notes TEXT NOT NULL,
					PRIMARY KEY (customer_id),
					FOREIGN KEY (customer_id) REFERENCES `site_logins`(customer_id)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1
			');

			$this->db->query('CREATE TABLE `products` (
					sku VARCHAR(30) NOT NULL,
					product_name VARCHAR(255) NOT NULL,
					price DECIMAL(10, 2) NOT NULL,
					vat_rate DECIMAL(5, 2) NOT NULL DEFAULT 0.00,
					stock_quantity INT(11) NOT NULL DEFAULT 0,
					PRIMARY KEY (sku)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1
			');

			$this->db->query('CREATE TABLE `invoice_main` (
					invoice_id INT(11) NOT NULL AUTO_INCREMENT,
					date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
					total_net DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
					total_vat_net DECIMAL(10, 2) NOT NULLL DEFAULT 0.00,
					total_gross DECIMAL(10, 2) NOT NULLL DEFAULT 0.00,
					discount DECIMAL(5, 2) NOT NULL DEFAULT 0.00,
					delivery_quantity INT(11) NOT NULL DEFAULT 0,
					delivery_total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
					proforma_id INT(11) NOT NULL,
					customer_id INT(11) NOT NULL,
					PRIMARY KEY (invoice_id),
					FOREIGN KEY (customer_id) REFERENCES `customer_details`(customer_id)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1
			');

			$this->db->query('CREATE TABLE `invoice_lines` (
					line_id INT(11) NOT NULL AUTO_INCREMENT,
					date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
					product_sku VARCHAR(20) NOT NULL,
					quantity INT(11) NOT NULL DEFAULT 0,
					line_price DECIMAL(10, 2) NOT NULL,
					vat_rate DECIMAL(5, 2) NOT NULL DEFAULT 0.00,
					customer_id INT(11) NOT NULL,
					proforma_id INT(11) NOT NULL,
					invoice_id INT(11) NOT NULL,
					PRIMARY KEY (line_id),
					FOREIGN KEY (invoice_id) REFERENCES `invoice_main`(invoice_id)
					ON DELETE CASCADE
					ON UPDATE CASCADE
				) ENGINE=InnoDB DEFAULT CHARSET=latin1
			');

			$this->db->query('CREATE TABLE `proforma_main` (
					proforma_id INT(11) NOT NULL AUTO_INCREMENT,
					date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
					total_net DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
					total_vat_net DECIMAL(10, 2) NOT NULLL DEFAULT 0.00,
					total_gross DECIMAL(10, 2) NOT NULLL DEFAULT 0.00,
					discount DECIMAL(5, 2) NOT NULL DEFAULT 0.00,
					delivery_quantity INT(11) NOT NULL DEFAULT 0,
					delivery_total DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
					invoiced TINYINT(1) NOT NULL DEFAULT 0,
					customer_id INT(11) NOT NULL,
					PRIMARY KEY (proforma_id),
					FOREIGN KEY (customer_id) REFERENCES `customer_details`(customer_id)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1
			');

			$this->db->query('CREATE TABLE `proforma_lines` (
					line_id INT(11) NOT NULL AUTO_INCREMENT,
					date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
					product_sku VARCHAR(20) NOT NULL,
					quantity INT(11) NOT NULL,
					line_price DECIMAL(10, 2) NOT NULL,
					vat_rate DECIMAL(5, 2) NOT NULL DEFAULT 0.00,
					customer_id INT(11) NOT NULL,
					proforma_id INT(11) NOT NULL,
					PRIMARY KEY (line_id),
					FOREIGN KEY (proforma_id) REFERENCES `proforma_main`(proforma_id)
					ON DELETE CASCADE
					ON UPDATE CASCADE
				) ENGINE=InnoDB DEFAULT CHARSET=latin1
			');
			$this->db->commit();
			return true;
		} catch (PDOException $e) {
			$this->db->rollback();
			ExceptionErrorHandler($e);
			return false;
		}
	}

}
