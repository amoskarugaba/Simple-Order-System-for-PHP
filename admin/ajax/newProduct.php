<?php
require('../../private/config.php');
require('../../private/restricted_admin.php');
require('../../class/Admin.php');

$products = new CyanideSystems\OrderSystem\Admin();

if($products->newProduct($_POST['sku'], $_POST['product_name'], $_POST['price'], $_POST['vat_rate'], $_POST['stock_quantity'])){
	echo 'Product added successfully';
} else {
	echo 'Product was not added';
}
