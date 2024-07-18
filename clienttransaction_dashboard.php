<?php 
    session_start();
    include ('include/db.php');
    include ('include/passkey.php');

    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Writer\Xls;

    if(isset($_POST['importSubmit']))
    {
        $fileName1 = $_FILES['file']['name'];
        $file_ext1 = pathinfo($fileName1, PATHINFO_EXTENSION);

        $allowed_ext = ['xls','csv','xlsx'];
        $ClientID=$_POST['ClientID'];

        if(in_array($file_ext1,  $allowed_ext))
        {
            $inputFileNamePath1 = $_FILES['file']['tmp_name'];
            $spreadsheet1 = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath1);
            $data1 = $spreadsheet1->getActiveSheet()->toArray();

            $count = "0";
            foreach($data1 as $row1)
            {
                if($count > 0)
                {
                    $SiteName   = $row1[0];
                    $CoverageArea  = $row1[1];
                    $Address  = $row1[2];
                    $SoW = $row1[3];
                    $TypeSite = $row1[4];
                    $PONo =  $row1[5];
                    $ProjectCode =  $row1[6];

                    $SupPartID   = $row1[7];
                    $MatCode  = $row1[8];
                    $ItemDescription  = $row1[9];
                    $UoM = $row1[10];
                    $UnitCost = str_replace(',', '', $row1[11]);
                    $Qty =  $row1[12];

                    $query="INSERT INTO `2boq` (`SiteName`, `CoverageArea`, `Address`, `SoW`, `TypeSite`, `PONo`, `ProjectCode`, `ClientID`, `EncodedBy`, `TS`) VALUES ('$SiteName', '$CoverageArea', '$Address', '$SoW', '$TypeSite', '$PONo', '$ProjectCode', '$ClientID', '$EmpID', NOW())";

                    $runquery = mysqli_query($conn, $query);
                    
                    $getdata="SELECT LAST_INSERT_ID(BoqID), BoqID, ClientID  from 2boq where SiteName<>'' ORDER BY BoqID DESC  limit 1";
                    $rundata=mysqli_query($conn,$getdata); 
                    $data=mysqli_fetch_assoc($rundata);

                    $query2="INSERT INTO `2boqsub` (`SupPartID`, `MatCode`, `ItemDescription`, `UoM`, `UnitCost`, `Qty`, `ClientID`, `BoqID`, `EncodedBy`, `TS`) VALUES ('$SupPartID', '$MatCode', '$ItemDescription', '$UoM', '$UnitCost', '$Qty', '$data[ClientID]','$data[BoqID]', '$EmpID', NOW())";
                    $runquery2 = mysqli_query($conn, $query2);
                    $msg = true;
                       
                }
                else
                {
                    $count = "1";
                }
            }

            if(isset($msg))
            {
                $_SESSION['message'] = "Successfully Imported";
               
            }
            else
            {
                $_SESSION['message'] = "Not Imported";
            }
        }else
        {
            $_SESSION['message'] = "Invalid File";
        } 
        $getdata="SELECT BoqID, ClientID  from 2boq ORDER BY BoqID DESC limit 1";
        // echo $getdata;
        $rundata=mysqli_query($conn,$getdata); 
        $data=mysqli_fetch_assoc($rundata);

        $delete="DELETE FROM 2boq WHERE BoqID=$data[BoqID]";
        // echo $delete; exit();
        $rundelete=mysqli_query($conn,$delete);
        header('Location: clienttransaction_dashboard.php');
    }
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

</head>

<body id="page-top" onload="transactionlist()">

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
                        <h1 class="h3 mb-0 text-gray-800">Transaction Reports</h1>
                    </div>
                    

                    <!-- Content Row -->

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <a href="" data-toggle="modal" data-target="#uploadboq">
                                <button class="d-none d-sm-inline-block btn btn-sm btn-outline-info shadow-sm float-right mr-2"> <i class="fas fa-file-upload fa-sm text-white-50"></i> <b> Upload New BOQ</b></button>
                            </a>
                        </div>
                        <div class="card-body">
                            <div id="transactionlist">
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

    <div class="modal fade" id="uploadboq" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="color:black">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><b>Upload BOQ Details</b></h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="ClientName" class="col-form-label"><b>Client Name</b></label>
                                    <select name="ClientID" id="ClientID" class="form-control">
                                        <option value="">---SELECT--</option>
                                        <option value=""></option>
                                        <?php
                                            $query="select ClientID, ClientName from 1clients";
                                            $runquery=mysqli_query($conn,$query);
                                            while ($row=mysqli_fetch_assoc($runquery)) {
                                                echo '
                                                   
                                                    <option value="'.$row['ClientID'].'">'.$row['ClientName'].'</option>
                                                    
                                                ';
                                            }
                                        ?> 
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="BOQ" class="col-form-label"><b>BOQ</b></label>
                                    <input type="file" name="file" class="form-control" required>
                                </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
                        <button type="submit" name="importSubmit" class="btn btn-success" ><i class="fa fa-check-circle"></i> Upload</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


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
    <script src="js/demo/datatables-demo.js"></script>
    <script src="sweetalertresources/sweetalert.js"></script>

    <script>

        function transactionlist(){
            $.ajax({
                type: "POST",
                url: "queries/client_transaction_queries.php",
                data: {
                "show_clientorders_dashboard" : 1
                },
                success: function (x) {
                    $('#transactionlist').html(x);
                }
            });
        }
    </script>

</body>

</html>