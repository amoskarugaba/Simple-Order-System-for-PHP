<?php

// TO Do: Implement error logging that's a bit "smoother"

namespace CyanideSystems\OrderSystem;

use \PDO;
use \PHPMailer;

class Login {

	public function __construct(){
		$this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	}

	public function registerUser($email, $password){
		if($this->validateEmail($email)){
			if($this->emailAvailable($email)){
				$hash = password_hash($password, PASSWORD_DEFAULT);
				$query = $this->db->prepare('INSERT INTO `site_logins` (email, hash)
					VALUES (:email, :hash)
				');
				$query->bindValue(':email', $email, PDO::PARAM_STR);
				$query->bindValue(':hash', $hash, PDO::PARAM_STR);
				if($query->execute()){
					if(!$this->sendConfirmation($email)){
						$_SESSION['error'] = REGISTRATION_SUCCESSFUL_EMAIL_NOT_SENT; // Returns this if registration successful, but confirmation email not sent
					}
					// This makes sure that the person logged in is the same as accessing the restricted page (include 'private/restricted.php' at the top of each page)
					$radd = $_SERVER['REMOTE_ADDR'];
					$hxff = getenv('HTTP_X_FORWARDED_FOR');
					$agent = $_SERVER['HTTP_USER_AGENT'];
					// $_SESSION['check'] checks against the $check variable in 'private/restricted.php'
					$_SESSION['check'] = hash('sha256', $radd . $hxff . $agent);
					$_SESSION['customer_id'] = $this->getCustomerID($email);
					$_SESSION['email'] = $email;
					return true;
				} else {
					error_log('Database Error: Failed to INSERT registration details into `site_logins`', 0);
					$_SESSION['error'] = REGISTRATION_DATABASE_INSERT_ERROR; // Returns message if registration NOT successful due to database insert error
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

	private function sendConfirmation($email){
		require('PHPMailer/PHPMailerAutoload.php');

		// This is a bit of a rudimentary email templating engine, basically it does a string replace of EMAILADDRESSOFREGISTERINGUSER with $email
		$html_email_template = file_get_contents('private/email_templates/email.html');
		$html_content = str_replace('EMAILADDRESSOFREGISTERINGUSER', $email, $html_email_template);
		$plain_email_template = file_get_contents('private/email_templates/email.txt');
		$plain_content = str_replace('EMAILADDRESSOFREGISTERINGUSER', $email, $plain_email_template);
		$mail = new PHPMailer();

		//$mail->SMTPDebug = 3;									// Enable verbose debug output

		$mail->isSMTP();										// Set mailer to use SMTP
		$mail->Host = MAIL_SMTP_HOST;							// Specify main and backup SMTP servers ('smtp.example.com')
		$mail->SMTPAuth = MAIL_SMTP_AUTH;						// Enable SMTP authentication (true/false)
		$mail->Username = MAIL_SMTP_USERNAME;					// SMTP username ('user@example.com')
		$mail->Password = MAIL_SMTP_PASSWORD;					// SMTP password
		$mail->SMTPSecure = MAIL_SMTP_SECURITY;					// Enable TLS or SSL ('tls'/'ssl')
		$mail->Port = MAIL_SMTP_PORT;							// TCP port (587)

		$mail->From = SITE_EMAIL_ADDRESS;						// Email from ('reed@example.com')
		$mail->FromName = SITE_NAME;							// Name ('Elliot Reed')
		$mail->addAddress($email);								// Add a recipient, name optional (('elliot@example.com', 'Elliot Reed') or ('elliot@example.com'))

		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');	// Add an attachment, name optional (('/tmp/image.jpg', 'new.jpg') or ('/tmp/image.jpg'))
		$mail->isHTML(true);									// Set email format to HTML (true/false)

		$mail->Subject = 'Registration Confirmation';			// Email subject ('Welcome!')
		$mail->Body = $html_content;							// HTML email content ('<p>You have registered successfully!</p>')
		$mail->AltBody = $plain_content;						// Plain text email content ('You have registered successfully!')

		if($mail->send()){
			return true;
		} else {
			error_log('PHPMailer Error: ' . $mail->ErrorInfo, 0);
			return false;
		}
	}

	// You could change this function to 'public' and use it in an AJAX call to check if already registered if you would like..
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

	public function verifyLogin($email, $password){
		// Returns true on correct email/password
		$hash = $this->getHash($email);
		if(password_verify($password, $hash)){
			// This makes sure that the person logged in is the same as accessing the restricted page (include 'private/restricted.php' at the top of each page)
			$radd = $_SERVER['REMOTE_ADDR'];
			$hxff = getenv('HTTP_X_FORWARDED_FOR');
			$agent = $_SERVER['HTTP_USER_AGENT'];
			// $_SESSION['check'] checks against the $check variable in 'private/restricted.php'
			$_SESSION['check'] = hash('sha256', $radd . $hxff . $agent);
			$_SESSION['customer_id'] = $this->getCustomerID($email);
			$_SESSION['email'] = $email;
			return true;
		} else {
			$_SESSION['error'] = INCORRECT_LOGIN_CREDENTIALS;
			return false;
		}
	}

	private function getHash($email){
		try {
			$query = $this->db->prepare('SELECT hash
				FROM `site_logins`
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


	private function getCustomerID($email){
		try {
			$query = $this->db->prepare('SELECT customer_id
				FROM `site_logins`
				WHERE email = :email
			');
			$query->bindValue(':email', $email, PDO::PARAM_STR);
			$query->execute();
			$check = $query->fetch();
			return $check->customer_id;
		} catch (PDOException $e) {
			ExceptionErrorHandler($e);
			return false;
		}
	}

	// TO-DO: Implement this correctly!
	private function passwordRehash($email,$hash){
		if(password_needs_rehash($hash, PASSWORD_DEFAULT)){
			$hash = password_hash($password, PASSWORD_DEFAULT);
			$query = $this->db->prepare('UPDATE `site_logins`
				SET hash = :hash
				WHERE email = :email
			');
			$query->bindValue(':hash', $hash, PDO::PARAM_STR);
			$query->bindValue(':email', $email, PDO::PARAM_STR);
			if($query->execute()){
				return true;
			} else {
				error_log('Database Error: Failed to UPDATE hash in `site_logins` for password_needs_rehash', 0);
				return false;
			}
		} else {
			return false;
		}
	}
}
