<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
require('private/config.php');
require('class/Orders.php');
$order = new CyanideSystems\Orders(1);

if($order->createProforma($_POST)){
	echo 'yay';
} else {
	echo 'boooo';
}
