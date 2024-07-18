<?php 
    session_start();
    include ('include/db.php');
    include ('include/passkey.php');
    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Writer\Xls;

    if(isset($_POST['export_excel_btn']))
    {
        $fileName = "client_list";

        $clients = "SELECT ClientName, Address, TIN, TelNo FROM 1clients";
        $query_run = mysqli_query($conn, $clients);

        if(mysqli_num_rows($query_run) > 0)
        {
            $spreadsheet = new  Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'Client Name');
            $sheet->setCellValue('B1', 'Address');
            $sheet->setCellValue('C1', 'TIN No');
            $sheet->setCellValue('D1', 'TelNo');



            $rowCount = 2;
            foreach($query_run as $data)
            {
                $sheet->setCellValue('A'.$rowCount, $data['ClientName']);
                $sheet->setCellValue('B'.$rowCount, $data['Address']);
                $sheet->setCellValue('C'.$rowCount, $data['TIN']);
                $sheet->setCellValue('D'.$rowCount, $data['TelNo']);
                $rowCount++;
            }

            $writer = new Xls($spreadsheet);
            $final_filename = $fileName.'.xls';

            // $writer->save($final_filename);
            ob_end_clean();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attactment; filename="'.urlencode($final_filename).'"');
            $writer->save('php://output');
            ob_end_clean();

        }
        else
        {
            $_SESSION['message'] = "No Record Found";
            header('Location: clients.php');
            exit(0);
        }
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

<body id="page-top" onload="clientlist()">

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
                        <h1 class="h3 mb-0 text-gray-800">Client Dashboard</h1>
                    </div>
                    

                    <!-- Content Row -->

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <form action="" method="POST">
                                <button class="d-none d-sm-inline-block btn btn-sm btn-outline-success shadow-sm float-right mr-2" type="submit" name="export_excel_btn"><i class="fas fa-download fa-sm text-white-50"></i> <b> Generate Report</b></button>
                            </form>

                            <a href="" data-toggle="modal" data-target=".bd-example-modal-lg">
                                <button class="d-none d-sm-inline-block btn btn-sm btn-outline-primary shadow-sm float-right mr-2"><i class="fas fa-plus fa-sm text-white-50"></i> <b> Add New Client</b></button>
                            </a>
                        </div>
                        <div class="card-body">
                            <div id="clientlist">
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
    <!-- Add Client Modal-->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><b>Add Client Details</b></h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="form-group">
                            <label for="ClientName" class="col-form-label"><b>Client Name</b></label>
                            <input type="text" class="form-control" id="ClientName">
                            </div>
                            <div class="form-group">
                            <label for="Address" class="col-form-label"><b>Address</b></label>
                            <input type="text" class="form-control" id="Address">
                            </div>
                            <div class="form-group">
                            <label for="TIN" class="col-form-label"><b>TIN No</b></label>
                            <input type="text" class="form-control" id="TIN">
                            </div>
                            <div class="form-group">
                            <label for="TelNo" class="col-form-label"><b>Tel No</b></label>
                            <input type="text" class="form-control" id="TelNo">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
                    <button type="button" class="btn btn-success" onclick="add_client()"><i class="fa fa-check-circle"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

        function clientlist(){
            $.ajax({
                type: "POST",
                url: "queries/client_queries.php",
                data: {
                "show_clientlist" : 1
                },
                success: function (x) {
                    $('#clientlist').html(x);
                }
            });
        }

        function add_client(){
            var ClientName = $('#ClientName').val();
            var Address = $('#Address').val();
            var TIN = $('#TIN').val(); 
            var TelNo = $('#TelNo').val();
            if(ClientName.length ==0) { }
            else{
                $.ajax({
                type:"POST",
                url: "queries/client_queries.php",
                async: false,
                data: {
                "ClientName" : ClientName,
                "Address" : Address,
                "TIN" : TIN,
                "TelNo" : TelNo,

                "save_client" :'1'
                },
                success: function (x) {
                    $('#ClientName').val('');
                    $('#Address').val('');
                    $('#TIN').val('');
                    $('#TelNo').val('');
                    //alert
                    Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Client successfully added!',
                    showConfirmButton: false,
                    timer: 1500
                    }) .then(function() {
                    window.location.href = "clients.php";
                    })//end alert
                }

                });

            }
        }
        

        function update_record(ClientID){
            var ClientID = ClientID;
            $.ajax({
                type: "POST",
                url: "queries/client_queries.php",
                async: false,
                data:{
                    "ClientID" : ClientID,
                    "editclientrecordmodal" : '1'
                },
                success: function(x){
                    $('#show_modal').html(x);
                }
            });
        }

        function savechangesclientrecord(ClientID){
            var ClientID = ClientID;
            var ClientName = $('#editClientName').val();
            var Address = $('#editAddress').val();
            var TIN = $('#editTIN').val(); 
            var TelNo = $('#editTelNo').val(); 

            $.ajax({
                type: "POST",
                url: "queries/client_queries.php",
                async: false,
                data:{
                    "ClientID" : ClientID,
                    "ClientName" : ClientName,
                    "Address" : Address,
                    "TIN" : TIN,
                    "TelNo" : TelNo,
                    "savechangesclient" : '1'
                },
                success: function (x) {
                //alert
                Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Client records successfully updated!',
                showConfirmButton: false,
                timer: 1500
                }).then(function() {
                        window.location.href = "clients.php";
                        window.location.reload();
                    })//end alert 
                }
            });
        }

        function upload_boq(ClientID){
            var ClientID = ClientID;
            $.ajax({
                type: "POST",
                url: "queries/client_queries.php",
                async: false,
                data:{
                    "ClientID" : ClientID,
                    "uploadboq_modal" : '1'
                },
                success: function(x){
                    $('#show_modal').html(x);
                }
            });
        }
    </script>

</body>

</html>