<?php
require('../private/config.php');
require('../class/CustomerDetails.php');

$customer = new CyanideSystems\CustomerDetails();

echo $customer->newCustomer($_POST['email'],$_POST['firstname'],$_POST['lastname'],$_POST['company'],$_POST['address1'],$_POST['address2'],$_POST['town'],$_POST['county'],$_POST['postcode'],$_POST['phone'],$_POST['notes']);
