<?php
require('private/config.php');
require('private/restricted.php');

if(!isset($_GET['i'])){
	header('Location: paid_invoices.php');
}

$invoice_id = (int)$_GET['i'];

require('class/Customer.php');

$order = new CyanideSystems\OrderSystem\Customer($_SESSION['customer_id']);

$invoice = $order->getInvoiceMain($invoice_id);

$invoice_lines = $order->getInvoiceLines($invoice_id);

?>
<!doctype html>
<html lang="en-GB">
	<head>
		<meta charset="utf-8" />
		<title>invoice ID: <?php echo $invoice->invoice_id; ?></title>
		<link rel="stylesheet" href="template/assets/css/invoice.min.css" />
	</head>
	<body>
		<p class="return"><a href="invoices.php" target="_blank">[Return to Invoices]</a></p>
		<section class="page-break">
			<br />
			<header>
				<h1>invoice</h1>
				<address>
					<p>Polyverse Ltd. (T/A: Bluebelles)</p>
					<p>Enterprise Park, Wigwam Lane</p>
					<p>Hucknall, NG15 7SZ</p>
					<p>0115 963 6696</p>
				</address>
				<span><img alt="Bluebelles" src="template/assets/img/logo.png" /></span>
			</header>
			<article>
				<h1>Recipient</h1>
				<address>
					<p class="address">
						FAO: <?php echo $invoice->firstname; ?> <?php echo $invoice->lastname; ?><br />
						<?php echo $invoice->company; ?><br />
						<?php echo $invoice->address1; ?><br />
						<?php echo $invoice->address2; ?><br />
						<?php echo $invoice->town; ?><br />
						<?php echo $invoice->county; ?><br />
						<?php echo $invoice->postcode; ?><br />
						<?php echo $invoice->phone; ?>
					</p>
				</address>
				<table class="meta">
					<tr>
						<th><span>invoice ID</span></th>
						<td><span><?php echo $invoice->invoice_id; ?></span></td>
					</tr>
					<tr>
						<th><span>Date of Issue</span></th>
						<td><span><?php echo $invoice->date; ?></span></td>
					</tr>
					<tr>
						<th><span>Amount Due</span></th>
						<td><span data-prefix>&pound; </span><span><?php echo $invoice->total_gross; ?></span></td>
					</tr>
				</table>
				<table class="inventory">
					<thead>
						<tr>
							<th><span>Quantity</span></th>
							<th><span>Item (SKU)</span></th>
							<th><span>Amount (Ex. VAT)</span></th>
							<th><span>VAT Rate</span></th>
							<th><span>VAT Net.</span></th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach($invoice_lines as $invoice_line){ ?>
								<tr>
									<td><span><?php echo $invoice_line->quantity; ?></span></td>
									<td><span><?php echo $invoice_line->product_sku; ?> at <?php echo $invoice_line->line_price; ?></span></td>
									<td><span data-prefix>&pound; </span><span><?php echo $invoice_line->line_total; ?></span></td>
									<td><span><?php echo $invoice_line->vat_rate; ?>%</span></td>
									<td><span data-prefix>&pound; </span><span><?php echo $invoice_line->vat_net; ?></span></td>
								</tr>
						<?php } ?>
						<tr>
							<td><span>1</span></td>
							<td><span>Delivery</span></td>
							<td><span data-prefix>&pound; </span><span></span></td>
							<td><span>%</span></td>
							<td><span data-prefix>&pound; </span><span></span></td>
						</tr>
					</tbody>
				</table>
				<table class="balance">
					<tr>
						<th><span>VAT</span></th>
						<td><span data-prefix>&pound; </span><span><?php echo $invoice->total_vat_net; ?></span></td>
					</tr>
					<tr>
						<th><span>Total (Net.)</span></th>
						<td><span data-prefix>&pound; </span><span><?php echo $invoice->total; ?></span></td>
					</tr>
					<tr>
						<th><span>Total (Gross)</span></th>
						<td><span data-prefix>&pound; </span><span><?php echo $invoice->total_gross; ?></span></td>
					</tr>
				</table>
			</article>
			<aside>
				<h1><span>Products Ordered</span></h1>
				<div>
					<ul>
						<li>TODO</li>
					</ul>
				</div>
			</aside>
		</section>
	</body>
</html>
