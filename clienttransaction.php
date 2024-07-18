<?php 
    session_start();
    include ('include/db.php');
    include ('include/passkey.php');
    $_SESSION['ClientID']=$_GET['ClientID'];
    $ClientID=$_SESSION['ClientID'];
    $query=mysqli_query($conn,"SELECT ClientID,ClientName from 1clients WHERE ClientID=$ClientID");
    $runquery=mysqli_fetch_assoc($query);
    $ClientName=$runquery['ClientName'];

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="refresh" content="9001">

    <title>TWINCOM WMS</title>
    <link rel="shortcut icon" type="image/png" href="img/twincom.png"/>

    <!-- Custom fonts for this template-->
    <link href="vendor1/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor1/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <style>
        .badge {
  animation: blinker 1.5s linear infinite;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include ('include/sidebar.php');?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include ('include/topbar.php');?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?php echo $ClientName?> Transaction Reports</h1>
                    </div>
                    <!-- Content Row -->

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" id="clienttransaction">
                                <table class="table table-bordered table-sm" id="dataTable" style="width:100%" cellspacing="0">
                                    <thead>
                                        <tr class="text-center" style="color: black;">
                                            <th width="1%">#</th>
                                            <th>BOQ Date</th>
                                            <th>Site Name</th>
                                            <th>Coverage Area</th>
                                            <th>Address</th>
                                            <th>SoW</th>
                                            <th>Type Site</th>
                                            <th>PO No</th>
                                            <th>Project Code</th>
                                            <th>Issued %</th>
                                            <th>Balance %</th>
                                            <th width="1%"></th>
                                            <th width="1%"></th>
                                            <th width="1%"></th>
                                        </tr>
                                    </thead>
            
                                    <tbody>
                                        <?php
                                            $data=mysqli_query($conn, "SELECT a.BoqID,a.ClientID,a.SiteName, a.CoverageArea, a.Address, a.SoW, a.TypeSite, a.PONo, a.ProjectCode, DATE_FORMAT(a.TS, '%Y-%m-%d') AS BOQDate, b.ClientName FROM 2boq a join 1clients b on a.ClientID=b.ClientID WHERE a.ClientID=$_GET[ClientID]");
                                            $count=0;
                                            while ($rowdata=mysqli_fetch_assoc($data)){
                                                $query="select BoqID from 2boqsub where CLientID=$_GET[ClientID]";
                                                $rowquery=mysqli_query($conn,$query);
                                                $run=mysqli_fetch_assoc($rowquery);
                                                
                                                echo '
                                                    <tr style="color: black;">';
                                                    if (empty($run['BoqID'])) {
                                                    
                                                    echo '<td class="text-center"><span class="badge badge-danger">No BOQ Details.<br> Pls Upload.</span> '.++$count.'.</td>';
                                                }else{
                                                    echo'<td class="text-center">'.++$count.'.</td>';
                                                }echo ' 
                                                        
                                                        <td>'.$rowdata['BOQDate'].'</td>
                                                        <td>'.$rowdata['SiteName'].'</td>
                                                        <td>'.$rowdata['CoverageArea'].'</td>
                                                        <td>'.$rowdata['Address'].'</td>
                                                        <td>'.$rowdata['SoW'].'</td>
                                                        <td>'.$rowdata['TypeSite'].'</td>
                                                        <td>'.$rowdata['PONo'].'</td>
                                                        <td>'.$rowdata['ProjectCode'].'</td>
                                                        <td>Issued %</td>
                                                        <td>Balance %</td>
                                                        <td>
                                                            <a href="viewboq.php?BoqID='.$rowdata['BoqID'].'&ClientID='.$rowdata['ClientID'].'">
                                                                <button class="btn btn-sm btn-outline-info" data-toggle="tooltip" data-placement="top" title="View BOQ" ><i class="fas fa-file"></i></button>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="boq_breakdown.php?BoqID='.$rowdata['BoqID'].'&ClientID='.$rowdata['ClientID'].'">
                                                                <button class="btn btn-sm btn-outline-success" data-toggle="tooltip" data-placement="top" title="View BOQ Items Breakdown" ><i class="fas fa-file-alt"></i></button>
                                                            </a>
                                                        </td>   
                                                        <td>
                                                            <a href="item_reservation.php?ClientID='.$rowdata['ClientID'].'&BoqID='.$rowdata['BoqID'].'">
                                                                <button class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Proceed to Item Reservation"><i class="fas fa-sign-out-alt"></i></i></button>
                                                            </a>
                                                        </td>   
                                                    </tr>  
                                                ';
                                            }
                                        ?>
                                    </tbody>
                                        
                                </table>
                                        
            
            
                
            
            
                            </div>
                        </div>
                    </div>
                </div>
                <div id="show_modal"></div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; TWINCOM <?php echo date('Y')?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Bootstrap core JavaScript-->
    <script src="vendor1/jquery/jquery.js"></script>
    <script src="vendor1/jquery/jquery.min.js"></script>
    <script src="vendor1/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor1/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor1/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <!-- Page level plugins -->
    <script src="vendor1/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor1/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <script src="sweetalertresources/sweetalert.js"></script>

    <script>
        function clienttransaction(){
            $.ajax({
                type: "POST",
                url: "queries/client_transaction_queries.php",
                data: {
                "show_clienttransaction" : 1
                },
                success: function (x) {
                    $('#clienttransaction').html(x);
                }
            });
        }

        setTimeout(function() {
            $('#alert').fadeOut('fast');
        }, 5000); 

        if ( $.fn.dataTable.isDataTable( '#dataTable' ) ) {
            table = $('#dataTable').DataTable();
        }
        else {
            table = $('#dataTable').DataTable( {
                paging: true
            } );
        }

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

</body>

</html>