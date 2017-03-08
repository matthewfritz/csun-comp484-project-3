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
			<div class="row">
				<div class="col-sm-12">
					<?php
						// if there is not an active menu item, default to Home
						if(empty($activeMenuItem)) {
							$activeMenuItem = "home";
						}

						// outut the markup for the menubar
						echo menubar($activeMenuItem);
					?>
				</div>
			</div>
			<?php
				if(!empty($pageTitle)) {
					echo "<div class=\"row\">";
					echo "   <div class=\"col-sm-12\">";
					echo "      <h1>{$pageTitle}</h1>";
					echo "      <br />";
					echo "   </div>";
					echo "</div>";
				}

				// if there are errors, spit them out
				if(!empty($errors)) {
					echo "<div class=\"row\">";
					echo "   <div class=\"col-sm-12\">";
					echo "      <div class=\"alert alert-danger\">";
					echo "         <p>The following errors occurred:</p>";
					echo "         <ul>";

					// iterate over the errors
					foreach($errors as $error) {
						echo "            <li>{$error}</li>";
					}

					echo "         </ul>";
					echo "      </div>";
					echo "   </div>";
					echo "</div>";
				}
				else if(!empty($message)) {
					echo "<div class=\"row\">";
					echo "   <div class=\"col-sm-12\">";
					echo "      <div class=\"alert alert-success\">";
					echo "         {$message}";
					echo "      </div>";
					echo "   </div>";
					echo "</div>";
				}
			?>