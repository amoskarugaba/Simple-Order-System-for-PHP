<?php

require('private/config.php');
require('private/restricted.php');
require('class/Orders.php');

$orders = new CyanideSystems\Orders($_SESSION['customer_id']);

$invoices = $orders->getPaidInvoices();

foreach($invoices as $invoice){

	echo $invoice->invoice_id;
	echo $invoice->date;
	echo $invoice->discount;
	echo $invoice->order_total;
	echo '<a href="view_invoice.php?i=' . $invoice->invoice_id . '">View Invoice</a>';

}
