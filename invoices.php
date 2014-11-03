<?php

require('private/config.php');
require('private/restricted.php');
require('class/Customer.php');

$orders = new CyanideSystems\OrderSystem\Customer($_SESSION['customer_id']);

$invoices = $orders->getInvoices();

foreach($invoices as $invoice){

	echo $invoice->invoice_id;
	echo $invoice->date;
	echo '<a href="view_invoice.php?i=' . $invoice->invoice_id . '">View Invoice</a>';

}
