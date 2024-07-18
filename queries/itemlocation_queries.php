<?php
    session_start();
    include ('../include/db.php');
    include ('../include/passkey.php');

    if (isset($_POST['show_locationlist'])) {
        echo '
            <table class="table table-bordered" id="dataTable" id="destroy" style="width:100%" cellspacing="0">
            <thead>
                <tr class="text-center" style="color: black;">
                    <th width="1%">#</th>
                    <th>Location Description</th>
                    <th>Encoded By</th>
                    <th>TS</th>
                    <th width="1%"></th>
                </tr>
            </thead>
            
            <tbody>';
            $data=mysqli_query($conn, "select LocationID, LocDescription, TS, concat(FName, ' ', LName) AS FullName  from 1location a join 1employees b on a.Encodedby=b.EmpID");
            $count=0;
            while ($rowdata=mysqli_fetch_assoc($data)) {
                echo '
                    <tr style="color: black;">
                        <td class="text-center">'.++$count.'.</td>
                        <td>'.$rowdata['LocDescription'].'</td>
                        <td>'.$rowdata['FullName'].'</td>
                        <td>'.$rowdata['TS'].'</td>
                        <td>
                            <button class="btn btn-sm btn-outline-info" data-toggle="tooltip" data-placement="top" title="Update Location Details" onclick="update_location('.$rowdata['LocationID'].')"><i class="fas fa-edit"></i></button>
                        </td>
                    </tr>';
            }
               echo ' </tbody>
            
            </table>
        ';
    }


    //saving new item location
    if (isset($_POST['save_itemlocation'])) {
        $query="insert into 1location (`LocDescription`, `Encodedby`, `TS`) values ('$_POST[LocDescription]', '$EmpID', NOW())";
        $run=mysqli_query($conn,$query);
    }


    //showing modal for updating items location
    if (isset($_POST['editlocationmodal'])) {
        $query=mysqli_query($conn, "select * from 1location where LocationID='$_POST[LocationID]'");
        $row=mysqli_fetch_assoc($query);
        
        echo "<script> $('#modal').modal('show');</script>";
        echo '
            <div class="modal" id="modal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Items Location Details</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                            <div class="form-group col-lg-12">
                                <label for="" class="col-form-label"><b>Location Description</b></label>
                                <input type="text" class="form-control" value="'.$row['LocDescription'].'" id="uLocDescription">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
                            <button id="" type="button" class="btn btn-success" onclick="update_location_details('.$row['LocationID'].')"><i class="fa fa-check-circle"></i> Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        ';
    } 


    //updating items location details
    if (isset($_POST['save_changes_locations'])) {
        $query="UPDATE `1location`
        SET
        `LocDescription` = '$_POST[LocDescription]',
        `Encodedby` = '$EmpID',
        `TS` = NOW() 
        WHERE `LocationID` = '$_POST[LocationID]'";
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