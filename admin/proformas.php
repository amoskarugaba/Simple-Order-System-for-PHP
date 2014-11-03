<?php
require('../private/config.php');
require('../private/restricted.php');
require('../class/Admin.php');

$admin = new CyanideSystems\OrderSystem\Admin();

$proformas = $admin->getProformas();

foreach($proformas as $proforma){
	echo '<a href="mark_invoice_paid.php?p=' . $proforma->proforma_id . '">Mark Proforma Paid</a>';
	echo $proforma->date;
	echo $proforma->customer_id;
	echo '<a href="view_proforma.php?p=' . $proforma->proforma_id . '">View Proforma</a>';
}
