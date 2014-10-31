<?php
require('../private/config.php');
require('../private/restricted.php');
require('../class/Admin.php');


if(!isset($_GET['p'])){
	header('Location: awaiting_payment.php');
}

$proforma_id = (int)$_GET['p'];

$admin = new CyanideSystems\OrderSystem\Admin();

if($admin->createInvoice($proforma_id)){
	echo 'Invoice created';
} else {
	echo 'Invoice not created';
}
