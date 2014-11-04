<?php
require('../private/config.php');
require('../private/restricted_admin.php');
require('../class/Admin.php');

$admin = new CyanideSystems\OrderSystem\Admin();

$proformas = $admin->getProformas();

include('template/header.php');
?>

	<main role="main">

		<section>

			<h2>Proformas</h2>

			<table>
				<thead>
					<tr>
						<th>Proforma ID</th><th>Proforma Date</th><th>Customer ID</th><th>View Proforma</th><th>Invoice Proforma (Payment Recieved)</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($proformas as $proforma){ ?>
					<tr>
						<td><?php echo $proforma->proforma_id; ?></td><td><?php echo $proforma->date; ?></td><td><?php echo $proforma->customer_id; ?></td><td><a href="view_proforma.php?p=<?php echo $proforma->proforma_id; ?>" target="_blank">View Proforma</a></td><td><a href="mark_invoice_paid.php?p=<?php echo $proforma->proforma_id; ?>">Mark Proforma Paid</a></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>

		</section>

	</main>

	<script src="template/assets/js/responsive_tables.min.js"></script>

<?php
include('template/footer.php');
