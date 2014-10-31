<?php
require('private/config.php');
require('private/restricted.php');


if(!isset($_GET['p'])){
	header('Location: unpaid_proformas.php');
}

$proforma_id = (int)$_GET['p'];

require('class/Orders.php');

$orders = new CyanideSystems\Orders($_SESSION['customer_id']);

if($orders->cancelProforma($proforma_id)){
	echo 'Proforma cancelled.';
} else {
	echo 'Proforma not cancelled';
}
