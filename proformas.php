<?php
require('private/config.php');
require('private/restricted.php');
require('class/Customer.php');

$orders = new CyanideSystems\OrderSystem\Customer($_SESSION['customer_id']);

$unpaid_proformas = $orders->getProformas();

foreach($unpaid_proformas as $proforma){

	echo '<a href="view_proforma.php?p=' . $proforma->proforma_id . '">View</a>';
	echo $proforma->date;
	echo $proforma->discount;
	echo $proforma->order_total;
	echo '<a href="cancel_proforma.php?p=' . $proforma->proforma_id . '">Cancel Proforma</a>';

}
