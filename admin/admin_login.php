<?php
require('../private/config.php');
include('template/header.php');
?>

	<main role="main">

		<section>

			<h2>Administrator Login</h2>

			<?php echo $user_error; ?>

			<form name="login" action="attempting_admin_login.php" method="post">
				<input type="email" id="email" name="email" placeholder="Username (your email address)" required="required" />
				<input type="password" id="password" name="password" placeholder="Password" minlength="8" maxlength="64" required="required" />
				<button type="submit">Login</button>
			</form>

		</section>

	</main>

<?php
include('template/footer.php');
