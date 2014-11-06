<?php
require('private/config.php');
include('template/header.php');
?>

	<main role="main">

		<section>

			<h2>Register</h2>

			<form name="register" action="register_details.php" method="post">
				<input type="email" id="email" name="email" placeholder="Username (your email address)" required="required" />
				<input type="password" id="password" name="password" placeholder="Password" minlength="8" maxlength="64" required="required" />
				<button type="submit">Register</button>
			</form>


		</section>

	</main>

<?php
include('template/footer.php');
