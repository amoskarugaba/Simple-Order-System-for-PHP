<?php
require('../private/config.php');
require('../private/restricted.php');
require('../class/Customer.php');

$order = new CyanideSystems\OrderSystem\Customer($_SESSION['customer_id']);

// createProforma returns the proforma_id
if($created = $order->createProforma($_POST)){
	echo '<p>Your order details have been received and are now awaiting payment. To view or print your proforma please click <a href="view_proforma.php?p=' . $created . '" target="_blank">here</a></p> ';
} else {
	echo '<p>There was an error submitting your order details</p>';
}
