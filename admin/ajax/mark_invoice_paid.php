<?php
require('../../private/config.php');
require('../../private/restricted_admin.php');
require('../../class/Admin.php');


if(!isset($_GET['p'])){
	echo '<p>Invoice creation was unsuccessful.</p>';
}

$proforma_id = (int)$_GET['p'];

$admin = new CyanideSystems\OrderSystem\Admin();

if($invoice_id = $admin->createInvoice($proforma_id)){
	echo '<p>Incoice created. Click <a href="view_invoice.php?i=' . $invoice_id . '" target="_blank">here</a> to view it.</p>';
} else {
	echo '<p>Invoice creation was unsuccessful.</p>';
}
