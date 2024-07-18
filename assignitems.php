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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Items Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" href="#" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-plus fa-sm text-white-50"></i> Add New Items</a>
                    </div>
                    

                    <!-- Content Row -->

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"></h6>
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
                                <div class="form-group col-sm-3">
                                    <label for="ItemCode" class="col-form-label"><b>Item Code</b></label>
                                    <input type="text" class="form-control" id="ItemCode">
                                </div>
                                <div class="form-group col-sm-9">
                                    <label for="ItemDescription" class="col-form-label"><b>Item Description</b></label>
                                    <input type="text" class="form-control" id="ItemDescription">
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="Brand" class="col-form-label"><b>Brand</b></label>
                                    <input type="text" class="form-control" id="Brand">
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="Model" class="col-form-label"><b>Model</b></label>
                                    <input type="text" class="form-control" id="Model">
                                </div>
                                <div class="form-group col-sm-2">
                                    <label for="ItemAvailable" class="col-form-label"><b>Items Qty</b></label>
                                    <input type="text" class="form-control" id="ItemAvailable">
                                </div>
                                <div class="form-group col-sm-2">
                                    <label for="ItemCost" class="col-form-label"><b>Item Cost</b></label>
                                    <input type="text" class="form-control" id="ItemCost">
                                </div>
                                <div class="form-group col-sm-2">
                                    <label for="UOM" class="col-form-label"><b>UoM</b></label>
                                    <input type="text" class="form-control" id="UOM">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="CatID" class="col-form-label"><b>Category</b></label>
                                    <select name="CatID" id="CatID" class="form-control">
                                        <option value="">~~Select Items Category~~</option>
                                        <option value=""></option>
                                        <?php
                                            $query="select CatID, CatDescription from 1category";
                                            $runquery=mysqli_query($conn,$query);
                                            while ($row=mysqli_fetch_assoc($runquery)) {
                                                echo '
                                                    <option value="'.$row['CatID'].'">'.$row['CatDescription'].'</option>
                                                ';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="LocationID" class="col-form-label"><b>Location</b></label>
                                    <select name="LocationID" id="LocationID" class="form-control">
                                        <option value="">~~Select Items Location~~</option>
                                        <option value=""></option>
                                        <?php
                                            $query="select LocationID, LocDescription from 1location";
                                            $runquery=mysqli_query($conn,$query);
                                            while ($row=mysqli_fetch_assoc($runquery)) {
                                                echo '
                                                    <option value="'.$row['LocationID'].'">'.$row['LocDescription'].'</option>
                                                ';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="Length" class="col-form-label"><b>Length(cm)</b></label>
                                    <input type="text" class="form-control" id="Length">
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="Width" class="col-form-label"><b>Width(cm)</b></label>
                                    <input type="text" class="form-control" id="Width">
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="Height" class="col-form-label"><b>Height(cm)</b></label>
                                    <input type="text" class="form-control" id="Height">
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="Weight" class="col-form-label"><b>Weight</b></label>
                                    <input type="text" class="form-control" id="Weight">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
                    <button type="button" class="btn btn-success" onclick="add_items()"><i class="fa fa-check-circle"></i> Save</button>
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
                url: "all_query.php",
                data: {
                "show_itemlist" : 1
                },
                success: function (x) {
                    $('#itemlist').html(x);
                }
            });
        }

        function add_items(){
            var ItemCode = $('#ItemCode').val();
            var ItemDescription = $('#ItemDescription').val();
            var UOM = $('#UOM').val(); 
            var Brand = $('#Brand').val();
            var Model = $('#Model').val();
            var ItemAvailable = $('#ItemAvailable').val();
            var ItemCost = $('#ItemCost').val();
            var CatID = $('#CatID').val();
            var LocationID = $('#LocationID').val();
            var Length = $('#Length').val(); 
            var Width = $('#Width').val();
            var Height = $('#Height').val();
            var Weight = $('#Weight').val();
            
            if(ItemCode.length ==0 || ItemDescription.length ==0 || UOM.length ==0 || ItemCost.length ==0 || CatID.length ==0 || LocationID.length ==0 ) { }
            else{
                $.ajax({
                type:"POST",
                url: "all_query.php",
                async: false,
                data: {
                "ItemCode" : ItemCode,
                "ItemDescription" : ItemDescription,
                "UOM" : UOM,
                "Brand" : Brand,
                "Model" : Model,
                "ItemAvailable" : ItemAvailable,
                "ItemCost" : ItemCost,
                "CatID" : CatID,
                "LocationID" : LocationID,
                "Length" : Length,
                "Width" : Width,
                "Height" : Height,
                "Weight" : Weight,

                "save_items" :'1'
                },
                success: function (x) {
                    $('#ItemCode').val('');
                    $('#ItemDescription').val('');
                    $('#UOM').val('');
                    $('#Brand').val('');
                    $('#Model').val('');
                    $('#ItemAvailable').val('');
                    $('#ItemCost').val('');
                    $('#CatID').val('');
                    $('#LocationID').val('');
                    $('#Length').val('');
                    $('#Width').val('');
                    $('#Height').val('');
                    $('#Weight').val('');
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
        }

        function update_items(ItemID){
            var ItemID = ItemID;
            $.ajax({
                type: "POST",
                url: "all_query.php",
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
            var UOM = $('#uUOM').val(); 
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
                url: "all_query.php",
                async: false,
                data: {
                    "ItemID" : ItemID,
                    "ItemCode" : ItemCode,
                    "ItemDescription" : ItemDescription,
                    "UOM" : UOM,
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
                url: "all_query.php",
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
                url: "all_query.php",
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
    </script>

</body>

</html>