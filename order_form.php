<?php
require('private/config.php');
require('private/restricted.php');
require('class/Customer.php');

$products = new CyanideSystems\OrderSystem\Customer($_SESSION['customer_id']);

include('template/header.php');
?>

	<main role="main">

		<section>

			<h2>Order Form</h2>

			<form name="order_form" action="create_proforma.php" method="post">
				<table>
					<thead>
						<tr>
							<th>SKU</th><th>Name</th><th>Price (Ex. VAT)</th><th>VAT Rate</th><th>Quantity</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($products->getProducts() as $product){ ?>
						<tr>
							<td><?php echo $product->sku; ?></td><td><?php echo $product->product_name; ?></td><td>&pound;<?php echo $product->price; ?></td><td><?php echo $product->vat_rate; ?>%</td><td><input id="<?php echo $product->sku; ?>" name="<?php echo $product->sku; ?>" type="number" /></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<button type="submit">Generate Proforma</button>
			</form>

		</section>

	</main>

	<script src="template/assets/js/responsive_tables.min.js"></script>

<?php
include('template/footer.php');
