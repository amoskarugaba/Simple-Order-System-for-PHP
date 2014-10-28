<?php
require('../private/config.php');
require('../private/restricted.php');
require('../class/Products.php');

$products = new CyanideSystems\Products();

include('template/header.php');
?>

	<main role="main">

		<section>

			<h2>Products</h2>

			<table>
				<thead>
					<tr>
						<th>SKU</th><th>Name</th><th>Price</th><th>Quantity</th><th class="editproduct">Edit</th><th class="editingproduct" style="display:none;">Confirm</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($products->getProducts() as $product){ ?>
					<tr>
						<td><?php echo $product->sku; ?></td><td><?php echo $product->product_name; ?></td><td>&pound;<?php echo $product->price; ?></td><td><?php echo $product->sku; ?></td><th class="editproduct"><a href="ajax/editProduct.php?sku=<?php echo $product->sku; ?>">Edit</a></th><th class="editingproduct" style="display:none;">Confirm</th>
					</tr>
					<?php } ?>
				</tbody>
			</table>

		</section>

	</main>

	<script src="../js/responsive_tables.min.js"></script>

	<!--<script>
		// NOT WORKING (YET)
		document.addEventListener("DOMContentLoaded", function(){
			document.getElementsByClassName('editproduct').addEventListener("click", editProduct, false);
		});

		function editProduct(line){
			var editproduct = document.getElementsByClassName('editproduct');
			var editingproduct = document.getElementsByClassName('editingproduct');
			for(var i = 0, n = editproduct.length; i < n; i++){
				editproduct[i].style = 'display:none';
			}
		}
	</script>-->

<?php
include('template/footer.php');
