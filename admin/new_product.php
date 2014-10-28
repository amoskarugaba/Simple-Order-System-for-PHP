<?php
require('private/config.php');
require('private/restricted.php');
include('template/header.php');
?>

	<main role="main">

		<section>

			<h2>New Product</h2>

			<form action="ajax/newProduct.php" method="post">
				<label for="sku">SKU Code</label>
				<input type="text" id="sku" name="sku" placeholder="SKU" />

				<label for="product_name">Product Name</label>
				<input type="text" id="product_name" name="product_name" placeholder="Product name" />

				<label for="price">Product Price</label>
				<input type="number" id="price" name="price" step="0.01" placeholder="Product price" />

				<label for="quantity">Quantity</label>
				<input type="number" id="quantity" name="quantity" step="1" placeholder="Stock quantity" value="10000" />

				<button type="submit">Submit New Product</button>
			</form>

		</section>

	</main>

	<script src="js/responsive_tables.min.js"></script>

<?php
include('template/footer.php');
