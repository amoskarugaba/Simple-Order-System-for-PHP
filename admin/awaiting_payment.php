<?php
require('../private/config.php');
require('../private/restricted.php');
require('../class/Admin.php');

$admin = new CyanideSystems\OrderSystem\Admin();

$unpaid_proformas = $admin->getAllUnpaidProformas();

foreach($unpaid_proformas as $proforma){
	echo '<a href="mark_invoice_paid.php?p=' . $proforma->proforma_id . '&c=' . $proforma->customer_id . '">Mark Proforma Paid"</a>';
	echo $proforma->date;
	echo $proforma->discount;
	echo $proforma->order_total;
	echo $proforma->customer_id;
}
