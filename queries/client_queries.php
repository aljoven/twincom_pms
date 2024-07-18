<?php
    session_start();
    include ('../include/db.php');
    include ('../include/passkey.php');

    if (isset($_POST['save_client'])) {
        
        $query="insert into 1clients (ClientName, Address, TIN, TelNo, EncodedBy, TS) values ('$_POST[ClientName]', '$_POST[Address]', '$_POST[TIN]', '$_POST[TelNo]', '$EmpID', 'TS'=NOW())";
        $runquery=mysqli_query($conn,$query);
    }

    if (isset($_POST['show_clientlist'])) {
        echo'
            <table class="table table-responsive table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr class="text-center" style="color: black;">
                        <th width="1%">#</th>
                        <th>Client Name</th>
                        <th>Client Address</th>
                        <th>TIN No.</th>
                        <th>Tel. No.</th>
                        <th width="1%"></th>
                    </tr>
                </thead>
                <tbody>';
                $query="select ClientID, ClientName, Address, TIN, TelNo from 1clients";
                $run=mysqli_query($conn, $query);
                $count=0;
                while ($row=mysqli_fetch_assoc($run)) {
                    echo '
                        <tr style="color: black;">
                            <td>'.++$count.'.</td>
                            <td>'.ucwords($row['ClientName']).'</td>
                            <td>'.ucwords($row['Address']).'</td>
                            <td>'.$row['TIN'].'</td>
                            <td>'.$row['TelNo'].'</td>
                            <td>
                                <button class="btn btn-sm btn-outline-info" data-toggle="tooltip" data-placement="top" title="Update Client Details" onclick="update_record('.$row['ClientID'].')"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                    ';
                }
                echo'
                </tbody>
            </table>
        ';
    }

    if (isset($_POST['editclientrecordmodal'])) {
        $query=mysqli_query($conn, "select * from 1clients where ClientID='$_POST[ClientID]'");
        $row=mysqli_fetch_assoc($query);

        echo "<script> $('#modal').modal('show');</script>";
        echo '
            <div class="modal" id="modal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Client Record</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">  
                                    <label for=""><b>Client Name</b></label><br>
                                        <input id="editClientName" value="'.$row['ClientName'].'" type="text" placeholder="" class="form-control" autofocus>
                                    </div>
                                <div class="col-lg-12"><br>
                                    <label><b>Address</b></label>
                                    <input id="editAddress" value="'.$row['Address'].'" type="text" name="" class="form-control">
                                </div>
                                <div class="col-lg-12"><br>
                                    <label><b>TIN No</b></label>
                                    <input id="editTIN" value="'.$row['TIN'].'" type="text" name="" class="form-control">
                                </div>
                                <div class="col-lg-12"><br>
                                    <label><b>Tel No</b></label>
                                    <input id="editTelNo" value="'.$row['TelNo'].'" type="text" name="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
                            <button id="" type="button" class="btn btn-success" onclick="savechangesclientrecord('.$row['ClientID'].')"><i class="fa fa-check-circle"></i> Save Changes</button>
                        </div>

                    </div>
                </div>
            </div>
        ';
    }

    if (isset($_POST['savechangesclient'])) {
        $query="UPDATE `1clients` SET `ClientName`='$_POST[ClientName]',`Address`='$_POST[Address]',`TIN`='$_POST[TIN]',`TelNo`='$_POST[TelNo]', EncodeddBy='$EmpID', TS=NOW() WHERE ClientID='$_POST[ClientID]'";
        $runquery=mysqli_query($conn,$query);
    }


    if (isset($_POST['uploadboq_modal'])) {
        echo "<script> $('#modal').modal('show');</script>";
        echo '
            <div class="modal" id="modal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Upload BOQ</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <form method="POST" class="row g-2 float-end" enctype="multipart/form-data">
                                <div class="col-auto">
                                    <input type="file" name="file1" class="form-control" required/>
                                </div>
                                <div class="col-auto">
                                    <input type="submit" class="btn btn-success mb-3" name="importSubmit" value="Upload">
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }

    
    require '../vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    if(isset($_POST['importSubmit']))
    {
        $fileName1 = $_FILES['file1']['name'];
        $file_ext1 = pathinfo($fileName1, PATHINFO_EXTENSION);

        $allowed_ext = ['xls','csv','xlsx'];

        if(in_array($file_ext1,  $allowed_ext))
        {
            $inputFileNamePath1 = $_FILES['file1']['tmp_name'];
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
                    $UnitCost = str_replace(',', '', $row[11]);
                    $Qty =  $row1[12];

                    $query="INSERT INTO `2boq` (`SiteName`, `CoverageArea`, `Address`, `SoW`, `TypeSite`, `PONo`, `ProjectCode`, `ClientID`, `EncodedBy`, `TS`, `Status`) VALUES ('$SiteName', '$CoverageArea', '$Address', '$SoW', '$TypeSite', '$PONo', '$ProjectCode', '$ClientID', '$EmpID', NOW(), '')";

                    $runquery = mysqli_query($conn, $query);
                    $msg = true;

                    $getdata="SELECT LAST_INSERT_ID(), ClientID  from 2boq limit 1";
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
    }
    
?>
<script>

    if ( $.fn.dataTable.isDataTable( '#dataTable' ) ) {
        table = $('#dataTable').DataTable();
    }
    else {
        table = $('#dataTable').DataTable( {
            paging: true
        } );
    }

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    
</script>