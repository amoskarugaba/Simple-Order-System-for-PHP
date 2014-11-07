<!DOCTYPE html>
<html lang="en-GB">
<head>
	<meta charset="utf-8" />
	<title>Simple Order System for PHP</title>
	<meta name="description" content="Example usage of the Simple Order System for PHP" />
	<meta name="author" content="Elliot J. Reed" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="apple-touch-icon" href="apple-touch-icon.png" />
	<link rel="stylesheet" href="template/assets/css/normalise.css" />
	<link rel="stylesheet" href="template/assets/css/tables.css" />

</head>

<body>

	<header role="banner">
		<nav role="navigation">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="order_form.php">Order Form</a></li>
				<li><a href="edit_details.php">Edit Customer details</a></li>
				<li><a href="invoices.php">Invoices (Paid)</a></li>
				<li><a href="proformas.php">Proformas (Unpaid)</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</nav>
	</header>

	<?php echo $user_message; ?>
