<?php 
    session_start();
    include ('include/db.php');
    include ('include/passkey.php');
    

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
                        <h1 class="h3 mb-0 text-gray-800">Upload BOQ</h1>
                    </div>
                    

                    <!-- Content Row -->

                    <div class="card shadow mb-1">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6" style="border: 1px solid black; color: black;font-family: arial;">
                                    <p style=" font-size: 25px; "><b>Reminder for Uploading BOQ!</b></p>
                                    <ol>
                                        <li style="font-size: 20px;">Upload first BOQ Header which contain data like as follows: Site Name, Covearage Area, Address, SoW, Type Site, Project Code and PO No.</li>
                                        <li style="font-size: 20px;">Next upload the BOQ Details containing the data as follows: Supplier Part ID, MatCode, Item Description, UoM, Unit Cost and Quantity.</li>
                                    </ol>
                                </div>
                            </div><br><br><br>
                            <div style="color:black;">
                                <form method="POST" class="row g-2 float-end" enctype="multipart/form-data">
                                    <div class="container-fluid"><br>
                                        <div class="col-auto">
                                            <label for="">BOQ Header</label>
                                            <input type="file" name="file1" class="form-control mb-2" required/>
                                        </div>
                                        <div class="col-auto">
                                            <input type="submit" class="btn btn-success mb-3" name="importSubmit" value="Import">
                                        </div>
                                    </div>
                                </form>
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

    </script>

</body>

</html>