<?php
require('../../private/config.php');
require('../../private/restricted.php');
require('../../class/Products.php');

$products = new CyanideSystems\Products();

if($products->newProduct($_POST['sku'], $_POST['product_name'], $_POST['price'], $_POST['vat_rate'], $_POST['stock_quantity'])){
	echo 'Product added successfully';
} else {
	echo 'Product was not added';
}
