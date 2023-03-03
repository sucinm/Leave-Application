<?php 
include 'header.php';
?>
<?php 
if(isset($_GET['message'])){
    $message=mysql_real_escape_string($_GET['message']);
    if($message=="failed"){
        echo "<div class='alert alert-danger'>Failed to create leave.</div>";
    }else if($message=="success"){
        echo "<div class='alert alert-success'>Success</div>";
    }
} 
?>
<?php
$emp_no=mysql_real_escape_string($_GET['emp_no']);
if (!empty($emp_no) ){
	$det=mysql_query("select * from employee e, department d where emp_no='$emp_no' and d.id_dept=e.id_department")or die(mysql_error());	
} else {
	$det=0;
}
while($d=mysql_fetch_array($det)){
?>	

<div class="col-md-12">
    <h1>Leave Application</h3>
    <h3>PT. Bintan Resort Cakrawala</h3>
<br>
<br>
<br>
</div>
<div class="container"> 
	<div class="row">
		<div class="col-sm-4">
			<div class="panel panel-info">
	      	    <div class="panel-heading">
	                Employee Profile
	            </div>
	         	<div class="panel-body">
					<table>
						<tr>
							<td>Emp No</td>
							<td colspan="3"><input type="text" class="form-control" name="emp_no" value="<?php echo $d['emp_no']; ?>" readonly></td>
						</tr>
						<tr>
							<td>Name</td>
							<td colspan="3"><input type="text" class="form-control" name="name" value="<?php echo $d['name']; ?>" readonly></td>
						</tr>
						<tr>
							<td>Dept</td>
							<td colspan="3"><input type="text" class="form-control" name="dept" value="<?php echo $d['dept_name']; ?>" readonly></td>
						</tr>
						<tr>
							<td>Design-grade</td>
							<td colspan="3"><input type="text" class="form-control" name="design_grade" value="<?php echo $d['design_grade']; ?>" readonly></td>
						</tr>
						<tr>
							<td>DOJ</td>
							<td colspan="3"><input type="text" class="form-control" name="doj" value="<?php echo $d['date_of_join']; ?>" readonly></td>
						</tr>
						<tr>
							<td colspan="2" align="right">
								<br><br><a href="edit.php?emp_no=<?php echo $d['emp_no']; ?>" class="btn btn-info">edit</a>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>

		<div class="col-sm-5">
			<div class="panel panel-info">
	      	    <div class="panel-heading">
	                Leave Form
	            </div>
	         	<div class="panel-body">
	         	<form action="add_leave_act.php" method="post">
					<table>
						<tr>
							<td>Date</td>
							<td colspan="3">
								<input type="hidden" name="emp_no" value="<?php echo $emp_no; ?>">
								<input type="date" class="form-control" name="date">
							</td>
						</tr>
						<tr>
							<td>Type of Leave</td>
							<td>
								<select class="form-control"  name="type_of_leave">
									<option value="Annual">Annual</option>
									<option value="Emergency">Emergency</option>
									<option value="Maternity">Maternity</option>
									<option value="Unpaid">Unpaid</option>
									<option value="Other">Other</option>
									<option value="Off-in-Lieu">Off-in-Lieu</option>
								</select>
							</td>
							<td><input type="text" class="form-control" name="days" style="width:50px"></td>
							<td colspan="3"> day(s)	</td>
						</tr>
						<tr>
							<td>From</td>
							<td colspan="3"><input type="date" class="form-control" name="from"></td>
						</tr>
						<tr>
							<td>To</td>
							<td colspan="3"><input type="date" class="form-control" name="to"></td>
						</tr>	
						<tr>
							<td>*Reason for <b>Other</b> Leave</td>
							<td colspan="3"><textarea class="form-control" name="reason" rows="2" cols="30"></textarea></td>
						</tr>
						<tr>
							<td colspan="4" align="right"><br><input type="submit" class="btn btn-info" onclick="if(confirm('Are you sure want to save this leave?'))" value="submit"></td>
						</tr>
					</table>
				</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php 
}
include 'footer.php';

?>