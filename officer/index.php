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
    <!-- dataTables  -->
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
    <?php 
    $emp_no=$_SESSION['uname']; 
    if (!empty($emp_no) ){
        $det=mysql_query("select * from employee e, department d where emp_no='$emp_no' and d.id_dept=e.id_department")or die(mysql_error());   
    } else {
        $det=0;
    }
    while($d=mysql_fetch_array($det)){

    ?>
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
                    <li><a href="logout.php">Sign out &nbsp&nbsp<span class="glyphicon glyphicon-log-out"></span></a></li>
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

                    <table width="225">
                        <tr>
                            <td colspan="4">Emp No</td>
                        </tr>
                        <tr>    
                            <td colspan="4"><input type="text" class="form-control" name="emp_no" value="<?php echo $d['emp_no']; ?>" readonly></td>
                        </tr>
                        <tr>    
                            <td colspan="4">Name</td>
                        </tr>
                        <tr>    
                            <td colspan="4"><input type="text" class="form-control" name="name" value="<?php echo $d['name']; ?>" readonly></td>
                        </tr>
                        <tr>    
                            <td colspan="4">Dept</td>
                        </tr>
                        <tr>    
                            <td colspan="4"><input type="text" class="form-control" name="dept" value="<?php echo $d['dept_name']; ?>" readonly></td>
                        </tr>
                        <tr>
                            <td colspan="4">Design-Grade</td>
                        </tr>
                        <tr>
                            <td colspan="4"><input type="text" class="form-control" name="design_grade" value="<?php echo $d['design_grade']; ?>" readonly></td>
                        </tr>                        
                        <tr>
                            <td colspan="4">Date of Join</td>
                        </tr>
                        <tr>
                            <td colspan="4"><input type="text" class="form-control" name="doj" value="<?php echo $d['date_of_join']; ?>" readonly></td>
                        </tr> 
                        <tr>
                            <td colspan="4">Leave Balance</td>
                        </tr>               
                    </table>
                        <?php 
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
                    <table>
                        <tr align="center">
                            <td width="112"><b>Annual</b></td>
                            <td width="112"><b>OIL</b></td>
                        </tr>
                        <tr align="center">
                            <td id="box"><h3><?php echo $total_days; ?></h3></td>
                            <td id="box"><h3><?php echo $total; ?></h3></td>
                        </tr>
                    </table>                      
                    <?php } ?>
                </div>
            <div class="col-md-10">
                <div class="btn-group btn-group-justified">
                    <a href="index.php?report=annual" class="btn btn-primary">Annual</a>
                    <a href="index.php?report=oil" class="btn btn-primary">Off-in-Lieu</a>
                </div>
                <div id="box">
                <br>
                    <?php
                    if(isset($_GET['report'])){
                        $report=mysql_real_escape_string($_GET['report']);
                        if($report=="annual"){
                    ?>
                            <div class="panel-body">
                                <center>
                                    <H3>Leave Report</H3>
                                    <h4>[Annual]</h4>
                                </center>
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php    
                                        $leave=mysql_query("select id_leave,date, type_of_leave,d_o_k, from_date,to_date,total_days, reason
                                        , YEAR(date) as year, DATE_FORMAT(date,'%M') as month
                                        from leave_ l, department d, employee e 
                                        where l.emp_no='$emp_no'
                                        and l.emp_no=e.emp_no 
                                        and d.id_dept=e.id_department
                                        and not l.type_of_leave='Off-in-Lieu' 
                                        order by date,id_leave asc");
                              
                                        $subtotal = $total =0;
                                        $bulan= "";
                                        while($d=mysql_fetch_array($leave)){
                                            
                                        ?>
                                        
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
                                        <?php } else if($d['d_o_k']=='k'  && ( $d['type_of_leave']=='Maternity' || $d['type_of_leave']=='Unpaid') ) {  ?>
                                        <tr>
                                            <td><?php print $d['date']; ?></td>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php print $d['type_of_leave']; ?></td>
                                            <td><?php print $d['from_date']; ?></td>
                                            <td><?php print $d['to_date']; ?></td>
                                            <td><?php print $d['reason']; ?></td>
                                            <td><?php print $d['total_days']; ?></td>
                                            <td><?php print $subtotal; ?></td>
                                        <?php } } ?> 
                                    </tbody>
                                </table>
                            </div>
                        <?php 
                        } else if($report=="oil"){ ?>
                                <div class="panel-body">
                                <center>
                                    <H3>Leave Report</H3>
                                    <h4>[OIL]</h4>
                                </center>
                                    <table id="example" class="display" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Off-in-Lieu Work</th>
                                                <th>Job Assignment</th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Total Day(s)</th>
                                                <th>OIL Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php    
                                            $leave=mysql_query("select id_leave,date, type_of_leave,d_o_k, from_date,to_date,total_days, reason
                                            , YEAR(date) as year, DATE_FORMAT(date,'%M') as month
                                            from leave_ l, department d, employee e 
                                            where l.emp_no='$emp_no'
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
                                            <?php } } ?> 
                                        </tbody>
                                    </table>
                                </div>
                        <?php }} ?>         
                    </div>
        </div>
    </body>
</html>