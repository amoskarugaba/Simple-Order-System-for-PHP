<?php
require('private/config.php');
require('private/restricted.php');
require('class/Customer.php');

$order = new CyanideSystems\OrderSystem\Customer($_SESSION['customer_id']);
var_dump($_POST);
/*
if($created = $order->createProforma($_POST)){
	header('Location: view_proforma.php?p=' . $created);
} else {
	echo 'meh';
}
*/
