<?php
require('private/config.php');
require('class/Orders.php');

var_dump($_POST);

$order = new CyanideSystems\Orders(1);

if($order->createProforma($_POST)){
	echo 'yay';
} else {
	echo 'boooo';
}
