<?php
require('../private/config.php');
require('../private/restricted.php');
require('../class/Products.php');

$products = new CyanideSystems\Products();

if($products->editProduct($_POST['sku'], $_POST['product_name'], $_POST['price'], $_POST['stock_quantity'])){
	echo 'Product edited successfully';
} else {
	echo 'Product was not edited';
}
