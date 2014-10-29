<?php

namespace CyanideSystems;

use \PDO;

class CustomerDetails {

	public function __construct(){
		$this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
		$this->error = '';
	}

	public function newCustomer($email,$firstname,$lastname,$company,$address1,$address2,$town,$county,$postcode,$phone,$notes){
		if($this->validateEmail($email)){
			if($this->emailAvailable($email)){
				$query = $this->db->prepare('INSERT INTO `customer_details`
					(email, firstname, lastname, company, address1, address2, town, county, postcode, phone, notes)
					VALUES (:email, :firstname, :lastname, :company, :address1, :address2, :town, :county, :postcode, :phone, :notes)
				');
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
					return true; // Returns this if all is successful
				} else {
					$this->error .= REGISTRATION_DATABASE_INSERT_ERROR; // Returns this if registration NOT successful due to database insert error
				}
			} else {
				$this->error .= REGISTRATION_EMAIL_UNAVAILABLE_ERROR; // Returns this if the email address is already in the database
			}
		} else {
			$this->error .= RESGISTRATION_EMAIL_NOT_VALID; // Returns this if the email address doesn't pass validation (ie. it doesn't look like a real email address)
		}
	}

	public function getCustomerDetails($email){
		if(!$this->emailAvailable($email)){ // Checks if the email address is in the database, returns false if it is
			$query = $this->db->prepare('SELECT email, firstname, lastname, company, address1, address2, town, county, postcode, phone, notes
				FROM `customer_details`
				WHERE email= :email
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

	private function validateEmail($email){
		$filter_email = filter_var($email, FILTER_SANITIZE_EMAIL);
		if($email == $filter_email && filter_var($email, FILTER_VALIDATE_EMAIL)){
			return true;
		} else {
			return false;
		}
	}

	// You could change this function to 'public' and use it in an AJAX call to check if already registered if you would like..
	private function emailAvailable($email){
		$query = $this->db->prepare('SELECT email
			FROM `customer_details`
			WHERE email= :email
		');
		$query->bindValue(':email', $email, PDO::PARAM_STR);
		$query->execute();
		if($query->rowCount() > 0){
			return false;
		} else {
			return true;
		}
	}

	public function getErrors(){
		return $this->error;
	}

}

//
