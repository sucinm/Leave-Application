<script type="text/javascript" src="../assets/js/jquery-1.9.0.js">            </script>
<script type="text/javascript">
$(function(){
    $('button').click(function(){
        var url='data:application/vnd.ms-excel,' + encodeURIComponent($('#tableWrap').html()) 
        location.href=url
        return false
    })
})
</script>
<?php 
include 'header.php';
$tahun;
$id_dept;
$id_dept='';
$dept_name;
if(isset($_POST['tahun'])){
    $tahun=mysql_real_escape_string($_POST['tahun']);
} else {
	$tahun=date("Y");;	
}
if(isset($_POST['id_dept'])){
    $id_dept=mysql_real_escape_string($_POST['id_dept']);
    if($id_dept==0){
    	$dept_name='All';
    } else {
        $dname=mysql_query("SELECT dept_name FROM department where id_dept='$id_dept'")or die(mysql_error());
        while($dp=mysql_fetch_array($dname)){
			$dept_name=$dp['dept_name'];
		}
	}
} else {
	$id_dept='0';
	$dept_name='All';
}
$tahun_seb=$tahun-1;
?>

<div class="col-md-12">
    <h1>Leave Application</h3>
    <h3>PT. Bintan Resort Cakrawala</h3>
</div>
<div class="btn-group btn-group-justified">
    <a href="leave_report.php?report=LeaveBalance" class="btn btn-primary">Leave Balance Report</a>
    <a href="leave_report.php?report=EmergencyLeave" class="btn btn-primary">Emergency Leave Report</a>
