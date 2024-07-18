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

<body id="page-top" onload="categorylist()">

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
                        <h1 class="h3 mb-0 text-gray-800">Item Category Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-outline-primary shadow-sm" href="#" data-toggle="modal" data-target=".bd-example-modal-lg"><i
                                class="fas fa-plus fa-sm text-white-50"></i> Add Item Category</a>
                    </div>
                    

                    <!-- Content Row -->

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <button class="d-none d-sm-inline-block btn btn-sm btn-outline-success shadow-sm float-right"><i class="fas fa-download fa-sm text-white-50"></i> <b>Generate Report</b></button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" id="categorylist">
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
                        <h5 class="modal-title"><b>Add Item Category</b></h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="form-group">
                                <label for="CatCode" class="col-form-label"><b>Category Code</b></label>
                                <input type="text" class="form-control" id="CatCode">
                            </div>
                            <div class="form-group">
                                <label for="CatDescription" class="col-form-label"><b>Description</b></label>
                                <input type="text" class="form-control" id="CatDescription">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
                    <button type="button" class="btn btn-success" onclick="add_category()"><i class="fa fa-check-circle"></i> Save</button>
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
        function categorylist(){
            $.ajax({
                type: "POST",
                url: "queries/itemcategory_queries.php",
                data: {
                "show_categorylist" : 1
                },
                success: function (x) {
                    $('#categorylist').html(x);
                }
            });
        }

        function add_category(){
            var CatCode = $('#CatCode').val();
            var CatDescription = $('#CatDescription').val();
            if(CatDescription.length ==0 || CatCode.length ==0) { }
            else{
                $.ajax({
                type:"POST",
                url: "queries/itemcategory_queries.php",
                async: false,
                data: {
                "CatCode" : CatCode,
                "CatDescription" : CatDescription,

                "save_category" :'1'
                },
                success: function (x) {
                    $('#CatCode').val('');
                    $('#CatDescription').val('');
                    //alert
                    Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Item Category successfully added!',
                    showConfirmButton: false,
                    timer: 1500
                    }) .then(function() {
                    window.location.href = "itemcategory.php";
                    })//end alert
                }

                });

            }
        }

        function update_category(CatID){
            var CatID = CatID;
            $.ajax({
                type: "POST",
                url: "queries/itemcategory_queries.php",
                async: false,
                data:{
                    "CatID" : CatID,
                    "editcategorymodal" : '1'
                },
                success: function(x){
                    $('#show_modal').html(x);
                }
            });
        }

        function update_category_details(CatID){
            var CatID = CatID;
            var CatCode = $('#uCatCode').val();
            var CatDescription = $('#uCatDescription').val();
            
            $.ajax({
                type:"POST",
                url: "queries/itemcategory_queries.php",
                async: false,
                data: {
                    "CatID" : CatID,
                    "CatCode" : CatCode,
                    "CatDescription" : CatDescription,

                    "save_changes_category" :'1'
                },
                success: function (x) {
                    //alert
                    Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Item Category successfully updated!',
                    showConfirmButton: false,
                    timer: 1500
                    }) .then(function() {
                    window.location.href = "itemcategory.php";
                    })//end alert
                    
                }

            });
        }
    </script>

</body>

</html>