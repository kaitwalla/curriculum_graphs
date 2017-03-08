<?php
define( 'WP_USE_THEMES', false );
define( 'COOKIE_DOMAIN', false );
define( 'DISABLE_WP_CRON', true );

require_once('../wp-load.php');
require_once('inc/class_management.php');

$manage = new Management();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Curriculum Graph Manager</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link rel="stylesheet" href="css/backend.css">
</head>
	<body class="backend">
<nav class="navbar navbar-inverse bg-inverse">
		<a href="javascript://" class="navbar-brand">Curriculum Graph Management</a>
	</nav>
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<?php
				if (is_user_logged_in() && current_user_can('administrator')) {
					$manage->print_top_buttons();
				} else { ?>
				<p>You need to be logged in to use this system.</p>
				<a href="/wp-admin" class="btn btn-primary">Login</a>
				<?php
				}
			?>
		</div>
	</div>
</div>

<div id="primary-modal" class="modal fade hide">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h2></h2>
			</div>
			<div class="modal-body">
				<form>
					<input type="hidden" name="purpose">
					<input type="hidden" name="id">
					<div clas="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" name="name">
					</div>
				</form>
			</div>
			<div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary" data-action="save">Save</button>
			</div>
		</div>
	</div>
</div>

<div id="secondary-modal" class="modal fade hide">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<p class="content"></p>
			</div>
			<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
			</div>
		</div>
	</div>
</div>

<div id="ajax-warning">
	<div class="img">
		<img src="images/50.gif" />
		<p>Working ...</p>
	</div>
</div>
<?php if (is_user_logged_in() && current_user_can('administrator')) { ?>
	<input type="hidden" name="security_token" value="<?php print $creds->security_token; ?>" />
<?php } ?>

<script src="https://code.jquery.com/jquery-3.1.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</body>
</html>