<?php 
include 'header.php';
?>

<?php
$leave_id=mysql_real_escape_string($_GET['leave_id']);
if (!empty($leave_id) ){
	$det=mysql_query("select * from leave_ l,employee e, department d where l.id_leave='$leave_id' and d.id_dept=e.id_department and l.emp_no=e.emp_no")or die(mysql_error());	
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
	         	<form action="edit_leave_act.php" method="post">
					<table>
						<tr>
							<td>Date</td>
							<td colspan="3">
								<input type="hidden" name="emp_no" value="<?php echo $d['emp_no']; ?>">
								<input type="hidden" name="name" value="<?php echo $d['name']; ?>">
								<input type="hidden" name="id_leave" value="<?php echo $d['id_leave']; ?>">
								<input type="hidden" name="d_o_k" value="<?php echo $d['d_o_k']; ?>">
								<input type="date" class="form-control" name="date" value="<?php echo $d['date']; ?>">
							</td>
						</tr>
						<tr>
							<td>Total Hour</td>
							<td colspan="2"><input type="text" class="form-control" name="days" style="width:200px" value="<?php echo $d['total_days']; ?>">					</td>
							<td colspan="3"> Hours	</td>
						</tr>
						<tr>
							<td>From</td>
							<td colspan="3"><input type="date" class="form-control" name="from" value="<?php echo $d['from_date']; ?>"></td>
						</tr>
						<tr>
							<td>To</td>
							<td colspan="3"><input type="date" class="form-control" name="to" value="<?php echo $d['to_date']; ?>"></td>
						</tr>	
						<tr>
							<td>Job Assigment</td>
							<td colspan="3"><input type="text" class="form-control" name="reason" value="<?php echo $d['reason']; ?>"></td>
						</tr>
						<tr><br>
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