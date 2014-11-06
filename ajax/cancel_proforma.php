<?php
require('../private/config.php');
require('../private/restricted.php');

$proforma_id = (int)$_GET['p'];

require('class/Customer.php');

$orders = new CyanideSystems\OrderSystem\Customer($_SESSION['customer_id']);

if($orders->cancelProforma($proforma_id)){
	echo '<p>Proforma cancelled.</p>';
} else {
	echo '<p>There was an error in cancelling your proforma.</p>';
}
