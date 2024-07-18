<?php 
    session_start();
    include ('include/db.php');
    include ('include/passkey.php');

    $data="select a.BoqID AS BoqID,a.ClientID,a.SiteName, a.CoverageArea, a.Address, a.SoW, a.TypeSite, a.PONo, a.ProjectCode, DATE_FORMAT(a.TS, '%Y-%m-%d') AS BOQDate, b.ClientName, c.BoqSubID, c.SupPartID, c.MatCode, c.ItemDescription, c.UOM, c.UnitCost, c.Qty FROM 2boq a join 2boqsub c on a.BoqID=c.BoqID";
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

<body id="page-top" onload="boq()">

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
                        <h1 class="h3 mb-0 text-gray-800">Items for BOQ</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target=".bd-example-modal-lg"><i
                        class="fas fa-upload fa-sm text-white-50"></i> Upload BOQ Details</a> -->
                    </div>
                    

                    <!-- Content Row -->
                    
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <?php
                                $data.=" join 1clients b on a.ClientID=b.ClientID where a.BoqID =$_GET[BoqID] AND c.BoqSubID=$_GET[BoqSubID]";
                                $rundata=mysqli_query($conn,$data);
                                $count=0;
                                while ($row=mysqli_fetch_assoc($rundata)) {
                                    $total=$row['UnitCost']*$row['Qty'];
                                    echo'
                                    <h4><b>BOQ Details</b></h4>
                                        <table class="table table-bordered table-sm"  width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th colspan="2" style="border: 1px solid black">BOQ Date:</th>
                                                    <th colspan="6" style="border: 1px solid black">'.$row['BOQDate'].'</th>
                                                </tr>

                                                <tr>
                                                    <th colspan="2" style="border: 1px solid black">BOQ No:</th>
                                                    <th colspan="6" style="border: 1px solid black">'.$row['BoqID'].'</th>
                                                </tr>
                                                
                                                <tr>
                                                    <th colspan="2" style="border: 1px solid black">Client Name</th>
                                                    <th colspan="6" style="border: 1px solid black">'.$row['ClientName'].'</th>
                                                </tr>
                                            </thead>
                                            
                                            <thead>
                                                <tr>
                                                    <th style="border: 1px solid black" width="1%">#</th>
                                                    <th style="border: 1px solid black">Supplier Part ID</th>
                                                    <th style="border: 1px solid black">Matcode</th>
                                                    <th style="border: 1px solid black">Item Description</th>
                                                    <th style="border: 1px solid black">UoM</th>
                                                    <th style="border: 1px solid black">Unit Cost</th>
                                                    <th style="border: 1px solid black">Quantity</th>
                                                    <th style="border: 1px solid black">Total Cost (Php)</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td style="border: 1px solid black">'.++$count.'.</td>
                                                    <td style="border: 1px solid black">'.$row['SupPartID'].'</td>
                                                    <td style="border: 1px solid black">'.$row['MatCode'].'</td>
                                                    <td style="border: 1px solid black">'.$row['ItemDescription'].'</td>
                                                    <td style="border: 1px solid black">'.$row['UOM'].'</td>
                                                    <td style="border: 1px solid black">'.number_format($row['UnitCost'],2).'</td>
                                                    <td style="border: 1px solid black">'.$row['Qty'].'</td>
                                                    <td style="border: 1px solid black">'.number_format($total,2).'</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    ';
                                }
                            ?>
                        </div>
                        
                        <div class="card-body"><br>
                            <h4><b>Items Breakdown</b></h4>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                    <thead class="text-center">
                                        <tr>
                                            <th width="1%">#</th>
                                            <th>Item Code</th>
                                            <th>Item Description</th>
                                            <th>Brand</th>
                                            <th>Model</th>
                                            <th>UoM</th>
                                            <th>Available Item</th>
                                            <th>Item Description-Client</th>
                                            <th>Quantity</th>
                                            <th>Unit Cost</th>
                                            <th>Total Cost (Php)</th>
                                        </tr>
                                    </thead>
                                    <?php 
                                
                                        $data="select ItemCode, a.ItemDescription AS ItemDesc, a.UOM, Brand, Model, ItemCost, b.Qty, c.ItemDescription AS ClientDesc, (ItemCost*b.Qty) AS TotalCost, ItemAvailable from 1items a join 1tccode b on a.ItemID=b.ItemID join 2boqsub c on b.ClientCode=c.MatCode join 2boq d on c.BoqID=d.BoqID where d.BoqID =$_GET[BoqID] AND c.BoqSubID=$_GET[BoqSubID]";
                                        $rundata=mysqli_query($conn,$data);
                                        $count=0;
                                        $totals=0;
                                        while ($row=mysqli_fetch_assoc($rundata)) {
                                            $totals+=$row['TotalCost'];
                                            echo '
                                                <tbody>
                                                    <tr>
                                                        <td>'.++$count.'.</td>
                                                        <td>'.$row['ItemCode'].'</td>
                                                        <td>'.$row['ItemDesc'].'</td>
                                                        <td>'.$row['Brand'].'</td>
                                                        <td>'.$row['Model'].'</td>
                                                        <td>'.$row['UOM'].'</td>
                                                        <td>'.$row['ItemAvailable'].'</td>
                                                        <td>'.$row['ClientDesc'].'</td>
                                                        <td>'.$row['Qty'].'</td>
                                                        <td>'.number_format($row['ItemCost'],2).'</td>
                                                        <td>'.number_format($row['TotalCost'],2).'</td>
                                                    </tr>
                                                </tbody>
                                            ';
                                        }
                                        echo'
                                            <tbody>
                                                <tr>
                                                    <td colspan="10"></td>
                                                    <td>'.number_format($totals,2).'</td>
                                                </tr>
                                            </tbody>
                                        ';
                                    ?>  
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
    <!-- Add Client Modal-->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><b>Upload BOQ Details</b></h5>
                    </div>
                    <div class="modal-body">
                        <div class="container" style="color:black">
                            <form method="POST" class="row g-2 float-end" enctype="multipart/form-data">
                                <div class="col-auto">
                                    <input type="file" name="file" class="form-control" required/>
                                </div>
                                <div class="col-auto">
                                    <input type="submit" class="btn btn-success mb-3" name="importSubmit" value="Import CSV">
                                </div>
                            </form>
                        </div>
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
        function boq(){
            $.ajax({
                type: "POST",
                url: "all_query.php",
                data: {
                "show_boq" : 1
                },
                success: function (x) {
                    $('#boq').html(x);
                }
            });
        }

        function add_clienttransaction(){
            
            var ClientID = $('#ClientID').val();
            var SiteName = $('#SiteName').val();
            var CoverageArea = $('#CoverageArea').val();
            var Address = $('#Address').val();
            var SoW = $('#SoW').val(); 
            var TypeSite = $('#TypeSite').val();
            var PONo = $('#PONo').val(); 
            var ProjectCode = $('#ProjectCode').val();
            if(ClientID.length ==0 || PONo.length ==0 || ProjectCode.length ==0) { }
            else{
                $.ajax({
                    type:"POST",
                    url: "all_query.php",
                    async: false,
                    data: {
                        
                        "ClientID" : ClientID,
                        "SiteName" : SiteName,
                        "CoverageArea" : CoverageArea,
                        "Address" : Address,
                        "SoW" : SoW,
                        "TypeSite" : TypeSite,
                        "PONo" : PONo,
                        "ProjectCode" : ProjectCode,

                        "save_clienttransaction" :'1'
                    },
                    success: function (x) {
                        $('#ClientID').val('');
                        $('#SiteName').val('');
                        $('#CoverageArea').val('');
                        $('#Address').val('');
                        $('#SoW').val('');
                        $('#TypeSite').val('');
                        $('#PONo').val('');
                        $('#ProjectCode').val('');
                        //alert
                        Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Client successfully added!',
                        showConfirmButton: false,
                        timer: 1500
                        }) .then(function() {
                        window.location.href = "clienttransaction.php";
                        })//end alert
                    }
                });
            }
        }


        function update_record(ClientID){
            var ClientID = ClientID;
            $.ajax({
                type: "POST",
                url: "all_query.php",
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
                url: "all_query.php",
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
                clientlist();   
                //alert
                Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Client records successfully updated!',
                showConfirmButton: false,
                timer: 1500
                }).then(function() {
                        window.location.href = "clients.php";
                    })//end alert 
                }
            });
        }

        setTimeout(function() {
            $('#alert').fadeOut('fast');
        }, 5000); // <-- time in milliseconds
    </script>

</body>

</html>