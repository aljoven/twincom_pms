<?php 
    session_start();
    include ('include/db.php');
    include ('include/passkey.php');

    $_SESSION['BoqID']=$_GET['BoqID'];
    $BoqID=$_SESSION['BoqID'];
    $_SESSION['ClientID']=$_GET['ClientID'];
    $ClientID=$_SESSION['ClientID'];
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
    <link href="sweetalertresources/sweetalert.css" rel="stylesheet">
    <!-- <link href="sweetalertresources/sweetalert2.min.css" rel="stylesheet"> -->
    <link href="vendor1/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor1/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top" onload="item_reservation()">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php 
        // include ('include/sidebar.php')
        ?>
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
                    <!-- Content Row -->

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <table class="table table-bordered table-sm" width="50%" cellspacing="0" style="color:black">
                                <?php

                                    $query="select a.BoqID, sum(a.Qty*b.Qty) AS Total, c.ClientName from 2boqsub a join 1tccode b on a.MatCode=b.ClientCode join 1clients c on a.ClientID=c.ClientID where a.BoqID=$BoqID and c.ClientID=$ClientID";
                                    $run=mysqli_query($conn,$query);
                                    $getrun=mysqli_fetch_assoc($run);
                                    $count=0;
                                    if (empty($getrun['BoqID'])) {
                                        $boq='';
                                        $clientname='';
                                    }else {
                                        $boq='BOQ-00'.$getrun['BoqID'].'';
                                        $clientname=$getrun['ClientName'];
                                    }
                                    
                                    $issued="select sum(Qty) AS Issued from 1items_issuance where Status='2' AND BoqID=$BoqID and ClientID=$ClientID";
                                    $runissued=mysqli_query($conn,$issued);
                                    $getissued=mysqli_fetch_assoc($runissued);
                                    if (empty($getissued['Issued'])) {
                                        $issued=0;
                                    }else {
                                        $issued=$getissued['Issued'];
                                    }
                                    $issuedpercent=($issued/$getrun['Total'])*100;
                                    $balance=$getrun['Total']-$issued;
                                    $balancepercent=($balance/$getrun['Total'])*100;

                                    if (is_int($issuedpercent) || is_int($balancepercent)) {
                                        $ispercent=$issuedpercent;
                                        $balpercent=$balancepercent;
                                    }else {
                                        $ispercent = preg_replace('/([\d,]+.\d{1})\d+/', '$1', $issuedpercent);
                                        $balpercent = preg_replace('/([\d,]+.\d{1})\d+/', '$1', $balancepercent);
                                    }
                                    
                                    echo'    
                                    <thead>
                                        <tr>
                                            <th width="10%">Client Name:</th>
                                            <th>'.$clientname.'</th>
                                        </tr>
                                        <tr>
                                            <th width="10%">BOQ No:</th>
                                            <th>'.$boq.'</th>
                                        </tr>
                                        <tr>
                                            <th width="10%">Total Quantity:</th>
                                            <th>'.$getrun['Total'].'</th>
                                        </tr>
                                        <tr>
                                            <th width="10%">Issued:</th>
                                            <th>'.$ispercent.' %</th>
                                        </tr>
                                        <tr>
                                            <th width="10%">Balance:</th>
                                            <th>'.$balpercent.' %</th>
                                        </tr>
                                    </thead>
                                </table>';
                            ?>


                        <br>    
                        
                        <!-- for reservation process -->
                        <div id="item_reservation">
                            
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
    <script src="js/demo/datatables-demo.js"></script>
    <script src="sweetalertresources/sweetalert.js"></script>
    <!-- <script src="sweetalertresources/sweetalert2.all.min.js"></script> -->

    <script>

        function item_reservation(){
            $.ajax({
                type: "POST",
                url: "queries/item_queries.php",
                data: {
                "show_items_for_reservation" : 1
                },
                success: function (x) {
                    $('#item_reservation').html(x);
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
        

        function items_reservation(BoqID,ItemID,ClientID){
            var BoqID = BoqID;
            var ItemID = ItemID;
            var ClientID = ClientID;
            $.ajax({
                type: "POST",
                url: "queries/item_queries.php",
                async: false,
                data:{
                    "BoqID" : BoqID,
                    "ItemID" : ItemID,
                    "ClientID" : ClientID,
                    "reserve_items_modal" : '1'
                },
                success: function(x){
                    $('#show_modal').html(x);
                }
            });
        }

        function save_item_reservation(BoqID,ItemID,ClientID){
            var BoqID = BoqID;
            var ItemID = ItemID;
            var ClientID = ClientID;
            var Qty = $('#Qty').val();
            $.ajax({
                type: "POST",
                url: "queries/item_queries.php",
                async: false,
                data:{
                    "BoqID" : BoqID,
                    "ItemID" : ItemID,
                    "ClientID" : ClientID,
                    "Qty" : Qty,
                    "save_item_reservation" : '1'
                },
                success: function (x) {
                    $('#Qty').val('');
                //alert
                Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Items successfully reserved!',
                showConfirmButton: false,
                timer: 1500
                }).then(function() {
                        window.location.href = "clients.php";
                        window.location.reload();
                    })//end alert 
                }
            });
        }

        function view_totalitems_reserved(ItemID){
            var ItemID = ItemID;
            $.ajax({
                type: "POST",
                url: "queries/item_queries.php",
                async: false,
                data:{
                    "ItemID" : ItemID,
                    "view_totalitems_reserved_modal" : '1'
                },
                success: function(x){
                    $('#show_modal').html(x);
                }
            });
        }

        function cancel_items_reserve(ReserveID){
            var ReserveID = ReserveID;
            $.ajax({
                type: "POST",
                url: "queries/item_queries.php",
                async: false,
                data:{
                    "ReserveID" : ReserveID,
                    "cancel_reserve_items_modal" : '1'
                },
                success: function(x){
                    $('#show_modal').html(x);
                }
            });
        }

        function issued_all_items(BoqID,Status){
            var BoqID = BoqID;
            var Status = Status;
            $.ajax({
                type:"POST",
                url: "queries/item_queries.php",
                async: false,
                data: {
                    "BoqID" : BoqID,
                    "Status" : Status,
                    "items_issuance_update" :'1'
                },
                success: function (x) {
                    //alert
                    Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Item successfully transfered!',
                    showConfirmButton: false,
                    timer: 1500
                    }) 
                    // .then(function() {
                    // window.location.href = "items.php";
                    // })//end alert
                }

            });
        }

        function issuance_per_items(ReserveID,ItemID) {
            var ReserveID = ReserveID;
            var ItemID = ItemID;
            Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, process it!"
            }).then((result) => {
            if (result.value) {
                $.ajax({
                type:"POST",
                url: "queries/item_queries.php",
                async: false,
                data: {
                    "ReserveID" : ReserveID,
                    "ItemID" : ItemID,
                    "per_items_issuance_update" :'1'
                },
                success: function (x) {
                    //alert
                    Swal.fire({
                    title: "Done!",
                    text: "Items are ready for issuance.",
                    icon: "success"
                    }).then(function() {
                    window.location.reload();
                    })//end alert
                }
                })
                    
                }

            });
        }
    </script>

</body>

</html>