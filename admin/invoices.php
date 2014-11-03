<?php
require('../private/config.php');
require('../private/restricted.php');
require('../class/Admin.php');

$admin = new CyanideSystems\OrderSystem\Admin();

$invoices = $admin->getInvoices();

foreach($invoices as $invoice){
	echo '<a href="view_invoice.php?i=' . $invoice->proforma_id . '">View Invoice</a>';
	echo $invoice->date;
	echo $invoice->discount;
	echo $invoice->order_total;
	echo $invoice->customer_id;
}
