<?php
require('private/config.php');
require('private/restricted.php');

if(!isset($_GET['i'])){
	header('Location: paid_invoices.php');
}

$invoice_id = (int)$_GET['i'];

require('class/Customer.php');

$customer_details = new CyanideSystems\OrderSystem\CustomerDetails();
$order = new CyanideSystems\OrderSystem\Orders($_SESSION['customer_id']);

$invoice = $order->getInvoiceMain($invoice_id);

$invoice_lines = $order->getInvoiceLines($invoice_id);

$customer = $customer_details->getCustomerDetails();

?>
<!doctype html>
<html lang="en-GB">
	<head>
		<meta charset="utf-8" />
		<title>invoice ID: <?php echo $invoice->invoice_id; ?></title>
		<link rel="stylesheet" href="template/assets/css/invoice.min.css" />
	</head>
	<body>
		<p class="return"><a href="/index.php" target="_blank">[Return to Main Dashboard]</a></p>
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
						FAO: <?php echo $customer->firstname; ?> <?php echo $customer->lastname; ?><br />
						<?php echo $customer->company; ?><br />
						<?php echo $customer->address1; ?><br />
						<?php echo $customer->address2; ?><br />
						<?php echo $customer->town; ?><br />
						<?php echo $customer->county; ?><br />
						<?php echo $customer->postcode; ?><br />
						<?php echo $customer->phone; ?>
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
						<td><span data-prefix>&pound; </span><span><?php echo $invoice->order_total; ?></span></td>
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
									<td><span><?php echo $invoice_line->product_sku; ?></span></td>
									<td><span data-prefix>&pound; </span><span><?php echo $invoice_line->line_price; ?></span></td>
									<td><span><?php echo $invoice_line->vat_rate; ?>%</span></td>
									<td><span data-prefix>&pound; </span><span>TODO</span></td>
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
						<td><span data-prefix>&pound; </span><span></span></td>
					</tr>
					<tr>
						<th><span>Total</span></th>
						<td><span data-prefix>&pound; </span><span><?php echo $invoice->order_total; ?></span></td>
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
