<?php
    session_start();
    include ('../include/db.php');
    include ('../include/passkey.php');

    if (isset($_POST['show_categorylist'])) {

        echo '
            <table class="table table-bordered" id="dataTable" id="destroy" style="width:100%" cellspacing="0">
            <thead>
                <tr class="text-center" style="color: black;">
                    <th width="1%">#</th>
                    <th>Category Code</th>
                    <th>Description</th>
                    <th>Encoded By</th>
                    <th>TS</th>
                    <th width="1%"></th>
                </tr>
            </thead>
            
            <tbody>';
            $data=mysqli_query($conn, "select a.*, concat(FName, ' ', LName) AS FullName from 1category a join 1employees b on a.Encodedby=b.EmpID");
            $count=0;
            while ($rowdata=mysqli_fetch_assoc($data)) {
                echo '
                    <tr style="color: black;">
                        <td class="text-center">'.++$count.'.</td>
                        <td>'.$rowdata['CatCode'].'</td>
                        <td>'.$rowdata['CatDescription'].'</td>
                        <td>'.$rowdata['FullName'].'</td>
                        <td>'.$rowdata['TS'].'</td>
                        <td>
                            <button class="btn btn-sm btn-outline-info" data-toggle="tooltip" data-placement="top" title="Update Supplier" onclick="update_category('.$rowdata['CatID'].')"><i class="fas fa-edit"></i></button>
                        </td>
                    </tr>';
            }
               echo ' </tbody>
            
            </table>
        ';
    }

    //saving item category

    if (isset($_POST['save_category'])) {
        $query="INSERT INTO `1category` (`CatDescription`, `CatCode`, `Encodedby`, `TS`) VALUES ('$_POST[CatDescription]', '$_POST[CatCode]', '$EmpID', NOW())";
        $run=mysqli_query($conn,$query);
    }

    //showing modal for updating item category details
    if (isset($_POST['editcategorymodal'])) {
        $query=mysqli_query($conn, "select * from 1category where CatID='$_POST[CatID]'");
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
                                <label for="" class="col-form-label"><b>Category Code</b></label>
                                <input type="text" class="form-control" value="'.$row['CatCode'].'" id="uCatCode">
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="" class="col-form-label"><b>Description</b></label>
                                <input type="text" class="form-control" value="'.$row['CatDescription'].'" id="uCatDescription">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
                            <button id="" type="button" class="btn btn-success" onclick="update_category_details('.$row['CatID'].')"><i class="fa fa-check-circle"></i> Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        ';
    } 


    //saving updated item category
    if (isset($_POST['save_changes_category'])) {

        $query="UPDATE `1category`
        SET
        `CatCode` = '$_POST[CatCode]',
        `CatDescription` = '$_POST[CatDescription]',
        `Encodedby` = '$EmpID',
        `TS` = NOW() 
        WHERE `CatID` = '$_POST[CatID]'";
        $runquery=mysqli_query($conn,$query);
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