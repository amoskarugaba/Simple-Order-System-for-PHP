<?php
require('../private/config.php');
require('../private/restricted_admin.php'); // Restrict to Admin. only
require('../class/Admin.php');

$admin = new CyanideSystems\OrderSystem\Admin();

$invoices = $admin->getInvoices();

include('template/header.php');
?>

	<main role="main">

		<section>

			<h2>Proformas</h2>

			<table>
				<thead>
					<tr>
						<th>Invoice ID</th><th>Invoice Date</th><th>Customer ID</th><th>View Invoice</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($invoices as $invoice){ ?>
					<tr>
						<td><?php echo $invoice->invoice_id; ?></td><td><?php echo $invoice->date; ?></td><td><?php echo $invoice->customer_id; ?></td><td><a href="view_invoice.php?i=<?php echo $invoice->invoice_id; ?>" target="_blank">View Invoice</a></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>

		</section>

	</main>

	<script src="template/assets/js/responsive_tables.min.js"></script>

<?php
include('template/footer.php');
