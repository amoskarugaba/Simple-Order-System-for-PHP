<?php
require('../private/config.php');
require('../private/restricted.php');
require('../class/Customer.php');

$customer = new CyanideSystems\OrderSystem\Customer($_SESSION['customer_id']);

if($customer->newCustomer($_POST['email'], $_POST['firstname'], $_POST['lastname'], $_POST['company'], $_POST['address1'], $_POST['address2'], $_POST['town'], $_POST['county'], $_POST['postcode'], $_POST['phone'], $_POST['notes'])){
	echo '<p>Registration successful.</p>';
} else {
	echo '<p>There was an error in registering your details.</p>';
}
