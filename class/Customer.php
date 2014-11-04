<?php

// This class is specific to individual customers by $customer_id (eg. $_SESSION['customer_id']) - ie. customer must be logged in to access any functions

namespace CyanideSystems\OrderSystem;
use \PDO;
class Customer {

	public function __construct($customer_id){
		$this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
		$this->customer_id = (int)$customer_id;
	}

	// Returns all products which are in stock (ie. stock quantity above 0)
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

	// Creates proforma, returns proforma_id on success, false on failure
	public function createProforma($proforma_array){ // $_POST from order form
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

			// UPDATEs price and VAT rate from `products` table
			$query = $this->db->prepare('UPDATE `proforma_lines`
				INNER JOIN `products`
				ON `products`.sku = `proforma_lines`.product_sku
				SET `proforma_lines`.line_price = `products`.price, `proforma_lines`.vat_rate = `products`.vat_rate
				WHERE `proforma_lines`.proforma_id = :proforma_id
			');

			$query->bindValue(':proforma_id', $proforma_id);
			$query->execute();

			$this->db->commit();

			return $proforma_id;
		} catch (PDOException $e) {
			$this->db->rollback();
			ExceptionErrorHandler($e);
			return false;
		}
	}

	// Returns all customer's proformas
	public function getProformas(){
		try {
			$query = $this->db->prepare('SELECT proforma_id, date, customer_id
				FROM `proforma_main`
				WHERE customer_id = :customer_id
				AND invoiced = 0
			');
			$query->bindValue(':customer_id', $this->customer_id, PDO::PARAM_INT);
			$query->execute();
			return $query->fetchAll();
		} catch (PDOException $e) {
			ExceptionErrorHandler($e);
			return false;
		}
	}

	// Returns specific proforma based on proforma_id and customer_id
	public function getProformaMain($proforma_id){
		$proforma_id = (int)$proforma_id;
		// Additional 'AND' WHERE clauses for security (makes sure no unscrupulous individual tries to view details from another customer)
		try {
			$query = $this->db->prepare('SELECT m.proforma_id,
					m.date,
					m.discount,
					total,
					total_vat_net,
					total_gross,
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
				FROM `customer_details`, `proforma_main` m
				JOIN (
					SELECT `proforma_lines`.customer_id,
					`proforma_lines`.proforma_id,
					SUM(quantity*line_price) AS total,
					SUM(quantity*line_price*(vat_rate/100)) AS total_vat_net,
					SUM(quantity*line_price*(vat_rate/100+1)) AS total_gross
					FROM `proforma_lines`
					WHERE `proforma_lines`.proforma_id = :proforma_id
					AND `proforma_lines`.customer_id = :customer_id
				) AS l ON m.proforma_id = l.proforma_id
				WHERE m.customer_id = l.customer_id
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

	// Returns specific proforma lines based on proforma_id and customer_id
	public function getProformaLines($proforma_id){
		$proforma_id = (int)$proforma_id;
		try {
			$query = $this->db->prepare('SELECT date, product_sku, quantity, line_price, vat_rate, quantity*line_price AS line_total, quantity*line_price*(vat_rate/100) AS vat_net
				FROM proforma_lines
				WHERE proforma_id = :proforma_id
				AND customer_id = :customer_id
				ORDER BY line_id ASC
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

	// DELETEs specific proforma for customer
	public function cancelProforma($proforma_id){
		$proforma_id = (int)$proforma_id;
		try {
			$query = $this->db->prepare('DELETE FROM `proforma_main`
				WHERE customer_id = :customer_id
				AND proforma_id = :proforma_id
				AND invoiced = 0
			');
			$query->bindValue(':customer_id', $this->customer_id, PDO::PARAM_INT);
			$query->bindValue(':proforma_id', $proforma_id, PDO::PARAM_INT);
			$query->execute();
			return true;
		} catch (PDOException $e) {
			ExceptionErrorHandler($e);
			return false;
		}
	}

	// Returns all invoices for customer
	public function getInvoices(){
		try {
			$query = $this->db->prepare('SELECT invoice_id, date, discount, order_total
				FROM `invoice_main`
				WHERE customer_id = :customer_id
			');
			$query->bindValue(':customer_id', $this->customer_id, PDO::PARAM_INT);
			$query->execute();
			return $query->fetchAll();
		} catch (PDOException $e) {
			ExceptionErrorHandler($e);
			return false;
		}
	}

	// Returns specific main invoice for customer
	public function getInvoiceMain($invoice_id){
		$invoice_id = (int)$invoice_id;
		// Additional 'AND' WHERE clauses for security (makes sure no unscrupulous individual tries to view details from another customer)
		try {
			$query = $this->db->prepare('SELECT m.invoice_id,
					m.date,
					m.discount,
					total,
					total_vat_net,
					total_gross,
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
				FROM `customer_details`, `invoice_main` m
				JOIN (
					SELECT `invoice_lines`.customer_id,
					`invoice_lines`.invoice_id,
					SUM(quantity*line_price) AS total,
					SUM(quantity*line_price*(vat_rate/100)) AS total_vat_net,
					SUM(quantity*line_price*(vat_rate/100+1)) AS total_gross
					FROM `invoice_lines`
					WHERE `invoice_lines`.invoice_id = :invoice_id
					AND `invoice_lines`.customer_id = :customer_id
				) AS l ON m.invoice_id = l.invoice_id
				WHERE m.customer_id = l.customer_id
			');
			$query->bindValue(':invoice_id', $invoice_id, PDO::PARAM_INT);
			$query->bindValue(':customer_id', $this->customer_id, PDO::PARAM_INT);
			$query->execute();
			return $query->fetch();
		} catch (PDOException $e) {
			ExceptionErrorHandler($e);
			return false;
		}
	}

	// Returns invoice lines for invoice for customer
	public function getInvoiceLines($invoice_id){
		$invoice_id = (int)$invoice_id;
		try {
			$query = $this->db->prepare('SELECT date, product_sku, quantity, line_price, vat_rate, quantity*line_price AS line_total, quantity*line_price*(vat_rate/100) AS vat_net
				FROM invoice_lines
				WHERE invoice_id = :invoice_id
				AND customer_id = :customer_id
				ORDER BY line_id ASC
			');
			$query->bindValue(':invoice_id', $invoice_id, PDO::PARAM_INT);
			$query->bindValue(':customer_id', $this->customer_id, PDO::PARAM_INT);
			$query->execute();
			return $query->fetchAll();
		} catch (PDOException $e) {
			ExceptionErrorHandler($e);
			return false;
		}
	}


	// CUSTOMER REGISTRATION

	// Customer details registration
	public function newCustomer($email, $firstname, $lastname, $company, $address1, $address2, $town, $county, $postcode, $phone, $notes){
		if($this->validateEmail($email)){
			if($this->emailAvailable($email)){
				try {
					$query = $this->db->prepare('INSERT INTO `customer_details` (customer_id, email, firstname, lastname, company, address1, address2, town, county, postcode, phone, notes)
						VALUES (:customer_id, :email, :firstname, :lastname, :company, :address1, :address2, :town, :county, :postcode, :phone, :notes)
					');
					$query->bindValue(':customer_id', $this->customer_id, PDO::PARAM_INT);
					$query->bindValue(':email', $email, PDO::PARAM_STR);
					$query->bindValue(':firstname', $firstname, PDO::PARAM_STR);
					$query->bindValue(':lastname', $lastname, PDO::PARAM_STR);
					$query->bindValue(':company', $company, PDO::PARAM_STR);
					$query->bindValue(':address1', $address1, PDO::PARAM_STR);
					$query->bindValue(':address2', $address2, PDO::PARAM_STR);
					$query->bindValue(':town', $town, PDO::PARAM_STR);
					$query->bindValue(':county', $county, PDO::PARAM_STR);
					$query->bindValue(':postcode', $postcode,PDO::PARAM_STR);
					$query->bindValue(':phone', $phone, PDO::PARAM_STR);
					$query->bindValue(':notes', $notes, PDO::PARAM_STR);
					$query->execute();
					return true; // Returns true if all is successful
				} catch (PDOException $e) {
					ExceptionErrorHandler($e);
					return false;
				}
			} else {
				$_SESSION['error'] = REGISTRATION_EMAIL_UNAVAILABLE_ERROR; // Returns message if the email address is already in the database
				return false;
			}
		} else {
			$_SESSION['error'] = RESGISTRATION_EMAIL_NOT_VALID; // Returns message if the email address doesn't pass validation (ie. it doesn't look like a real email address)
			return false;
		}
	}

	public function getCustomerDetails(){
		try {
			$query = $this->db->prepare('SELECT email, firstname, lastname, company, address1, address2, town, county, postcode, phone, notes
				FROM `customer_details`
				WHERE customer_id = :customer_id
			');
			$query->bindValue(':customer_id', $this->customer_id, PDO::PARAM_INT);
			$query->execute();
			return $query->fetch();
		} catch (PDOException $e) {
			ExceptionErrorHandler($e);
			return false;
		}
	}

	// UPDATEs customer details
	public function editCustomerDetails($firstname, $lastname, $company, $address1, $address2, $town, $county, $postcode, $phone, $notes){
		try {
			$query = $this->db->prepare('UPDATE `customer_details`
				SET firstname = :firstname,
					lastname = :lastname,
					company = :company,
					address1 = :address1,
					address2 = :address2,
					town = :town,
					county = :county,
					postcode = :postcode,
					phone = :phone,
					notes = :notes
				WHERE customer_id = :customer_id
			');

			$query->bindValue(':firstname', $firstname, PDO::PARAM_STR);
			$query->bindValue(':lastname', $lastname, PDO::PARAM_STR);
			$query->bindValue(':company', $company, PDO::PARAM_STR);
			$query->bindValue(':address1', $address1, PDO::PARAM_STR);
			$query->bindValue(':address2', $address2, PDO::PARAM_STR);
			$query->bindValue(':town', $town, PDO::PARAM_STR);
			$query->bindValue(':county', $county, PDO::PARAM_STR);
			$query->bindValue(':postcode', $postcode,PDO::PARAM_STR);
			$query->bindValue(':phone', $phone, PDO::PARAM_STR);
			$query->bindValue(':notes', $notes, PDO::PARAM_STR);
			$query->bindValue(':customer_id', $this->customer_id, PDO::PARAM_INT);

			$query->execute();

			return true;
		} catch (PDOException $e) {
			ExceptionErrorHandler($e);
			return false;
		}
	}

	// Validates email syntax, returns true if it looks ok, false if it doesn't
	private function validateEmail($email){
		$filter_email = filter_var($email, FILTER_SANITIZE_EMAIL);
		if($email == $filter_email && filter_var($email, FILTER_VALIDATE_EMAIL)){
			return true;
		} else {
			return false;
		}
	}

	// Checks if email address is already registered, returns true if it's available / not in the database, false otherwise
	private function emailAvailable($email){
		try {
			$query = $this->db->prepare('SELECT email
				FROM `customer_details`
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

}
