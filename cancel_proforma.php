<?php
require('private/config.php');
require('private/restricted.php');


if(!isset($_GET['p'])){
	header('Location: unpaid_proformas.php');
}

$proforma_id = (int)$_GET['p'];

require('class/Customer.php');

$orders = new CyanideSystems\OrderSystem\Customer($_SESSION['customer_id']);

if($orders->cancelProforma($proforma_id)){
	echo 'Proforma cancelled.';
} else {
	echo 'Proforma not cancelled';
}
