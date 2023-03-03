<?php 
include 'header.php';
?>
<?php
$emp_no=mysql_real_escape_string($_GET['emp_no']);
$emp=mysql_query("select * from employee e, department d where emp_no='$emp_no' and d.id_dept=e.id_department")or die(mysql_error());
?>
<h3><span class="glyphicon glyphicon-user"></span>  Edit Employee Data</h3>
<a class="btn" href="leave_app.php?emp_no=<?php echo $emp_no ?>"><span class="glyphicon glyphicon-arrow-left"></span>  back</a>
<?php
while($d=mysql_fetch_array($emp)){
?>
<br>	
<br>	
<br>	
<div class="col-md-5 col-md-offset-3">				
	<form action="edit_employee.php" method="post">
		<table class="table">
			<tr>
				<td>Emp No</td>
				<td><input type="text" class="form-control" name="emp_no" value="<?php echo $d['emp_no'] ?>" readonly></td>
			</tr>
			<tr>
				<td>Name</td>
				<td><input type="text" class="form-control" name="name" value="<?php echo $d['name'] ?>"></td>
			</tr>
			<tr>
				<td>Dept</td>
				<td>
					<select name="id_department"class="form-control" >
						<option value="<?php echo $d['id_department'] ?>"><?php echo $d['dept_name'] ?></option>
						<?php
						$det=mysql_query("select * from department")or die(mysql_error());
						while($dp=mysql_fetch_array($det)){
						?>
						<option value="<?php echo $dp['id_dept'] ?>"><?php echo $dp['dept_name'] ?></option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Design-grade</td>
				<td><input type="text" class="form-control" name="design_grade" value="<?php echo $d['design_grade'] ?>"></td>
			</tr>
			<tr>
				<td>DOJ</td>
				<td><input type="text" class="form-control" name="date_of_join" value="<?php echo $d['date_of_join'] ?>"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" class="btn btn-info" value="save"></td>
			</tr>
		</table>
	</form>
	<?php 
}
?>
</div>
<?php include 'footer.php'; ?>