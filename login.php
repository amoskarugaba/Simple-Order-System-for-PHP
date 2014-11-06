<?php
require('private/config.php');
include('template/header.php');
?>

	<main role="main">

		<section>

			<h2>Login</h2>
			<p>If you have not yet created an account with us, please click <a href="register.php">here</a> to do so now.</p>

			<form name="login" action="attempting_login.php" method="post">
				<input type="email" id="email" name="email" placeholder="Username (your email address)" required="required" />
				<input type="password" id="password" name="password" placeholder="Password" minlength="8" maxlength="64" required="required" />
				<button type="submit">Login</button>
			</form>

		</section>

	</main>

<?php
include('template/footer.php');
