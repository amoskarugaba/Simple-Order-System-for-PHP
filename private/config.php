<?php

// This must be required at the top of every PHP page / script that is presented to the user (ie. everything not in 'class' or 'private' directories)

session_start();

// Set timezone (if this is set in your php.ini file you can remove this!)
date_default_timezone_set('Europe/London');

// Error reporting - turn off when in production/live (if this is set in your php.ini file you can remove this!)
error_reporting(E_ALL);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


// User and Error Messages in Login.php - Edit these to make them a bit more personal to your site / end users.
define('REGISTRATION_SUCCESSFUL_EMAIL_SENT', 'You have successfully registered. You should recieve an email confirming your registration.');
define('REGISTRATION_SUCCESSFUL_EMAIL_NOT_SENT', 'You have successfully registered, but we were unable to send a confirmation email.');
define('REGISTRATION_DATABASE_INSERT_ERROR', 'There was an error in registering you, please contact us so that we can resolve the issue.');
define('REGISTRATION_EMAIL_UNAVAILABLE_ERROR', 'The email address you have entered is already registered with us. Please login using your existing credentials.');
define('RESGISTRATION_EMAIL_NOT_VALID', 'The email address you have entered appears to be invalid. Please try again.');

// Database settings
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'invoice');
define('DB_USER', 'root');
define('DB_PASS', '');

// PHPMailer settings
define('MAIL_SMTP_HOST', 'smtp.example.com');
define('MAIL_SMTP_AUTH', true);
define('MAIL_SMTP_USERNAME', 'user@example.com');
define('MAIL_SMTP_PASSWORD', 'password');
define('MAIL_SMTP_SECURITY', 'tls');
define('MAIL_SMTP_PORT', 587);

// User error handling - any user errors (such as incorrect login credentials) are set in a session for a 'cleaner' feel for the end user
if(isset($_SESSION['user_message'])){
	$user_message = $_SESSION['user_message'];
	unset($_SESSION['user_message']);
} else {
	$user_message = null;
}
