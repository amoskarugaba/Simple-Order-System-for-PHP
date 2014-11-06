<?php
require('private/config.php');
require('private/restricted.php');


if(!isset($_GET['p'])){
	header('Location: proformas.php');
}

$proforma_id = (int)$_GET['p'];

require('class/Customer.php');

$orders = new CyanideSystems\OrderSystem\Customer($_SESSION['customer_id']);

$orders->cancelProforma($proforma_id);

header('Location: proformas.php');
