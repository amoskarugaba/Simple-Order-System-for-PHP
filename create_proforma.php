<?php
require('private/config.php');
require('private/restricted.php');
require('class/Customer.php');

$order = new CyanideSystems\OrderSystem\Customer($_SESSION['customer_id']);


// createProforma returns the proforma_id
if($created = $order->createProforma($_POST)){
	header('Location: view_proforma.php?p=' . $created);
} else {
	header('Location: order_form.php');
}
