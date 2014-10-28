<?php
require('private/config.php');
include('template/header.php');
?>

	<main role="main">

		<section>

			<h2>Login</h2>
			<p>If you have not yet created an account with us, please click <a href="register.php">here</a> to do so now.</p>
			<div id="response"></div>

			<form name="login">
				<input type="email" id="email" placeholder="Username (your email address)" required="required" />
				<input type="password" id="password" placeholder="Password" required="required" />
				<button type="submit">Login</button>
			</form>

		</section>

	</main>

	<script src="js/login.js"></script>

<?php
include('template/footer.php');
