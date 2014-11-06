<?php
require('../private/config.php');
require('../private/restricted_admin.php');
require('../class/Admin.php');


if(!isset($_GET['p'])){
	header('Location: awaiting_payment.php');
}

$proforma_id = (int)$_GET['p'];

$admin = new CyanideSystems\OrderSystem\Admin();

if($invoice_id = $admin->createInvoice($proforma_id)){
	header('Location: view_invoice.php?i=' . $invoice_id);
} else {
	header('Location: proformas.php');
}
