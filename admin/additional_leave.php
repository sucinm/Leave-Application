<?php 
include 'header.php';
?>

<div class="col-md-12">
    <h1>Leave Application</h3>
    <h3>PT. Bintan Resort Cakrawala</h3>
</div>
<div class="btn-group btn-group-justified">
    <a href="additional_leave.php?additional=annual" class="btn btn-primary">Annual</a>
    <a href="additional_leave.php?additional=oil" class="btn btn-primary">Off-in-Lieu</a>
</div>
<div id="box">
<br>
	<?php
	if(isset($_GET['additional'])){
		$additional=mysql_real_escape_string($_GET['additional']);
    	if($additional=="annual"){
	?>
	         	<div class="panel-body">
	                <div class="col-md-6 col-md-offset-3">
	                <h3>Annual</h3>
	                <h5>Now <?php echo date("M d, Y");  ?> </h5>
					<br>
					<br>
		                <div class="col-md-6">
							<?php 
		                $tahun=date("Y");  
		                $bulan=array(
		                	1=>"January",
		                	2=>"February",
		                	3=>"March",
		                	4=>"April",
		                	5=>"May",
		                	6=>"June",
		                	7=>"July",
		                	8=>"August",
		                	9=>"September",
		                	10=>"October",
		                	11=>"November",
		                	12=>"December");
		                	?>

				         	<ul class="nav nav-pills nav-stacked">
			                <?php
			                for ($x = 1; $x < 7; $x++) {
								$query=mysql_query("SELECT distinct DATE_FORMAT(date,'%Y-%M') FROM leave_ WHERE DATE_FORMAT(date,'%Y-%M') like '$tahun-$bulan[$x]' and  `d_o_k`='d'")or die(mysql_error());
								if(mysql_num_rows($query)==1){
							?>
								<li class="active"><a href="#"><span class="glyphicon glyphicon-ok"></span> <?php echo $bulan[$x]." ".$tahun ?></a></li>				
							<?php		
								}else{
							?>
								<li><a href="add_additional_annual_act.php?date=<?php echo $tahun.'-'.$x.'-01'; ?>&y=<?php echo $tahun ?>"><span class="glyphicon glyphicon-plus"></span> <?php echo $bulan[$x]." ".$tahun ?></a></li>							
							<?php
								}}
			                ?>
							</ul>
						</div>
						<div class="col-md-6">
							<ul class="nav nav-pills nav-stacked">
			                <?php
			                for ($x = 7; $x < 13; $x++) {
								$query=mysql_query("SELECT distinct DATE_FORMAT(date,'%Y-%M') FROM leave_ WHERE DATE_FORMAT(date,'%Y-%M') like '$tahun-$bulan[$x]' and  `d_o_k`='d'")or die(mysql_error());
								if(mysql_num_rows($query)==1){
							?>
								<li class="active"><a href="#"><span class="glyphicon glyphicon-ok"></span> <?php echo $bulan[$x]." ".$tahun ?></a></li>				
							<?php		
								}else{
							?>
								<li><a href="add_additional_annual_act.php?date=<?php echo $tahun.'-'.$x.'-01'; ?>&y=<?php echo $tahun ?>"><span class="glyphicon glyphicon-plus"></span> <?php echo $bulan[$x]." ".$tahun ?></a></li>							
							<?php
								}
							}
			                ?>
					        <br>
							<br>
							</ul>
						</div>
					</div>
				</div>
	<?php 
	} else if($additional=="oil"){ ?>
				<div class="panel-body">
	                <div class="col-md-5 col-md-offset-4">
					<h3>Off-in-Lieu</h3>
	                <h5>Now <?php echo date("M d, Y");  ?> </h5>
	                <br>
					<br>
		         	<form action="add_additional_oil_act.php" method="post">
						<table>
							<tr>
								<td>Date</td>
								<td colspan="3">
									<input type="date" class="form-control" name="date">
								</td>
							</tr>
							<tr>
								<td>Name</td>
								<td colspan="3">
									<select class="form-control" name="emp_no">
										<?php
										$emp=mysql_query("select * from employee order by name asc")or die(mysql_error());
										while($e=mysql_fetch_array($emp)){
										?>
										<option value="<?php echo $e['emp_no'] ?>"><?php echo $e['name'] ?> - <?php echo $e['emp_no'] ?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td>Job Assignment</td>
								<td colspan="3"><input type="text" class="form-control" name="job"></td>
							</tr>	
							<tr>
								<td>Total Day(s)</td>
								<td><input type="text" class="form-control" name="hour" style="width:200px"></td>
								<td colspan="2"> day(s)	</td>
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
								<td colspan="4" align="right"><br><input type="submit" class="btn btn-info" onclick="if(confirm('Are you sure want to save this leave?'))" value="submit"></td>
							</tr>
						</table>
					</form>
					<br>
					</div>
				</div>
	<?php }} ?>			
</div>
<?php 
include 'footer.php';
?>