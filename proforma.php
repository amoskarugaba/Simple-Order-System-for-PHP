<?php
require('private/config.php');
require('private/restricted.php');
require('class/Orders.php');

$order = new CyanideSystems\Orders($_SESSION['customer_id']);

if($order->createProforma($_POST)){
	echo 'proforma created';
} else {
	echo 'meh';
}
