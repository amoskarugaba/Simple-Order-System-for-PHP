<?php
require('../private/config.php');
require('../private/restricted_admin.php');

if(!isset($_GET['p'])){
	header('Location: proformas.php');
}

$proforma_id = (int)$_GET['p'];

require('../class/Admin.php');

$order = new CyanideSystems\OrderSystem\Admin();

$proforma = $order->getProformaMain($proforma_id);

$proforma_lines = $order->getProformaLines($proforma_id);


?>
<!doctype html>
<html lang="en-GB">
	<head>
		<meta charset="utf-8" />
		<title>Proforma ID: <?php echo $proforma->proforma_id; ?></title>
		<link rel="stylesheet" href="template/assets/css/invoice.min.css" />
	</head>
	<body>
		<p class="return"><a href="proformas.php" target="_blank">[Return to Proformas]</a></p>
		<section class="page-break">
			<br />
			<header>
				<h1>Proforma</h1>
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
						FAO: <?php echo $proforma->firstname; ?> <?php echo $proforma->lastname; ?><br />
						<?php echo $proforma->company; ?><br />
						<?php echo $proforma->address1; ?><br />
						<?php echo $proforma->address2; ?><br />
						<?php echo $proforma->town; ?><br />
						<?php echo $proforma->county; ?><br />
						<?php echo $proforma->postcode; ?><br />
						<?php echo $proforma->phone; ?>
					</p>
				</address>
				<table class="meta">
					<tr>
						<th><span>Proforma ID</span></th>
						<td><span><?php echo $proforma->proforma_id; ?></span></td>
					</tr>
					<tr>
						<th><span>Date of Issue</span></th>
						<td><span><?php echo $proforma->date; ?></span></td>
					</tr>
					<tr>
						<th><span>Amount Due</span></th>
						<td><span data-prefix>&pound; </span><span><?php echo $proforma->total_gross; ?></span></td>
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
							foreach($proforma_lines as $proforma_line){ ?>
								<tr>
									<td><span><?php echo $proforma_line->quantity; ?></span></td>
									<td><span><?php echo $proforma_line->product_sku; ?> <small>at &pound; <?php echo $proforma_line->line_price; ?> each</small></span></td>
									<td><span data-prefix>&pound; </span><span><?php echo $proforma_line->line_total; ?></span></td>
									<td><span><?php echo $proforma_line->vat_rate; ?>%</span></td>
									<td><span data-prefix>&pound; </span><span><?php echo $proforma_line->vat_net; ?></span></td>
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
						<td><span data-prefix>&pound; </span><span><?php echo $proforma->total_vat_net; ?></span></td>
					</tr>
					<tr>
						<th><span>Total (Net.)</span></th>
						<td><span data-prefix>&pound; </span><span><?php echo $proforma->total; ?></span></td>
					</tr>
					<tr>
						<th><span>Total (Gross)</span></th>
						<td><span data-prefix>&pound; </span><span><?php echo $proforma->total_gross; ?></span></td>
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
