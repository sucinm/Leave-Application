<?php 
include 'header.php';
?>
<?php 
$emp_no=mysql_real_escape_string($_GET['emp_no']);
$name=mysql_real_escape_string($_GET['name']);
?>
<h3><?php print $name ?></h3><h5>(<?php print $emp_no ?>)</h5>
<br>
                <table id="example" class="display" cellspacing="0" width="100%">
                    <thead>
                		<tr>
                            <th>Date</th>
                            <th>Off-in-Lieu Work</th>
                            <th>Job Assignment</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Total Hour</th>
                            <th>OIL Balance</th>
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
                        order by date,id_leave asc");
              
                        $subtotal = $total =0;
                        $bulan= "";
                        while($d=mysql_fetch_array($leave)){
                            
                        ?>
                         <?php 
                         if ($d['d_o_k']=='d_o'){
                            $subtotal += $d['total_days'];
                            ?>
                        <tr style="font-weight:bold">
                            <td><?php print $d['date']; ?></td>
                            <td> Additional OIL</td>                            
                            <td><?php print $d['reason']; ?></td>                            
                            <td><?php print $d['from_date']; ?></td>
                            <td><?php print $d['to_date']; ?></td>
                            <td><?php print $d['total_days']; ?></td>
                            <td><?php print $subtotal; ?></td>
                            <td>
                                <a href="edit_additional_oil.php?leave_id=<?php echo $d['id_leave']; ?>" class="btn btn-warning"><i class="glyphicon glyphicon-pencil"></i> edit</a>
                                <a onclick="if(confirm('Are you sure you want to delete this data?')){ location.href='delete_leave.php?leave_id=<?php echo $d['id_leave']; ?>' }" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> delete</a>
                            </td>
                        </tr>
                        <?php 
                        } else if($d['d_o_k']=='k_o' ) { 
                        $subtotal -= $d['total_days']; ?>
                        <tr>
                            <td><?php print $d['date']; ?></td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php print $d['type_of_leave']; ?></td>
                            <td></td>
                            <td><?php print $d['from_date']; ?></td>
                            <td><?php print $d['to_date']; ?></td>
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