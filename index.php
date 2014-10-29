<?php
require('private/config.php');
require('private/restricted.php');
include('template/header.php');
?>

	<main role="main">

		<section>

			<h2>Main Dashboard</h2>
			<p><?php echo $_SESSION['check']; ?></p>

		</section>

	</main>

<?php
include('template/footer.php');
