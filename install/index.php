<?php
require('../private/config.php');
include('../template/header.php');
?>

	<main role="main">

		<section>

			<h2>Register New Administrator</h2>
			<p>Welcome to the Simple Order System for PHP!</p>
			<p>Please enter an email address for your new admin. account below, and choose a strong password. You'll then be directed to your new admin. dashboard where you can add products, other users, etc., and then manage invoices and proformas from customers.</p>
			<p><strong>Important:</strong> Once you have registered your admin. details below, please delete the 'install' directory / folder.</p>

			<?php echo $user_error; ?>

			<form name="register" action="install.php" method="post">
				<input type="email" id="email" name="email" placeholder="Username (your email address)" required="required" />
				<input type="password" id="password" name="password" placeholder="Password" minlength="8" maxlength="64" required="required" />
				<button type="submit">Register</button>
			</form>


		</section>

	</main>

<?php
include('../template/footer.php');
