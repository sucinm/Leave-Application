<?php 
include 'header.php';
?>
<?php 
// $tahun=2018;
$emp_no=mysql_real_escape_string($_GET['emp_no']);
$name=mysql_real_escape_string($_GET['name']);
// $emp=mysql_query("select id_leave,date, type_of_leave, from_date,to_date,total_days, reason, 
//     (select e.last_balance-sum(l.total_days) from leave_ l,employee e WHERE l.emp_no='20151211' and l.emp_no=e.emp_no )
//     as balance from leave_ l, department d, employee e 
//     where l.emp_no='20151211' 
//     and l.emp_no=e.emp_no 
//     and d.id_dept=e.id_department")or die(mysql_error());

if(isset($_GET['message'])){
    $message=mysql_real_escape_string($_GET['message']);
    if($message=="failed"){
        echo "<div class='alert alert-danger'>Failed to create (Emp No is available).</div>";
    }else if($message=="created"){
        echo "<div class='alert alert-success'>Success</div>";
    }
} 
?>
<h3><?php print $name ?></h3><h5>(<?php print $emp_no ?>)</h5>
<br>
<!--<div class="row">   
    <div class="col-md-12">
        <div class="panel panel-info">
      	    <div class="panel-heading">
                Employee List
            </div>
            <div class="panel-body"> -->
                <table id="example" class="display" cellspacing="0" width="100%">
                    <thead>
                		<tr>
                            <th>Date</th>
                            <th>Type of Leave</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Reason</th>
                            <th>Total Day(s)</th>
                            <th>Leave Balance</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php    
                        $leave=mysql_query("select id_leave,date, type_of_leave,d_o_k, from_date,to_date,total_days, reason
                        , YEAR(date) as year, DATE_FORMAT(date,'%M') as month
                        from leave_ l, department d, employee e 
                        where l.emp_no=$emp_no
                        and l.emp_no=e.emp_no 
                        and d.id_dept=e.id_department
                        and not l.type_of_leave='Off-in-Lieu' 
                        order by date,id_leave asc");
              
                        $subtotal = $total =0;
                        $bulan= "";
                        while($d=mysql_fetch_array($leave)){
                            
                        ?>
                        
                        <!--     <?php if ($bulan!= "" && $bulan!= $d['month']) { ?>  
                        <tr>
                            <td colspan="5"><h4><b>[<?php echo $d['month']; ?><?php echo $d['year']; ?>] Balance<h4><b></td>
                            <td><h4><b><?php echo $subtotal ?></b></h4></td>
                            <td></td>
                        </tr>     
                            <?php $subtotal= 0; } 
                            $tahun_lalu=$d['year']; ?> -->
                         <?php 
                         if ($d['d_o_k']=='d'){
                            $subtotal += $d['total_days'];
                            ?>
                        <tr style="font-weight:bold">
                            <td><?php print $d['date']; ?></td>
                            <td><?php print $d['month']; ?> Additional Leave</td>                            
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?php print $d['total_days']; ?></td>
                            <td><?php print $subtotal; ?></td>
                            <td></td>
                        </tr>
                        <?php 
                        } else if($d['d_o_k']=='k'  &&  $d['type_of_leave']!='Maternity' && $d['type_of_leave']!='Unpaid' ) { 
                        $subtotal -= $d['total_days']; ?>
                        <tr>
                            <td><?php print $d['date']; ?></td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php print $d['type_of_leave']; ?></td>
                            <td><?php print $d['from_date']; ?></td>
                            <td><?php print $d['to_date']; ?></td>
                            <td><?php print $d['reason']; ?></td>
                            <td><?php print $d['total_days']; ?></td>
                            <td><?php print $subtotal; ?></td>
                            <td>
                                <a href="edit_leave.php?leave_id=<?php echo $d['id_leave']; ?>" class="btn btn-warning"><i class="glyphicon glyphicon-pencil"></i> edit</a>
                                <a onclick="if(confirm('Are you sure you want to delete this data?')){ location.href='delete_leave.php?leave_id=<?php echo $d['id_leave']; ?>' }" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> delete</a>
                            </td>
                        <?php } else if($d['d_o_k']=='k'  && ( $d['type_of_leave']=='Maternity' || $d['type_of_leave']=='Unpaid') ) {  ?>
                        <tr>
                            <td><?php print $d['date']; ?></td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php print $d['type_of_leave']; ?></td>
                            <td><?php print $d['from_date']; ?></td>
                            <td><?php print $d['to_date']; ?></td>
                            <td><?php print $d['reason']; ?></td>
                            <td><?php print $d['total_days']; ?></td>
                            <td><?php print $subtotal; ?></td>
                            <td>
                                <a href="edit_leave.php?leave_id=<?php echo $d['id_leave']; ?>" class="btn btn-warning"><i class="glyphicon glyphicon-pencil"></i> edit</a>
                                <a onclick="if(confirm('Are you sure you want to delete this data?')){ location.href='delete_leave.php?leave_id=<?php echo $d['id_leave']; ?>' }" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> delete</a>
                            </td>
                        <?php } } ?> 
                    </tbody>
                </table>
<?php 
include 'footer.php';
?>