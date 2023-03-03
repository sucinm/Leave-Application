<!DOCTYPE html>
<html>
<head>
	<?php 
	session_start();
	include '../cek.php';
	include '../config.php';
	?>
	<title>PT. Bintan Resort Cakrawala</title>
	<link href="../logo/brc-icon.png" rel="shortcut icon" /> 
	<link rel="stylesheet" type="text/css" href="../assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../assets/js/jquery-ui/jquery-ui.css">
	<script type="text/javascript" src="../assets/js/jquery.js"></script>
	<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
	<script type="text/javascript" src="../assets/js/jquery-ui/jquery-ui.js"></script>
	<!-- dataTables	 -->
	<link rel="stylesheet" type="text/css" href="../assets/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/buttons.dataTables.min.css">
	<script type="text/javascript" src="../assets/js/jquery-1.12.4.js"></script>
	<script type="text/javascript" src="../assets/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="../assets/js/buttons.flash.min.js"></script>
	<script type="text/javascript" src="../assets/js/jszip.js"></script>
	<script type="text/javascript" src="../assets/js/pdfmake.min.js"></script>
	<script type="text/javascript" src="../assets/js/vfs_fonts.min.js"></script>
	<script type="text/javascript" src="../assets/js/buttons.html5.min.js"></script>	
	<script type="text/javascript" src="../assets/js/buttons.print.min.js"></script>
	<script type="text/javascript" src="../assets/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript">
	    $(document).ready(function() {
		    $('#example').DataTable( {
		        "scrollY": true,
		        "scrollX": true
		    } );
		} );
	</script>
</head>
<body>
	<div class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a href="#" class="navbar-brand">PT. Bintan Resort Cakrawala</a>
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="collapse navbar-collapse">				
				<ul class="nav navbar-nav navbar-right">
					<li><a class="dropdown-toggle" data-toggle="dropdown" role="button" href="#"><?php echo $_SESSION['uname']  ?>&nbsp&nbsp<span class="glyphicon glyphicon-user"></span></a></li>
				</ul>
			</div>
		</div>
	</div>

	
	<div class="col-md-2">
		<div class="row">
			<div class="col-xs-6 col-md-12">
					<a class="thumbnail">
						<img class="img-responsive" src="../logo/brc-icon.png">
					</a>
				</div>
		</div>

		<div class="row"></div>
		<ul class="nav nav-pills nav-stacked">
			<li class="active"><a href="index.php"><span class="glyphicon glyphicon-home"></span>  Dashboard</a></li>			
			<li><a href="additional_leave.php?additional=annual"><span class="glyphicon glyphicon-plus"></span>  Additional Leave</a></li>			
			<li><a href="leave_report.php?report=LeaveBalance"><span class="glyphicon glyphicon-list"></span> Leave Report</a></li>	
			<li><a href="change_password.php"><span class="glyphicon glyphicon-lock"></span> Change Password</a></li>
			<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>  Sign out</a></li>			
		</ul>
	</div>
	<div class="col-md-10">