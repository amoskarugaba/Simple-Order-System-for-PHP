<?php
require('../private/config.php');
require('../private/restricted_admin.php');
include('template/header.php');
?>

	<main role="main">

		<section>

			<h2>New Product</h2>

			<form action="add_new_product.php" method="post">
				<label for="sku">SKU Code</label>
				<input type="text" id="sku" name="sku" placeholder="SKU" />

				<label for="product_name">Product Name</label>
				<input type="text" id="product_name" name="product_name" placeholder="Product name" />

				<label for="price">Product Price</label>
				<input type="number" id="price" name="price" step="0.01" placeholder="Product price" />

				<label for="vat_rate">VAT Rate</label>
				<input type="number" id="vat_rate" name="vat_rate" step="0.1" value="20.00" />

				<label for="stock_quantity">Quantity</label>
				<input type="number" id="stock_quantity" name="stock_quantity" step="1" value="10000" />

				<button type="submit">Submit New Product</button>
			</form>

		</section>

	</main>

	<script src="js/responsive_tables.min.js"></script>

<?php
include('template/footer.php');
