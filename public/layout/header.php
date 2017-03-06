<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php
				$title = env("APP_TITLE");
				echo (!empty($title) ? env("APP_TITLE") : "My Application");
			?>
			<?php echo (!empty($pageTitle) ? " | ${pageTitle}" : ""); ?>
		</title>

		<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />

		<script type="text/javascript" src="assets/jquery/jquery-3.1.1.min.js"></script>
		<script type="text/javascript" src="assets/tether/tether.min.js"></script>
		<script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="assets/socket/socket.io.1.7.3.min.js"></script>
	</head>
	<body>
		<div class="container">
			<?php
				if(!empty($pageTitle)) {
					echo "<div class=\"row\">";
					echo "   <div class=\"col-sm-12\">";
					echo "      <h1>{$pageTitle}</h1>";
					echo "   </div>";
					echo "</div>";
				}
			?>

			<div class="row">
				<div class="col-sm-12">
					<nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
					  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					    <span class="navbar-toggler-icon"></span>
					  </button>
					  <a class="navbar-brand" href="#">Tsarbucks</a>
					  <div class="collapse navbar-collapse" id="navbarNav">
					    <ul class="navbar-nav">
					      <li class="nav-item active">
					        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
					      </li>
					      <li class="nav-item">
					        <a class="nav-link" href="#">Features</a>
					      </li>
					      <li class="nav-item">
					        <a class="nav-link" href="#">Pricing</a>
					      </li>
					    </ul>
					  </div>
					</nav>
				</div>
			</div>