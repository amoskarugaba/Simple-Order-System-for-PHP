<?php

// Probably not required as paid proformas will have been invoiced

require('private/config.php');
require('private/restricted.php');
require('class/Orders.php');

$orders = new CyanideSystems\Orders($_SESSION['customer_id']);

$proformas = $orders->getPaidProformas();

foreach($proformas as $proforma){

	echo $proforma->proforma_id;
	echo $proforma->date;
	echo $proforma->discount;
	echo $proforma->order_total;

}
