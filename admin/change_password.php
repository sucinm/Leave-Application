<?php 
include 'header.php';
?>

<h3><span class="glyphicon glyphicon-briefcase"></span>  Password</h3>
<br/><br/>
<?php 
if(isset($_GET['message'])){
	$message=mysql_real_escape_string($_GET['message']);
	if($message=="failed"){
		echo "<div class='alert alert-danger'>Failed to change, please check again your password.</div>";
	}else if($message=="different"){
		echo "<div class='alert alert-warning'>Password doesn't match. </div>";
	}else if($message=="oke"){
		echo "<div class='alert alert-success'>Success</div>";
	}
}
?>

<br/>
<div class="col-md-5 col-md-offset-3">
	<form action="change_password_act.php" method="post">
		<div class="form-group">
			<input name="user" type="hidden" value="<?php echo $_SESSION['uname']; ?>">
		</div>
		<div class="form-group">
			<label>Old Password</label>
			<input name="lama" type="password" class="form-control" placeholder="Old Password">
		</div>
		<div class="form-group">
			<label>New Password</label>
			<input name="baru" type="password" class="form-control" placeholder="New Password">
		</div>
		<div class="form-group">
			<label>Repeat New Password</label>
			<input name="ulang" type="password" class="form-control" placeholder="New Password">
		</div>
		<div class="form-group">
			<label></label>
			<input type="submit" class="btn btn-info" value="save">
			<input type="reset" class="btn btn-danger" value="reset">
		</div>																	
	</form>
</div>


<?php 
include 'footer.php';

?>