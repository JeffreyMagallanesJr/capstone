<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Neon Admin Panel" />
	<meta name="author" content="" />

	<link rel="icon" href="/capstone/template/assets/images/favicon.ico">

	<title>Digitalized Document Management System | Dashboard</title>

	<?php include('../components/common-styles.php') ?>

</head>

<body class="page-body  page-fade" data-url="http://neon.dev">

	<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->

		<?php include('../components/sidebar.php') ?>

		<div class="main-content">

			<div class="row">

				<!-- Profile Info and Notifications -->
				<?php include('../components/navbar.php') ?>

			</div>

			<hr />


			<script type="text/javascript">
				jQuery(document).ready(function($) {
					// Sample Toastr Notification
					setTimeout(function() {
						var opts = {
							"closeButton": true,
							"debug": false,
							"positionClass": rtl() || public_vars.$pageContainer.hasClass('right-sidebar') ? "toast-top-left" : "toast-top-right",
							"toastClass": "black",
							"onclick": null,
							"showDuration": "300",
							"hideDuration": "1000",
							"timeOut": "5000",
							"extendedTimeOut": "1000",
							"showEasing": "swing",
							"hideEasing": "linear",
							"showMethod": "fadeIn",
							"hideMethod": "fadeOut"
						};

						toastr.success("Page data has been reloaded!", "Page Reload", opts);
					}, 3000);
				});
			</script>


			<div class="row">
				<div class="col-sm-3 col-xs-6">

					<div class="tile-stats tile-red">
						<div class="icon"><i class="entypo-doc-text"></i></div>
						<div class="num" data-start="0" data-end="83" data-postfix="" data-duration="1500" data-delay="0">0</div>

						<h3>Documents</h3>
						<p>Total Documents</p>
					</div>

				</div>

				<div class="col-sm-3 col-xs-6">

					<div class="tile-stats tile-green">
						<div class="icon"><i class="entypo-doc-text"></i></div>
						<div class="num" data-start="0" data-end="135" data-postfix="" data-duration="1500" data-delay="600">0</div>

						<h3>Files</h3>
						<p>Total Files</p>
					</div>

				</div>

				<div class="clear visible-xs"></div>

				<div class="col-sm-3 col-xs-6">

					<div class="tile-stats tile-aqua">
						<div class="icon"><i class="entypo-calendar"></i></div>
						<div class="num" data-start="0" data-end="23" data-postfix="" data-duration="1500" data-delay="1200">0</div>

						<h3>Activities</h3>
						<p>Total Activities</p>
					</div>

				</div>
			</div>

			<br />

			<div class="row">
				<div class="col-12">
					<div class="calendar-env border">

						<!-- Calendar Body -->
						<div class="calendar-body w-100">

							<div id="calendar"></div>

						</div>
					</div>
				</div>
			</div>


			<!-- Footer -->
			<?php include('../components/footer.php') ?>
		</div>

	</div>

	<!-- Imported styles on this page -->
	<link rel="stylesheet" href="/capstone/template/assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
	<link rel="stylesheet" href="/capstone/template/assets/js/rickshaw/rickshaw.min.css">

	<!-- Bottom scripts (common) -->
	<?php include('../components/common-scripts.php') ?>


	<!-- Imported scripts on this page -->
	<script src="/capstone/template/assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>
	<script src="/capstone/template/assets/js/jquery.sparkline.min.js"></script>
	<script src="/capstone/template/assets/js/rickshaw/vendor/d3.v3.js"></script>
	<script src="/capstone/template/assets/js/rickshaw/rickshaw.min.js"></script>
	<script src="/capstone/template/assets/js/raphael-min.js"></script>
	<script src="/capstone/template/assets/js/morris.min.js"></script>
	<script src="/capstone/template/assets/js/toastr.js"></script>
	<script src="/capstone/template/assets/js/neon-chat.js"></script>
	<script src="/capstone/template/assets/js/fullcalendar/fullcalendar.min.js"></script>
	<script src="/capstone/template/assets/js/neon-calendar.js"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="/capstone/template/assets/js/neon-custom.js"></script>


	<!-- Demo Settings -->
	<script src="/capstone/template/assets/js/neon-demo.js"></script>

</bocapstone

</html>