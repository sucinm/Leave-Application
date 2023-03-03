<?php 
include 'header.php';
?>

<h3><span class="glyphicon glyphicon-user"></span>Employee List</h3>
<button style="margin-bottom:20px" data-toggle="modal" data-target="#myModal" class="btn btn-info col-md-2"><span class="glyphicon glyphicon-plus"></span>Add New Employee</button>
<br/><br/>
<?php 
if(isset($_GET['message'])){
    $message=mysql_real_escape_string($_GET['message']);
    if($message=="failed"){
        echo "<div class='alert alert-danger'>Failed to create (Emp No is available).</div>";
    }else if($message=="created"){
        echo "<div class='alert alert-success'>Success</div>";
    }
} 
?>
<br>

<div class="row">   
    <div class="col-md-12"> 
        <div class="panel panel-info">
            <div class="panel-heading">
                Employee List
            </div>
            <div class="panel-body">
                <a style="margin-bottom:10px" href="print_leave_balance_employee.php" target="_blank" class="btn btn-default pull-right"><span class='glyphicon glyphicon-print'></span> Print</a>

                <table id="example" class="display nowrap" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Emp No</th>
                            <th>Name</th>
                            <th>Dept Name</th>
                            <th>Design Grade</th>
                            <th>Date of Join</th>
                            <th>Leave Balance</th>
                            <th>OIL Balance</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php   
                        $id=0;               
                        $det=mysql_query("select * from employee e, department d where d.id_dept=e.id_department order by d.dept_name, e.name asc")or die(mysql_error());   
                        while($d=mysql_fetch_array($det)){
                            $id=$d['emp_no'];
                            // leave Balance
                            $query = mysql_query("SELECT sum(total_days) as d FROM leave_ where emp_no=$id and d_o_k='d'");
                                while ($row = mysql_fetch_array($query)) { $debit=$row['d']; }
                            
                            $query = mysql_query("SELECT sum(total_days) as k FROM leave_ where emp_no=$id and d_o_k='k' and not (type_of_leave='Maternity' OR type_of_leave='Unpaid')");
                                while ($row  = mysql_fetch_array($query)) { $kredit=$row['k']; }
                                $total_days=$debit-$kredit;
                            
                            // oil Balance
                            $query = mysql_query("SELECT sum(total_days) as d FROM leave_ where emp_no=$id and d_o_k='d_o'");
                                while ($row = mysql_fetch_array($query)) { $d_o=$row['d']; }
                            
                            $query = mysql_query("SELECT sum(total_days) as k FROM leave_ where emp_no=$id and d_o_k='k_o'");
                                while ($row = mysql_fetch_array($query)) { $k_o=$row['k']; }
                                $total=$d_o-$k_o;
                        ?> 
                        <tr>
                            <td><?php print $d['emp_no']; ?></td>
                            <td><?php print $d['name']; ?></td>
                            <td><?php print $d['dept_name']; ?></td>
                            <td><?php print $d['design_grade']; ?></td>
                            <td><?php print $d['date_of_join']; ?></td>
                            <td><?php print $total_days; ?> day(s) <a href="detail.php?emp_no=<?php echo $d['emp_no']; ?>&name=<?php echo $d['name']; ?>" class="btn btn-info"><i class="glyphicon glyphicon-search"></i></a>
                            </td>                            
                            <td><?php print $total; ?> day(s) <a href="detail_oil.php?emp_no=<?php echo $d['emp_no']; ?>&name=<?php echo $d['name']; ?>" class="btn btn-info"><i class="glyphicon glyphicon-search"></i></a>
                            </td>
                            <td>
                                <a href="leave_app.php?emp_no=<?php echo $d['emp_no']; ?>" class="btn btn-warning"><i class="glyphicon glyphicon-plus"></i> leave</a>
                                <a onclick="if(confirm('Are you sure you want to delete this data?')){ location.href='delete.php?emp_no=<?php echo $d['emp_no']; ?>' }" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> delete</a>
                            </td>
                        </tr>       
                        <?php } ?> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add New Employee</h4>
            </div>
            <div class="modal-body">
                <form action="add_employee_act.php" method="post">
                    <div class="form-group">
                        <label>Emp No</label>
                        <input name="emp_no" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input name="name" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Department</label>
                        <select name="id_department" class="form-control">
                            <?php
                            $det=mysql_query("select * from department")or die(mysql_error());
                            while($dp=mysql_fetch_array($det)){
                            ?>
                            <option value="<?php echo $dp['id_dept'] ?>"><?php echo $dp['dept_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Design-grade</label>
                        <input name="design_grade" type="text" class="form-control">
                    </div>  
                    <div class="form-group">
                        <label>DOJ</label>
                        <input name="date_of_join" type="date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Leave Balance</label>
                        <input name="total_days" type="text" class="form-control">
                        <input type="hidden" name="skrg" value="<?php echo date("Y-m-d") ?>">
                    </div>  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
                    <input type="submit" class="btn btn-primary" value="save">
                </div>
            </form>
        </div>
    </div>
</div>
<?php 

include 'footer.php';
?>