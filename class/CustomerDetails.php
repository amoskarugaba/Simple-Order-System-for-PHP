<?php

namespace CyanideSystems;

use \PDO;

class CustomerDetails {

	public function __construct(){
		$this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
		$this->error = '';
	}

	public function newCustomer($customer_id, $email, $firstname, $lastname, $company, $address1, $address2, $town, $county, $postcode, $phone, $notes){
		if($this->validateEmail($email)){
			if($this->emailAvailable($email)){
				$query = $this->db->prepare('INSERT INTO `customer_details` (customer_id, email, firstname, lastname, company, address1, address2, town, county, postcode, phone, notes)
					VALUES (:customer_id, :email, :firstname, :lastname, :company, :address1, :address2, :town, :county, :postcode, :phone, :notes)
				');
				$query->bindValue(':customer_id', $customer_id, PDO::PARAM_INT);
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
				if($query->execute()){
					return true; // Returns true if all is successful
				} else {
					$this->error .= REGISTRATION_DATABASE_INSERT_ERROR; // Returns message if registration NOT successful due to database insert error
					return false;
				}
			} else {
				$this->error .= REGISTRATION_EMAIL_UNAVAILABLE_ERROR; // Returns message if the email address is already in the database
				return false;
			}
		} else {
			$this->error .= RESGISTRATION_EMAIL_NOT_VALID; // Returns message if the email address doesn't pass validation (ie. it doesn't look like a real email address)
			return false;
		}
	}

	public function getCustomerDetails($email){
		if(!$this->emailAvailable($email)){ // Checks if the email address is in the database, returns false if it is
			$query = $this->db->prepare('SELECT email, firstname, lastname, company, address1, address2, town, county, postcode, phone, notes
				FROM `customer_details`
				WHERE email = :email
			');
			$query->bindValue(':email', $email, PDO::PARAM_STR);
			if($query->execute()){
				return $query->fetch();
			} else {
				return false;
			}
		} else {
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
	}

	// Returns any user error messages
	public function getErrors(){
		return $this->error;
	}

}

//
