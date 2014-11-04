<?php
require('../private/config.php');
require('../private/restricted.php'); // Restrict to Admin. only
require('../class/Admin.php');

$admin = new CyanideSystems\OrderSystem\Admin();

$invoices = $admin->getInvoices();

foreach($invoices as $invoice){
	echo '<a href="view_invoice.php?i=' . $invoice->invoice_id . '">View Invoice</a>';
	echo $invoice->date;
	echo $invoice->customer_id;
}
