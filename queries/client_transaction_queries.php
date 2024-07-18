<?php
    session_start();
    include ('../include/db.php');
    include ('../include/passkey.php');
    // $ClientID=$_SESSION['ClientID'];

    if (isset($_POST['show_clientorders_dashboard'])) {
        echo'
            <table class="table table-responsive table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr class="text-center" style="color: black;">
                        <th width="1%">#</th>
                        <th>Client Name</th>
                        <th>Address</th>
                        <th>No. of Transactions</th>
                        <th width="1%"></th>
                    </tr>
                </thead>
                <tbody>';
                $query="select b.ClientID,ClientName, count(b.ClientID) AS No, a.Address from 1clients a join 2boq b where a.ClientID=b.ClientID group by b.CLientID";
                $no=
                $run=mysqli_query($conn, $query);
                $count=0;
                while ($row=mysqli_fetch_assoc($run)) {
                    echo '
                        <tr style="color: black;">
                            <td>'.++$count.'.</td>
                            <td>'.ucwords($row['ClientName']).'</td>
                            <td>'.ucwords($row['Address']).'</td>
                            <td>'.$row['No'].'</td>
                            <td>
                                <a href="clienttransaction.php?ClientID='.$row['ClientID'].'">
                                    <button class="btn btn-sm btn-outline-info" data-toggle="tooltip" data-placement="top" title="Show Client Transactions"><i class="fas fa-arrow-circle-right"></i></button>
                                </a>
                            </td>
                        </tr>
                    ';
                }
                echo'
                </tbody>
            </table>
        ';
    }
    
    //save client transaction
    if (isset($_POST['save_clienttransaction'])) {
        
        $query="INSERT INTO 2boq (`SiteName`, `CoverageArea`, `Address`, `SoW`, `TypeSite`, `PONo`, `ProjectCode`, `ClientID`, `EncodedBy`, `TS`, `Status`) VALUES ('$_POST[SiteName]', '$_POST[CoverageArea]', '$_POST[Address]', '$_POST[SoW]', '$_POST[TypeSite]', '$_POST[PONo]', '$_POST[ProjectCode]', '$_POST[ClientID]', '$EmpID', NOW(), '')";
        $runquery=mysqli_query($conn,$query);
    }


    //show transfer of items location modal
    if (isset($_POST['transfer_item_modal'])) {
        $query=mysqli_query($conn, "select ItemID, ItemCode, ItemDescription,  b.LocationID, b.LocDescription from 1items a join 1location b on a.LocationID=b.LocationID where ItemID='$_POST[ItemID]'");
        $rowquery=mysqli_fetch_assoc($query);
        
        echo "<script> $('#modal').modal('show');</script>";
        echo '
            <div class="modal" id="modal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Item Location Details</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-sm-3">
                                    <label for="ItemCode" class="col-form-label"><b>Item Code</b></label>
                                    <input type="text" class="form-control" id="uItemCode" value="'.$rowquery['ItemCode'].'" readonly>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="ItemDescription" class="col-form-label"><b>Item Description</b></label>
                                    <input type="text" class="form-control" id="uItemDescription" value="'.$rowquery['ItemDescription'].'" readonly>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="LocationID" class="col-form-label"><b>Item Location</b></label>
                                    <select name="LocationID" id="uLocationID" class="form-control" >
                                        <option value="'.$rowquery['LocationID'].'">'.$rowquery['LocDescription'].'</option>
                                        <option value="">~~Select Items Category~~</option>
                                        <option value=""></option>';

                                            $query="select LocationID, LocDescription from 1location";
                                            $runquery=mysqli_query($conn,$query);
                                            while ($row=mysqli_fetch_assoc($runquery)) {
                                                echo '
                                                    <option value="'.$row['LocationID'].'">'.$row['LocDescription'].'</option>
                                                ';
                                            }echo'
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
                            <button id="" type="button" class="btn btn-success" onclick="save_item_new_location('.$rowquery['ItemID'].')"><i class="fa fa-check-circle"></i> Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }


    //saving new item location
    if (isset($_POST['save_changes_items_location'])) {
        $query="update 1items set LocationID='$_POST[LocationID]', EncodedBy='$EmpID', TS=NOW() where ItemID='$_POST[ItemID]'";
        $run=mysqli_query($conn,$query);
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
