<?php
    session_start();
    include ('../include/db.php');
    include ('../include/passkey.php');

    if (isset($_POST['show_supplierlist'])) {
        echo '
            <table class="table table-bordered" id="dataTable" id="destroy" style="width:100%" cellspacing="0">
            <thead>
                <tr class="text-center" style="color: black;">
                    <th width="1%">#</th>
                    <th>Business Name</th>
                    <th>Address</th>
                    <th>TIN No</th>
                    <th>Registered Owner</th>
                    <th>Contact Person</th>
                    <th>Contact No</th>
                    <th>Payment Terms</th>
                    <th width="1%"></th>
                </tr>
            </thead>
            
            <tbody>';
                $data=mysqli_query($conn, "select SupplierID, BusName, SupAddress, SupTin, RegOwner, ContactPerson, ContactNo, Description from 1suppliers a join 1paymentterms b on a.termid=b.termid order by SupplierID ASC");
            
            
            $count=0;
            while ($rowdata=mysqli_fetch_assoc($data)) {
                echo '
                    <tr style="color: black;">
                        <td class="text-center"><b>'.++$count.'.</b></td>
                        <td>'.$rowdata['BusName'].'</td>
                        <td>'.$rowdata['SupAddress'].'</td>
                        <td>'.$rowdata['SupTin'].'</td>
                        <td>'.$rowdata['RegOwner'].'</td>
                        <td>'.$rowdata['ContactPerson'].'</td>
                        <td>'.$rowdata['ContactNo'].'</td>
                        <td>'.$rowdata['Description'].'</td>
                        <td>
                        <button id="" class="btn btn-sm btn-outline-info" data-toggle="tooltip" data-placement="top" title="Update Supplier Details" onclick="update_supplier('.$rowdata['SupplierID'].')"><i class="fas fa-edit"></i></button>
                        </td>
                    </tr>';
            }
               echo ' </tbody>
            
            </table>
        ';
    }

    //saving suppliers
    if (isset($_POST['save_suppliers'])) {
        $query="insert into 1suppliers (`BusName`, `SupAddress`, `SupTin`, `RegOwner`, `ContactPerson`, `ContactNo`, `TermID`, `EncodedBy`, `TS`) values ('$_POST[BusName]', '$_POST[SupAddress]', '$_POST[SupTin]', '$_POST[RegOwner]', '$_POST[ContactPerson]', '$_POST[ContactNo]', '$_POST[TermID]','$EmpID', NOW())";
        $run=mysqli_query($conn,$query);
    }

    //update supplier details modal
    if (isset($_POST['editsuppliermodal'])) {
        $query=mysqli_query($conn, "select SupplierID,a.TermID, BusName, SupAddress, SupTin, RegOwner, ContactPerson, ContactNo, Description from 1suppliers a join 1paymentterms b on a.TermID=b.TermID where SupplierID='$_POST[SupplierID]'");
        $row=mysqli_fetch_assoc($query);
        
        echo "<script> $('#modal').modal('show');</script>";
        echo '
            <div class="modal" id="modal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Supplier Details</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-lg-12">
                                <label for="BusName" class="col-form-label"><b>Business Name</b></label>
                                <input type="text" class="form-control" value="'.$row['BusName'].'" id="uBusName">
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="SupAddress" class="col-form-label"><b>Address</b></label>
                                <input type="text" class="form-control" value="'.$row['SupAddress'].'" id="uSupAddress">
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="SupTin" class="col-form-label"><b>TIN No</b></label>
                                <input type="text" class="form-control" value="'.$row['SupTin'].'" id="uSupTin">
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="RegOwner" class="col-form-label"><b>Registered Ownwer</b></label>
                                <input type="text" class="form-control" value="'.$row['RegOwner'].'" id="uRegOwner">
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="ContactPerson" class="col-form-label"><b>Contact Person</b></label>
                                <input type="text" class="form-control" value="'.$row['ContactPerson'].'" id="uContactPerson">
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="ContactNo" class="col-form-label"><b>Contact No</b></label>
                                <input type="text" class="form-control" value="'.$row['ContactNo'].'" id="uContactNo">
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="TermID" class="col-form-label"><b>Payment Terms</b></label>
                                <select name="TermID" id="uTermID" class="form-control">
                                    <option value="'.$row['TermID'].'">'.$row['Description'].'</option>
                                    <option value="">~~Select Payment Terms~~</option>
                                    <option value=""></option>';
                                    $get=mysqli_query($conn, "select * from 1paymentterms");
                                    while ($getdata=mysqli_fetch_assoc($get)) {
                                        echo '
                                            <option value="'.$getdata['TermID'].'">'.$getdata['Description'].'</option>
                                        ';
                                    }
                                    echo'
                                </select>
                            </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
                            <button id="" type="button" class="btn btn-success" onclick="update_supplier_details('.$row['SupplierID'].')"><i class="fa fa-check-circle"></i> Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }

    //saving updated supplier details
    if (isset($_POST['save_changes_supplier'])) {

        $query="UPDATE `1suppliers`
        SET
        `BusName` = '$_POST[BusName]',
        `SupAddress` = '$_POST[SupAddress]',
        `SupTin` = '$_POST[SupTin]',
        `RegOwner` = '$_POST[RegOwner]',
        `ContactPerson` = '$_POST[ContactPerson]',
        `ContactNo` = '$_POST[ContactNo]',
        `TermID` = '$_POST[TermID]',
        `EncodedBy` = '$EmpID',
        `TS` = NOW() 
        WHERE `SupplierID` = '$_POST[SupplierID]'";
        $runquery=mysqli_query($conn,$query);
    }
    
?>
<script>
    // $('#dataTable').DataTable( {
    //     responsive: true
    // } )

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