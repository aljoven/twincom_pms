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
    $fileName = "supplier_list";

    $supplier = "SELECT BusName, SupAddress, SupTin, RegOwner, ContactPerson, ContactNo, b.Description AS Description FROM 1suppliers a JOIN 1paymentterms b ON a.TermID=b.TermID";
    $query_run = mysqli_query($conn, $supplier);

    if(mysqli_num_rows($query_run) > 0)
    {
        $spreadsheet = new  Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Business Name');
        $sheet->setCellValue('B1', 'Address');
        $sheet->setCellValue('C1', 'TIN No');
        $sheet->setCellValue('D1', 'Registered Owner');
        $sheet->setCellValue('E1', 'Contact Person');
        $sheet->setCellValue('F1', 'Contact No');
        $sheet->setCellValue('G1', 'Payment Terms');



        $rowCount = 2;
        foreach($query_run as $data)
        {
            $sheet->setCellValue('A'.$rowCount, $data['BusName']);
            $sheet->setCellValue('B'.$rowCount, $data['SupAddress']);
            $sheet->setCellValue('C'.$rowCount, $data['SupTin']);
            $sheet->setCellValue('D'.$rowCount, $data['RegOwner']);
            $sheet->setCellValue('E'.$rowCount, $data['ContactPerson']);
            $sheet->setCellValue('F'.$rowCount, $data['ContactNo']);
            $sheet->setCellValue('G'.$rowCount, $data['Description']);
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
        header('Location: supplier.php');
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

<body id="page-top" onload="supplierlist()">

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
                        <h1 class="h3 mb-0 text-gray-800">Suppliers Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-outline-primary shadow-sm" href="#" data-toggle="modal" data-target=".bd-example-modal-lg"><i
                                class="fas fa-plus fa-sm text-white-50"></i> Add New Supplier</a>
                    </div>
                    

                    <!-- Content Row -->

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <form method="POST">
                                <button class="d-none d-sm-inline-block btn btn-sm btn-outline-success shadow-sm float-right" type="submit" name="export_excel_btn"><i class="fas fa-download fa-sm text-white-50"></i> <b>Generate Report</b></button>
                            </form> 
                        </div>
                        <div class="card-body">
                            <!-- <div class="form-inline float-right">
                                <label for=""><b>Search: </b></label>
                                <input type="text" id="myInput" onkeyup="myInput()" class="form-control" style="margin-bottom: 10px">
                            </div> -->
                            <div class="table-responsive" id="supplierlist">
                            
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
                        <h5 class="modal-title"><b>Add Supplier Details</b></h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="form-group">
                                <label for="BusName" class="col-form-label"><b>Business Name</b></label>
                                <input type="text" class="form-control" id="BusName">
                            </div>
                            <div class="form-group">
                                <label for="SupAddress" class="col-form-label"><b>Address</b></label>
                                <input type="text" class="form-control" id="SupAddress">
                            </div>
                            <div class="form-group">
                                <label for="SupTin" class="col-form-label"><b>TIN No</b></label>
                                <input type="text" class="form-control" id="SupTin">
                            </div>
                            <div class="form-group">
                                <label for="RegOwner" class="col-form-label"><b>Registered Ownwer</b></label>
                                <input type="text" class="form-control" id="RegOwner">
                            </div>
                            <div class="form-group">
                                <label for="ContactPerson" class="col-form-label"><b>Contact Person</b></label>
                                <input type="text" class="form-control" id="ContactPerson">
                            </div>
                            <div class="form-group">
                                <label for="ContactNo" class="col-form-label"><b>Contact No</b></label>
                                <input type="text" class="form-control" id="ContactNo">
                            </div>
                            <div class="form-group">
                                <label for="TermID" class="col-form-label"><b>Payment Terms</b></label>
                                <select name="TermID" id="TermID" class="form-control">
                                    <option value="">~~Select Payment Terms~~</option>
                                    <option value=""></option>
                                    <?php
                                        $query="select TermID, Description from 1paymentterms";
                                        $runquery=mysqli_query($conn,$query);
                                        while ($row=mysqli_fetch_assoc($runquery)) {
                                            echo '
                                                <option value="'.$row['TermID'].'">'.$row['Description'].'</option>
                                            ';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
                    <button type="button" class="btn btn-success" onclick="add_suppliers()"><i class="fa fa-check-circle"></i> Save</button>
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

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <script src="sweetalertresources/sweetalert.js"></script>

    <script>

        function supplierlist(){
            $.ajax({
                type: "POST",
                url: "queries/supplier_queries.php",
                data: {
                    "show_supplierlist" : 1
                },
                success: function (x) {
                    $('#supplierlist').html(x);
                }
            });
        }

        function myInput() {
            var search = $('#myInput').val();
            $.ajax({
                type: "POST",
                url: "queries/supplier_queries.php",
                data: {
                    "search": search,
                    "show_supplierlist": '1'
                },
                success: function (x) {
                    $('#supplierlist').html(x);
                }
            });
        }

        function add_suppliers(){
            var BusName = $('#BusName').val();
            var SupAddress = $('#SupAddress').val();
            var SupTin = $('#SupTin').val(); 
            var RegOwner = $('#RegOwner').val();
            var ContactPerson = $('#ContactPerson').val();
            var ContactNo = $('#ContactNo').val();
            var TermID = $('#TermID').val();
            // alert (BusName + SupAddress + SupTin + RegOwner + ContactPerson + ContactNo + TermID);
            if(BusName.length ==0) { }
            else{
                $.ajax({
                type:"POST",
                url: "queries/supplier_queries.php",
                async: false,
                data: {
                "BusName" : BusName,
                "SupAddress" : SupAddress,
                "SupTin" : SupTin,
                "RegOwner" : RegOwner,
                "ContactPerson" : ContactPerson,
                "ContactNo" : ContactNo,
                "TermID" : TermID,

                "save_suppliers" :'1'
                },
                success: function (x) {
                    $('#BusName').val('');
                    $('#SupAddress').val('');
                    $('#SupTin').val('');
                    $('#RegOwner').val('');
                    $('#ContactPerson').val('');
                    $('#ContactNo').val('');
                    $('#TermID').val('');
                    //alert
                    Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Supplier successfully added!',
                    showConfirmButton: false,
                    timer: 1500
                    }) .then(function() {
                    window.location.href = "supplier.php";
                    })//end alert
                }

                });

            }
        }

        function update_supplier(SupplierID){
            var SupplierID = SupplierID;
            $.ajax({
                type: "POST",
                url: "queries/supplier_queries.php",
                async: false,
                data:{
                    "SupplierID" : SupplierID,
                    "editsuppliermodal" : '1'
                },
                success: function(x){
                    $('#show_modal').html(x);
                }
            });
        }

        function update_supplier_details(SupplierID){
            var SupplierID = SupplierID;
            var BusName = $('#uBusName').val();
            var SupAddress = $('#uSupAddress').val();
            var SupTin = $('#uSupTin').val(); 
            var RegOwner = $('#uRegOwner').val();
            var ContactPerson = $('#uContactPerson').val();
            var ContactNo = $('#uContactNo').val();
            var TermID = $('#uTermID').val();
            // alert (SupplierID+''+BusName+''+SupAddress+''+SupTin+''+RegOwner+''+ContactPerson+''+ContactNo+''+TermID);
            
            $.ajax({
                type:"POST",
                url: "queries/supplier_queries.php",
                async: false,
                data: {
                    "SupplierID" : SupplierID,
                    "BusName" : BusName,
                    "SupAddress" : SupAddress,
                    "SupTin" : SupTin,
                    "RegOwner" : RegOwner,
                    "ContactPerson" : ContactPerson,
                    "ContactNo" : ContactNo,
                    "TermID" : TermID,

                    "save_changes_supplier" :'1'
                },
                success: function (x) {
                    //alert
                    Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Supplier details successfully updated!',
                    showConfirmButton: false,
                    timer: 1500
                    }) .then(function() {
                    window.location.href = "supplier.php";
                    })//end alert
                    
                }

            });
        }

        
    </script>

</body>

</html>