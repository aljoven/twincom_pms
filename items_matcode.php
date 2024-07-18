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

    <style>

        #itemlist{
            position: relative;
            overflow: auto;
            white-space: nowrap;
        }

    </style>
</head>

<body id="page-top" onload="itemlist()">

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
                    <div class="d-sm-flex align-items-center justify-content-between mb-2">
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-outline-primary shadow-sm ml-auto" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-plus fa-sm text-white-50"></i> Add New Items</a>
                    </div>
                    

                    <!-- Content Row -->

                    <div class="card shadow mb-2">
                        <div class="card-header py-3">
                            <button class="d-none d-sm-inline-block btn btn-sm btn-outline-danger shadow-sm"  onclick="items_category()"><b>Items per Category</b></button>
                            <button class="d-none d-sm-inline-block btn btn-sm btn-outline-danger shadow-sm"  onclick="items_location()"><b>Items per Location</b></button>
                            <button class="d-none d-sm-inline-block btn btn-sm btn-outline-success shadow-sm float-right"><i class="fas fa-download fa-sm text-white-50"></i> <b>Generate Report</b></button>
                        </div>
                        <div class="card-body" id="view">
                            <div class="table-responsive" id="itemlist">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="show_modal"></div>
            </div>

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
                        <h5 class="modal-title"><b>Add New Items</b></h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="CatID" class="col-form-label"><b>Category</b></label>
                                    <input list="CatID" id="catID" class="form-control" oncahge="catcode()">
                                    <datalist id="CatID">
                                    <?php
                                            $query="select CatID, CatCode from 1category";
                                            $runquery=mysqli_query($conn,$query);
                                            while ($row=mysqli_fetch_assoc($runquery)) {
                                                echo '
                                                   
                                                    <option value="'.$row['CatID'].'">'.$row['CatCode'].'</option>
                                                    
                                                ';
                                            }
                                        ?>  
                                    </datalist>
                                </div>
                                <div class="form-group col-sm-2">
                                    <label for="UoM" class="col-form-label"><b>UoM</b></label>
                                    <input type="text" class="form-control" disabled id="UoM">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
                    <button type="button" class="btn btn-success" onclick="add_sample()"><i class="fa fa-check-circle"></i> Save</button>
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
        function itemlist(){
            $.ajax({
                type: "POST",
                url: "queries/item_queries.php",
                data: {
                "show_itemlist" : 1
                },
                success: function (x) {
                    $('#itemlist').html(x);
                }
            });
        }

        function items_location(){
            $.ajax({
                type: "POST",
                url: "queries/item_queries.php",
                data: {
                "show_items_location" : 1
                },
                success: function (x) {
                    $('#itemlist').html(x);
                }
            });
        }

        function items_category(){
            $.ajax({
                type: "POST",
                url: "queries/item_queries.php",
                data: {
                "show_items_category" : 1
                },
                success: function (x) {
                    $('#itemlist').html(x);
                }
            });
        }

        function add_sample(){
            var CatID = $('#catID').val();
            $.ajax({
                type:"POST",
                url: "queries/item_queries.php",
                async: false,
                data: {
                "CatID" : CatID,

                "save_sample" :'1'
            },
            success: function (x) {
                $('#CatID').val('');
                //alert
                Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Item successfully added!',
                showConfirmButton: false,
                timer: 1500
                }) .then(function() {
                window.location.href = "items.php";
                })//end alert
            }

            });
        }

        function update_items(ItemID){
            var ItemID = ItemID;
            $.ajax({
                type: "POST",
                url: "queries/item_queries.php",
                async: false,
                data:{
                    "ItemID" : ItemID,
                    "edit_item_modal" : '1'
                },
                success: function(x){
                    $('#show_modal').html(x);
                }
            });
        }

        function save_new_item_details(ItemID){
            var ItemID = ItemID;
            var ItemCode = $('#uItemCode').val();
            var ItemDescription = $('#uItemDescription').val();
            var UoM = $('#uUoM').val(); 
            var Brand = $('#uBrand').val();
            var Model = $('#uModel').val();
            var ItemAvailable = $('#uItemAvailable').val();
            var ItemCost = $('#uItemCost').val();
            var CatID = $('#uCatID').val();
            var Length = $('#uLength').val(); 
            var Width = $('#uWidth').val();
            var Height = $('#uHeight').val();
            var Weight = $('#uWeight').val();
            
            $.ajax({
                type:"POST",
                url: "queries/item_queries.php",
                async: false,
                data: {
                    "ItemID" : ItemID,
                    "ItemCode" : ItemCode,
                    "ItemDescription" : ItemDescription,
                    "UoM" : UoM,
                    "Brand" : Brand,
                    "Model" : Model,
                    "ItemAvailable" : ItemAvailable,
                    "ItemCost" : ItemCost,
                    "CatID" : CatID,
                    "Length" : Length,
                    "Width" : Width,
                    "Height" : Height,
                    "Weight" : Weight,

                    "save_changes_items_details" :'1'
                },
                success: function (x) {
                    //alert
                    Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Item details successfully updated!',
                    showConfirmButton: false,
                    timer: 1500
                    }) .then(function() {
                    window.location.href = "items.php";
                    })//end alert
                }

            });
        }

        function transfer_items_location(ItemID){
            var ItemID = ItemID;
            $.ajax({
                type: "POST",
                url: "queries/item_queries.php",
                async: false,
                data:{
                    "ItemID" : ItemID,
                    "transfer_item_modal" : '1'
                },
                success: function(x){
                    $('#show_modal').html(x);
                }
            });
        }

        function save_item_new_location(ItemID){
            var ItemID = ItemID;
            var LocationID = $('#uLocationID').val();
            $.ajax({
                type:"POST",
                url: "queries/item_queries.php",
                async: false,
                data: {
                    "ItemID" : ItemID,
                    "LocationID" : LocationID,

                    "save_changes_items_location" :'1'
                },
                success: function (x) {
                    //alert
                    Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Item Location successfully transfered!',
                    showConfirmButton: false,
                    timer: 1500
                    }) .then(function() {
                    window.location.href = "items.php";
                    })//end alert
                }

            });
        }

        function catcode(){
            var CatID = $('#catID').val();
            alert(CatID);
            $.ajax({
                type: "POST",
                url: "queries/item_queries.php",
                async: false,
                data: {
                    "CatID" : CatID,
                    "get_catid": '1'
                },
                success: function (x) {
                    $('#UoM').val(x);  
                }
            });
        }

        $('#CatID').editableSelect({
            appendTo: '.modal-body'
        });
    </script>

</body>

</html>
