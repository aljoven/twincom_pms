<?php 
    session_start();
    include ('include/db.php');
    include ('include/passkey.php');
    $_SESSION['ClientID']=$_GET['ClientID'];
    $ClientID=$_SESSION['ClientID'];

    $dataquery="select a.BoqID,a.ClientID,a.SiteName, a.CoverageArea, a.Address, a.SoW, a.TypeSite, a.PONo, a.ProjectCode, DATE_FORMAT(a.TS, '%M %d, %Y') AS BOQDate, b.ClientName, c.SupPartID, c.MatCode, c.ItemDescription, c.UoM, c.UnitCost, c.Qty, (c.UnitCost*c.Qty) AS Total FROM 2boq a join 1clients b on a.ClientID=b.ClientID join 2boqsub c on a.BoqID=c.BoqID WHERE c.ClientID=$_GET[ClientID] and c.BoqID=$_GET[BoqID]";

    // echo $dataquery;

    // $data2="select BoqSubID,SupPartID, MatCode, ItemDescription, UOM, UnitCost, Qty, b.BoqID, (Qty*UnitCost) AS Total from 2boqsub a join 2boq b on a.BoqID=b.BoqID where a.BoqID=$_GET[BoqID]";

    
    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Writer\Xls;

    if(isset($_POST['export_excel_btn']))
    {
        $fileName = "BOQ";

        $boq = $dataquery;
        $query_run = mysqli_query($conn, $boq);

        $boqsub = $data2;
        $query_run1 = mysqli_query($conn, $boqsub);


        if(mysqli_num_rows($query_run)> 0)
        {
            $spreadsheet = new  Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'BOQ Date');
            $sheet->setCellValue('A2', 'Site Name');
            $sheet->setCellValue('A3', 'Coverage Area');
            $sheet->setCellValue('A4', 'Address');
            $sheet->setCellValue('A5', 'SoW');
            $sheet->setCellValue('A6', 'Type Site');
            $sheet->setCellValue('A7', 'Supplier Part ID');
            $sheet->setCellValue('B7', 'MatCode');
            $sheet->setCellValue('C7', 'Item Description');
            $sheet->setCellValue('D7', 'UoM');
            $sheet->setCellValue('E7', 'Unit Cost');
            $sheet->setCellValue('F7', 'Quantity');
            $sheet->setCellValue('G7', 'Total Cost (Php)');



            $rowCount = 2;
            foreach($query_run as $data)
            {
                $sheet->setCellValue('B1', $data['BOQDate']);
                $sheet->setCellValue('B2', $data['SiteName']);
                $sheet->setCellValue('B3', $data['CoverageArea']);
                $sheet->setCellValue('B4', $data['Address']);
                $sheet->setCellValue('B5', $data['SoW']);
                $sheet->setCellValue('B6', $data['TypeSite']);
                $sheet->setCellValue('A7'.$rowCount, $data['SupPartID']);
                $sheet->setCellValue('B7'.$rowCount, $data['MatCode']);
                $sheet->setCellValue('C7'.$rowCount, $data['ItemDescription']);
                $sheet->setCellValue('D7'.$rowCount, $data['UoM']);
                $sheet->setCellValue('E7'.$rowCount, $data['UnitCost']);
                $sheet->setCellValue('F7'.$rowCount, $data['Qty']);
                $sheet->setCellValue('G7'.$rowCount, $data['Total']);
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
            // header('Location: supplier.php');
            // exit(0);
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

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php 
        // include ('include/sidebar.php')
        ;?>
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
                        <h1 class="h3 mb-0 text-gray-800">BOQ Details</h1>
                        <form method="POST">
                            <button class="d-none d-sm-inline-block btn btn-sm btn-outline-success shadow-sm float-right" type="submit" name="export_excel_btn"><i class="fas fa-download fa-sm text-white-50"></i> <b>Generate Report</b></button>
                        </form>
                    </div>
                    
                    <!-- Content Row -->

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <?php 
                                $data1=mysqli_query($conn,$dataquery.  " limit 1");
                                while ($row=mysqli_fetch_assoc($data1)) {
                                    echo '
                                        <div class="table-responsive">
                                            <table class="table table-bordered" width="100%" cellspacing="0">
                                                <thead class="text-left" style="color: black">
                                                    <tr>
                                                        <th colspan="2">BOQ Date</th>
                                                        <th colspan="7">'.$row['BOQDate'].'</th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="2">Client Name</th>
                                                        <th colspan="7">'.$row['ClientName'].'</th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="2">Coverage Area</th>
                                                        <th colspan="7">'.$row['CoverageArea'].'</th>
                                                    </tr>

                                                    <tr>
                                                        <th colspan="2">Address</th>
                                                        <th colspan="7">'.$row['Address'].'</th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="2">SoW</th>
                                                        <th colspan="7">'.$row['SoW'].'</th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="2">Type Site</th>
                                                        <th colspan="7">'.$row['TypeSite'].'</th>
                                                    </tr>
                                                </thead>
                                                
                                                <thead class="text-center" style="color: black">
                                                    <tr>
                                                        <th width="1%">#</th>
                                                        <th>Supplier Part ID</th>
                                                        <th>Matcode</th>
                                                        <th>Item Description</th>
                                                        <th>UoM</th>
                                                        <th>Unit Cost</th>
                                                        <th>Quantity</th>
                                                        <th>Total Cost (Php)</th>
                                                    </tr>
                                                </thead>
                                                ';
                                                $data2=$dataquery;
                                                $rundata2=mysqli_query($conn,$data2);
                                                $count=0;
                                                $total=0;
                                                $totalcost=0;
                                                while ($rowdata2=mysqli_fetch_assoc($rundata2)) {
                                                    $totalcost+=$rowdata2['Total'];
                                                    echo'
                                                        <tbody style="color: black">
                                                            <tr>
                                                                <td class="text-center">'.++$count.'.</td>
                                                                <td>'.$rowdata2['SupPartID'].'</td>
                                                                <td class="text-center">'.$rowdata2['MatCode'].'</td>
                                                                <td>'.$rowdata2['ItemDescription'].'</td>
                                                                <td class="text-center">'.$rowdata2['UoM'].'</td>
                                                                <td>'.number_format($rowdata2['UnitCost'],2).'</td>
                                                                <td class="text-center">'.$rowdata2['Qty'].'</td>
                                                                <td class="text-center">'.number_format($rowdata2['Total'],2).'</td>
                                                            </tr>
                                                        </tbody>
                                                    ';   
                                                }echo '
                                                <tbody>
                                                    <tr style="color: black">
                                                        <td colspan="7"></td>
                                                        <td class="text-center"><b>'.number_format($totalcost,2).'</b></td>
                                                    </tr>
                                                </tbody>
                                                
                                            </table>
                                        </div>
                                    ';
                                }
                            ?>
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
    </script>

</body>

</html>