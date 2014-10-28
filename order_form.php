<?php
require('private/config.php');
require('private/restricted.php');
require('..class/Products.php');

$products = new CyanideSystems\Products();

include('template/header.php');
?>

	<main role="main">

		<section>

			<h2>Order Form</h2>

			<table>
				<thead>
					<tr>
						<th>SKU</th><th>Name</th><th>Price</th><th>Quantity</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach $products->getProducts() as $product { ?>
					<tr>
						<td><?php echo $product->sku; ?></td><td><?php echo $product->product_name; ?></td><td>&pound;<?php echo $product->price; ?></td><td><input id="<?php echo $product->sku; ?>" type="number" /></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>

		</section>

	</main>

	<script src="js/responsive_tables.min.js"></script>

<?php
include('template/footer.php');
