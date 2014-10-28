<?php
require('private/config.php');
include('template/header.php');
?>

	<main role="main">

		<section>

			<h2>Register</h2>

			<div id="response"></div>

			<form name="register">
				<input type="email" id="email" placeholder="Username (your email address)" />
				<input type="password" id="password" placeholder="Password" />
				<button type="submit">Register</button>
			</form>


		</section>

	</main>

	<script src="js/registerLogin.js"></script>

<?php
include('template/footer.php');
