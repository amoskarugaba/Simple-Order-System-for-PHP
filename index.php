<?php
require('private/config.php');
include('template/header.php');
?>

	<main role="main">

		<section>

			<h2>Register</h2>

			<form action="register.php" method="post">
				<input type="email" name="email" placeholder="Username (your email address)" />
				<input type="password" name="password" placeholder="Password" />
				<button type="submit">Register</button>
			</form>


		</section>

		<section>

			<h2>Login</h2>

			<form action="login.php" method="post">
				<input type="email" name="email" placeholder="Username (your email address)" />
				<input type="password" name="password" placeholder="Password" />
				<button type="submit">Login</button>
			</form>

		</section>

	</main>

<?php
include('template/footer.php');