</div>
<div id="box">
<br>
	<?php
	if(isset($_GET['report'])){
		$report=mysql_real_escape_string($_GET['report']);
    	if($report=="LeaveBalance"){
	?>
	<div class="row">
	  	<div class="col-xs-12">
	    	<div class="form-group">
	    		<form action="leave_report.php?report=LeaveBalance" method="post">
				<table style="margin: 10px;" align="right">
		    		<tr>
		    			<td>
		    				<select name="tahun" class="form-control">
								<option><?php echo $tahun; ?></option>
								<?php
	                            $det=mysql_query("SELECT DISTINCT DATE_FORMAT(date,'%Y') as thn FROM leave_")or die(mysql_error());
	                            while($dp=mysql_fetch_array($det)){
	                            ?>
	                            <option value="<?php echo $dp['thn'] ?>"><?php echo $dp['thn'] ?></option>
	                            <?php } ?>
							</select>
		    			</td>
		    			<td>
		    				<select name="id_dept" class="form-control">
	                            <option value="<?php echo $id_dept; ?>"><?php echo $dept_name; ?></option>
	                            <option value="0">All</option>
	                            <?php
	                            $det=mysql_query("select * from department")or die(mysql_error());
	                            while($dp=mysql_fetch_array($det)){
	                            ?>
	                            <option value="<?php echo $dp['id_dept'] ?>"><?php echo $dp['dept_name'] ?></option>
	                            <?php } ?>
	                        </select>
		    			</td>
		    			<td>
							<input type="submit" class="btn btn-info" value="submit">
		    			</td>
		    		</tr>
	    		</table>
	    		</form>
			</div>
		</div>
	</div>


	<div class="row">   
    	<div class="col-md-12"> 
           <div class="panel-body" style="margin:10px">
                <button class="btn btn-default pull-right"><span class='glyphicon glyphicon-print'></span> Print</button>
                <!-- <a href="print_leave_balance_department.php" target="_blank" class="btn btn-default pull-right"><span class='glyphicon glyphicon-print'></span> Print</a> -->
                <h3><b>Leave Balance Report</b></h3>
                <h5>[<?php echo $dept_name."-".$tahun;?>]</h5><br>
                <!-- <button>click me</button> -->
                <div id="tableWrap">
                <table id="example" class="display nowrap" cellspacing="0" style="text-align:center;">
			        <thead>
           				<tr style="font-weight: bold;">
                            <td>Emp No</td>
                            <td>Name</td>

                            <?php
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

    						for ($i=1; $i <13 ; $i++) { 
    						?>

    						<td>Early<br><?php echo $bulan[$i] ?></td>
    						<td>Taken</td>
    						<td>Last<br><?php echo $bulan[$i] ?></td>
    						<?php } ?>
                            <td>Last<br>Balance</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php   
                        $id=0;   
                        if($id_dept==0){
							$det=mysql_query("select * from employee e, department d where d.id_dept=e.id_department order by d.dept_name, e.name asc")or die(mysql_error());	
                        } else{
                        	$det=mysql_query("select * from employee e, department d where d.id_dept=e.id_department and e.id_department='$id_dept' order by d.dept_name, e.name asc")or die(mysql_error());
                        }   

            			while($d=mysql_fetch_array($det)){
                            $id=$d['emp_no'];
                            $debit=0;
							$kredit=0;
                            $dbt=mysql_query("SELECT l.emp_no,debit.d,kredit.k, debit.d-kredit.k as deb_akh FROM leave_ l,employee e, (SELECT emp_no, SUM(total_days) as d 
                                FROM leave_
                                WHERE d_o_k='d'
                                AND date between '0000-00-00' and '$tahun_seb-12-31'    
                                GROUP BY emp_no) AS debit,
                                (SELECT emp_no, SUM(total_days) as k 
                                FROM leave_
                                WHERE d_o_k='k'
                                AND NOT (type_of_leave='Maternity' OR type_of_leave='Unpaid')
                                AND date between '0000-00-00' and '$tahun_seb-12-31' 
                                GROUP BY emp_no) AS kredit
                                WHERE l.emp_no=e.emp_no
                                AND l.emp_no='$id'
                                AND debit.emp_no=l.emp_no
                                AND kredit.emp_no=l.emp_no
                                GROUP BY l.emp_no");
                            while($da=mysql_fetch_array($dbt)){
                                $debit=$da['deb_akh'];
                            } 
                        ?>
                        <tr>
                            <td><?php print $d['emp_no']; ?></td>
                            <td><?php print $d['name']; ?></td>

                        <?php  
		                for ($x = 1; $x < 13; $x++) {
		                	$d;
		                	$total=0;
		                	$bln=$bulan[$x];
		                	
		                	
							$query = mysql_query("SELECT sum(total_days) as d FROM leave_ where emp_no=$id and d_o_k='d' and DATE_FORMAT(date,'%Y-%M') ='$tahun-$bln'");
							    while ($row = mysql_fetch_array($query)) { 
                                	$d=$row['d'];
                                }
                                if(is_null($d)){
                                	$debit=$debit+0;
                                }else {
                               		$debit=$debit+$d; 
                               	}

                            $query = mysql_query("SELECT sum(total_days) as k FROM leave_ where emp_no=$id and d_o_k='k' and not (type_of_leave='Maternity' OR type_of_leave='Unpaid') and DATE_FORMAT(date,'%Y-%M') ='$tahun-$bln'");
                                while ($row  = mysql_fetch_array($query)) { 
                                	if(is_null($row['k'])){
                                		$kredit=0;
                                	} else {
                                		$kredit=$row['k'];                                 		
                                	}
                                } 

                        	?>
                            <!-- Early Month -->
                            <td><?php print $debit; ?></td>
                            <!-- Taken -->
                            <td><?php print $kredit; ?></td>
                            <!-- Last Month -->
	                        <?php $debit=$debit-$kredit; ?>                            
                            <td><?php print $debit; ?></td>                        	
                        	<?php } ?> 
                            <!-- Last Balance -->
                            <td><?php print $debit; ?></td> 
                        </tr> 
                        <?php } ?>   
                    </tbody> 
                </table>
            </div>
            </div>
        </div>
    </div>

	<?php 
	} elseif($report=="EmergencyLeave"){ ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <form action="leave_report.php?report=EmergencyLeave" method="post">
                <table style="margin: 10px;" align="right">
                    <tr>
                        <td>
                            <select name="tahun" class="form-control">
                                <option><?php echo $tahun; ?></option>
                                <?php
                                $det=mysql_query("SELECT DISTINCT DATE_FORMAT(date,'%Y') as thn FROM leave_")or die(mysql_error());
                                while($dp=mysql_fetch_array($det)){
                                ?>
                                <option value="<?php echo $dp['thn'] ?>"><?php echo $dp['thn'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <input type="submit" class="btn btn-info" value="submit">
                        </td>
                    </tr>
                </table>
                </form>
            </div>
        </div>
    </div>
	<div class="row">   
    	<div class="col-md-12"> 
            <div class="panel-body">
                <a style="margin-bottom:10px" href="print_emergency_leave_employee.php?years=<?php echo $tahun; ?>" target="_blank" class="btn btn-default pull-right"><span class='glyphicon glyphicon-print'></span> Print</a>
                <h3><b>Emergency Leave Report</b></h3>
                <h5>[<?php echo $tahun;?>]</h5><br>
                <table id="example" class="display nowrap" width="100%" cellspacing="0">
                    <thead>
                		<tr>
                            <th>Date</th>
                            <th>Emp No</th>
                            <th>Name</th>
                            <th>Dept Name</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Total Day(s)</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php   
                        $id=0;               
            			$det=mysql_query("select * from employee e, department d, leave_ l where date LIKE '$tahun-%-%' and d.id_dept=e.id_department and e.emp_no=l.emp_no and type_of_leave='Emergency' order by d.dept_name, e.name asc")or die(mysql_error());	
                        while($d=mysql_fetch_array($det)){
                        ?> 
                        <tr>
                            <td><?php print $d['date']; ?></td>
                            <td><?php print $d['emp_no']; ?></td>
                            <td><?php print $d['name']; ?></td>
                            <td><?php print $d['dept_name']; ?></td>
                            <td><?php print $d['from_date']; ?></td>
                            <td><?php print $d['to_date']; ?></td>
                            <td><?php print $d['total_days']; ?></td>
                            <td><?php print $d['reason']; ?></td>
                        </tr>       
                        <?php } ?> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>			
</div>
	<?php }} ?>			
</div>
<?php 
include 'footer.php';
?>