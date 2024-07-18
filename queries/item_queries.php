<?php
    session_start();
    include ('../include/db.php');
    include ('../include/passkey.php');
    $BoqID=$_SESSION['BoqID'];
    $ClientID=$_SESSION['ClientID'];

    $data="select ItemCode, ItemDescription, UoM, Brand, Model, ItemAvailable, ItemCost, Length, Width, Height, Weight, (Length*Width*Height/1000000) AS CBM ";
    $orderby='order by';
    $title='';

    $itemres="select ReserveID, ItemID, BoqID, ClientID, Qty, ReserveTS, IssuedTS, Status ";
    
    if (isset($_POST['show_itemlist'])) {
        $title='<div style="color:black"><h3>Items List</h3></div><br>';
        echo '
        '.$title.'
            <table class="table table-bordered table-sm" id="dataTable" style="width:100%" cellspacing="0">
            <thead>
                <tr class="text-center" style="color: black;">
                    <th width="1%" >#</th>
                    <th>ItemCode</th>
                    <th>Description</th>
                    <th>UoM</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Qty</th>
                    <th>Item Cost</th>
                    <th>Length</th>
                    <th>Width</th>
                    <th>Height</th>
                    <th>Weight</th>
                    <th>CBM</th>
                    <th width="1%"></th>
                </tr>
            </thead>
            
            <tbody>';
            $data=mysqli_query($conn, $data." ,ItemID from 1items");
            $count=0;
            while ($rowdata=mysqli_fetch_assoc($data)) {
                echo '
                    <tr style="color: black;">
                        <td class="text-center">'.++$count.'.</td>
                       <td>'.$rowdata['ItemCode'].'</td>
                        <td>'.ucwords($rowdata['ItemDescription']).'</td>
                        <td>'.$rowdata['UoM'].'</td>
                        <td>'.$rowdata['Brand'].'</td>
                        <td>'.$rowdata['Model'].'</td>
                        <td>'.$rowdata['ItemAvailable'].'</td>
                        <td>'.number_format($rowdata['ItemCost'],2).'</td>
                        <td>'.$rowdata['Length'].'</td>
                        <td>'.$rowdata['Width'].'</td>
                        <td>'.$rowdata['Height'].'</td>
                        <td>'.$rowdata['Weight'].'</td>
                        <td>'.$rowdata['CBM'].'</td>
                        <td>
                            <button class="btn btn-sm btn-outline-info" data-toggle="tooltip" data-placement="top" title="Update Item Details" onclick="update_items('.$rowdata['ItemID'].')"><i class="fas fa-edit"></i></button>
                        </td>
                    </tr>';
            }
               echo ' </tbody>
            
            </table>
        ';
    } 

    if (isset($_POST['show_items_category'])) {
        
        $title='<div style="color:black"><h3>Items per Category</h3></div><br>';
        echo '
        '.$title.'
            <table class="table table-bordered table-sm" id="dataTable" style="width:100%" cellspacing="0">
            <thead>
                <tr class="text-center" style="color: black;">
                    <th width="1%" >#</th>
                    <th>Category</th>
                    <th>ItemCode</th>
                    <th>Description</th>
                    <th>UoM</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Qty</th>
                    <th>Item Cost</th>
                    <th>Length</th>
                    <th>Width</th>
                    <th>Height</th>
                    <th width="1%"></th>
                </tr>
            </thead>
            
            <tbody>';
            $data=mysqli_query($conn, $data. ",a.ItemID, CatCode from 1items a join 1category b on a.CatID=b.CatID $orderby a.CatID");
            $count=0;
            while ($rowdata=mysqli_fetch_assoc($data)) {
                echo '
                    <tr style="color: black;">
                        <td class="text-center">'.++$count.'.</td>
                        <td>'.$rowdata['CatCode'].'</td>
                        <td>'.$rowdata['ItemCode'].'</td>
                        <td>'.ucwords($rowdata['ItemDescription']).'</td>
                        <td>'.$rowdata['UoM'].'</td>
                        <td>'.$rowdata['Brand'].'</td>
                        <td>'.$rowdata['Model'].'</td>
                        <td>'.$rowdata['ItemAvailable'].'</td>
                        <td>'.number_format($rowdata['ItemCost'],2).'</td>
                        <td>'.$rowdata['Length'].'</td>
                        <td>'.$rowdata['Width'].'</td>
                        <td>'.$rowdata['Height'].'</td>
                        <td>
                            <button class="btn btn-sm btn-outline-info" data-toggle="tooltip" data-placement="top" title="Update Item Details" onclick="update_items('.$rowdata['ItemID'].')"><i class="fas fa-edit"></i></button>
                        </td>
                    </tr>';
            }
               echo ' </tbody>
            
            </table>
        ';
    }

    if (isset($_POST['show_items_location'])) {
        $title='<div style="color:black"><h3>Items per Location</h3></div><br>';
        echo '
        '.$title.'
            <table class="table table-bordered table-sm" id="dataTable" style="width:100%" cellspacing="0">
            <thead>
                <tr class="text-center" style="color: black;">
                    <th width="1%">#</th>
                    <th>Location</th>
                    <th>ItemCode</th>
                    <th>Description</th>
                    <th>UoM</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Qty</th>
                    <th>Item Cost</th>
                    <th>Length</th>
                    <th>Width</th>
                    <th>Height</th>
                    <th width="1%"></th>
                </tr>
            </thead>
            
            <tbody>';
            $data=mysqli_query($conn, $data. ", a.ItemID, LocDescription from 1items a join 1location b on a.LocationID=b.LocationID $orderby a.LocationID");
            $count=0;
            while ($rowdata=mysqli_fetch_assoc($data)) {
                echo '
                    <tr style="color: black;">
                        <td class="text-center">'.++$count.'.</td>
                        <td>'.$rowdata['LocDescription'].'</td>
                       <td>'.$rowdata['ItemCode'].'</td>
                        <td>'.ucwords($rowdata['ItemDescription']).'</td>
                        <td>'.$rowdata['UoM'].'</td>
                        <td>'.$rowdata['Brand'].'</td>
                        <td>'.$rowdata['Model'].'</td>
                        <td>'.$rowdata['ItemAvailable'].'</td>
                        <td>'.number_format($rowdata['ItemCost'],2).'</td>
                        <td>'.$rowdata['Length'].'</td>
                        <td>'.$rowdata['Width'].'</td>
                        <td>'.$rowdata['Height'].'</td>
                        <td>
                            <button class="btn btn-sm btn-outline-info" data-toggle="tooltip" data-placement="top" title="Update Item Details" onclick="update_items('.$rowdata['ItemID'].')"><i class="fas fa-edit"></i></button>
                        </td>
                    </tr>';
            }
               echo ' </tbody>
            
            </table>
        ';
    }

    if (isset($_POST['save_items'])) {
        $ItemCost=str_replace(",", "", $_POST['ItemCost']);
        $query="INSERT INTO `1items` (`ItemCode`, `ItemDescription`, `UoM`, `Brand`, `Model`, `ItemAvailable`, `ItemCost`, `CatID`, `LocationID`, `Length`, `Width`, `Height`, `Weight`, `EncodedBy`, `TS`) VALUES ('$_POST[ItemCode]', '$_POST[ItemDescription]', '$_POST[UoM]', '$_POST[Brand]', '$_POST[Model]', '$_POST[ItemAvailable]', '$ItemCost', '$_POST[CatID]', '$_POST[LocationID]', '$_POST[Length]', '$_POST[Width]', '$_POST[Height]', '$_POST[Weight]', '$EmpID', NOW())";
        $runquery=mysqli_query($conn,$query);
    }


    if (isset($_POST['edit_item_modal'])) {
        $query=mysqli_query($conn, "select ItemID, ItemCode, ItemDescription, UoM, Brand, Model, ItemAvailable, ItemCost, b.CatID, b.CatDescription, Length, Width, Height, Weight from 1items a join 1category b on a.CatID=b.CatID where ItemID='$_POST[ItemID]'");
        $rowquery=mysqli_fetch_assoc($query);
        
        echo "<script> $('#modal').modal('show');</script>";
        echo '
            <div class="modal" id="modal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Item Details</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-sm-3">
                                    <label for="ItemCode" class="col-form-label"><b>Item Code</b></label>
                                    <input type="text" class="form-control" id="uItemCode" value="'.$rowquery['ItemCode'].'">
                                </div>
                                <div class="form-group col-sm-9">
                                    <label for="ItemDescription" class="col-form-label"><b>Item Description</b></label>
                                    <input type="text" class="form-control" id="uItemDescription" value="'.$rowquery['ItemDescription'].'">
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="Brand" class="col-form-label"><b>Brand</b></label>
                                    <input type="text" class="form-control" id="uBrand" value="'.$rowquery['Brand'].'">
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="Model" class="col-form-label"><b>Model</b></label>
                                    <input type="text" class="form-control" id="uModel" value="'.$rowquery['Model'].'">
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="ItemAvailable" class="col-form-label"><b>Items Qty</b></label>
                                    <input type="text" class="form-control" id="uItemAvailable" value="'.$rowquery['ItemAvailable'].'">
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="ItemCost" class="col-form-label"><b>Item Cost</b></label>
                                    <input type="text" class="form-control" id="uItemCost" value="'.$rowquery['ItemCost'].'">
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="UoM" class="col-form-label"><b>UoM</b></label>
                                    <input type="text" class="form-control" id="uUoM" value="'.$rowquery['UoM'].'">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="CatID" class="col-form-label"><b>Category</b></label>
                                    <select name="CatID" id="uCatID" class="form-control" >
                                        <option value="'.$rowquery['CatID'].'">'.$rowquery['CatDescription'].'</option>
                                        <option value="">~~Select Items Category~~</option>
                                        <option value=""></option>';

                                            $query="select CatID, CatDescription from 1category";
                                            $runquery=mysqli_query($conn,$query);
                                            while ($row=mysqli_fetch_assoc($runquery)) {
                                                echo '
                                                    <option value="'.$row['CatID'].'">'.$row['CatDescription'].'</option>
                                                ';
                                            }echo'
                                    </select>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="Length" class="col-form-label"><b>Length(cm)</b></label>
                                    <input type="text" class="form-control" id="uLength" value="'.$rowquery['Length'].'">
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="Width" class="col-form-label"><b>Width(cm)</b></label>
                                    <input type="text" class="form-control" id="uWidth" value="'.$rowquery['Width'].'">
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="Height" class="col-form-label"><b>Height(cm)</b></label>
                                    <input type="text" class="form-control" id="uHeight" value="'.$rowquery['Height'].'">
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="Weight" class="col-form-label"><b>Weight</b></label>
                                    <input type="text" class="form-control" id="uWeight" value="'.$rowquery['Weight'].'">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
                            <button id="" type="button" class="btn btn-success" onclick="save_new_item_details('.$rowquery['ItemID'].')"><i class="fa fa-check-circle"></i> Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }


    //saving items details updated
    if (isset($_POST['save_changes_items_details'])) {
        $ItemCost=str_replace(",", "", $_POST['ItemCost']);

        $query="UPDATE `1items` SET `ItemCode` = '$_POST[ItemCode]', `ItemDescription` = '$_POST[ItemDescription]', `UoM` = '$_POST[UoM]', `Brand` = '$_POST[Brand]', `Model` = '$_POST[Model]', `ItemAvailable` = '$_POST[ItemAvailable]', `ItemCost` = $ItemCost', `CatID` = '$_POST[CatID]', `Length` = '$_POST[Length]', `Width` = '$_POST[Width]', `Height` = '$_POST[Height]', `Weight` = '$_POST[Weight]', `EncodedBy` = '$EmpID', `TS` = NOW() WHERE `ItemID` = '$_POST[ItemID]'";
        $runquery=mysqli_query($conn,$query);
    }

    if (isset($_POST['show_items_for_reservation'])) {
        echo '
            <div class="text-center"><b><span style="font-size: 25px; color:black">RESERVATION/ISSUANCE OF ITEMS</span></b></div>
            <table class="table table-bordered table-responsive" width="100%" cellspacing="0" style="color:black">
                <thead style="color: black; background-color: #d8e0ed">
                    <tr class="text-center">
                        <th width="1%">#</th>
                        <th>PROJECT</th>
                        <th>BREAKDOWN</th>
                        <th>ITEM DESCRIPTION</th>
                        <th>BRAND</th>
                        <th>MODEL</th>
                        <th>UOM</th>
                        <th>QTY<br>REQUIRED</th>
                        <th>BALANCE</th>
                        <th>%</th>
                        <th>ISSUED</th>
                        <th>%</th>
                        <th>ONHAND</th>
                        <th>AVAILABLE<br>ITEMS<br>QTY</th>
                        <th>RESERVED<br>ITEMS</th>
                        <th>TOTAL RESERVED ITEMS</th>
                        <th colspan="2" width="1%">ACTIONS</th>
                    </tr>
                </thead>';
                                    
                $get2="select a.ClientID, a.BoqID, sum(a.Qty*b.Qty) as TotalReq, c.ItemCode, c.ItemDescription, c.Brand, c.Model, c.UoM, c.ItemAvailable, c.ItemID from 2boqsub a join 1tccode b on a.MatCode=b.ClientCode join 1items c on b.ItemID=c.ItemID where a.BoqID=$BoqID AND a.ClientID=$ClientID group by c.ItemID";
                $run2=mysqli_query($conn,$get2);
                $count=0;
                $available=0;
                $totalqty=0;
                $balance=0;
                $totalissued=0;
                $totalreserved=0;
                $totaldeduct=0;
                $issued=0;
                $reserved=0;
                while ($getrun2=mysqli_fetch_assoc($run2)) {
                    //selecting same ItemCode that reserved for other boq 
                    $res2=$itemres. " ,SUM(Qty) AS othertotalreserved from 1items_issuance where ItemID=$getrun2[ItemID] AND BoqID<>$BoqID AND Status='1'";
                    $runres2=mysqli_query($conn,$res2);
                    $getres2=mysqli_fetch_assoc($runres2); 
                    if (!empty($getres2['Qty'])) {
                        $qty=$getres2['Qty'];
                    }else {
                        $qty=0;
                    }

                    //selecting items reserved or issued for the same boq 
                    $res3=$itemres. " ,SUM(Qty) AS totalreserved from 1items_issuance where ItemID=$getrun2[ItemID] AND BoqID=$getrun2[BoqID] AND Status='1'";
                    $runres3=mysqli_query($conn,$res3);
                    $getres3=mysqli_fetch_assoc($runres3);
                    
                    if (empty($getres3['Qty'])) {
                        $reserved=0;
                        $hide='hidden';
                    }else{
                        $reserved=$getres3['Qty'];
                        $hide='';
                    }

                    $totalreserved=$getres3['totalreserved'];

                    $res4=$itemres. " ,SUM(Qty) AS totalissued from 1items_issuance where ItemID=$getrun2[ItemID] AND BoqID=$getrun2[BoqID] AND Status='2'";
                    $runres4=mysqli_query($conn,$res4);
                    $getres4=mysqli_fetch_assoc($runres4);
                    
                    if (empty($getres4['Qty'])) {
                        $issued=0;
                    }else{
                        $issued=$getres4['Qty'];
                    }

                    $totalissued=$getres4['totalissued'];
                    $totalqty=$getres2['othertotalreserved'];
                    $totalqty1=$getres2['othertotalreserved']+$getres3['Qty'];

                    $totalneed=$getrun2['TotalReq'];
                    $totaldeduct=$totalreserved+$totalqty;
                    $available=$getrun2['ItemAvailable'];
                    $itemsavailable=$available-$totaldeduct; //

                    
                    $balance=$totalneed-$totalissued;//for balance based on issued items
                    $balancepercentage=($balance/$totalneed)*100;// issued percentage
                    $issuedpercentage=($totalissued/$totalneed)*100;// issued percentage

                    if (is_int($issuedpercentage) || is_int($balancepercentage)) {
                        $issuedpercentage=$issuedpercentage;
                        $balancepercentage=$balancepercentage;
                    }else {
                        $issuedpercentage = preg_replace('/([\d,]+.\d{1})\d+/', '$1', $issuedpercentage);
                        $balancepercentage = preg_replace('/([\d,]+.\d{1})\d+/', '$1', $balancepercentage);
                    }

                    $boq='BOQ-00'.$getrun2['BoqID'].'';
                    echo'
                        <tbody>
                            <tr>
                                <td>'.++$count.'.</td>
                                <td>'.$boq.'</td>
                                <td>'.$getrun2['ItemCode'].'</td>
                                <td>'.ucwords($getrun2['ItemDescription']).'</td>
                                <td>'.$getrun2['Brand'].'</td>
                                <td>'.$getrun2['Model'].'</td>
                                <td class="text-center">'.$getrun2['UoM'].'</td>
                                <td class="text-center">'.$getrun2['TotalReq'].'</td>
                                <td class="text-center">'.$balance.'</td>
                                <td class="text-center">'.$balancepercentage.'%</td>
                                <td class="text-center">'.$totalissued.'</td>
                                <td class="text-center">'.$issuedpercentage.'%</td>
                                <td class="text-center">'.$getrun2['ItemAvailable'].'</td>
                                <td class="text-center">'.$itemsavailable.'</td>
                                <td class="text-center">'.$totalreserved.'</td>
                                <td class="text-center"> 
                                    <button class="btn btn-sm btn-outline-danger" data-toggle="tooltip" data-placement="top" title="View Items Reserved to other BOQ" onclick="view_totalitems_reserved('.$getrun2['ItemID'].')">'.$totalqty1.'</button>
                                </td>
                                <td class="text-center">
                                    <button id="" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Items Reservation" onclick="items_reservation('.$getrun2['BoqID'].','.$getrun2['ItemID'].', '.$getrun2['ClientID'].')"><i class="fas fa-pen"></i></button>
                                </td>
                                <td '.$hide.'>
                                    <button class="btn btn-sm btn-outline-success" data-toggle="tooltip" data-placement="top" title="Items Issuance" onclick="issuance_per_items('.$getres3['ReserveID'].', '.$getres3['ItemID'].')"><i class="fas fa-check-circle"></i></button>
                                </td>
                            </tr>
                        </tbody>';
                    }

                    $allquery=$itemres. " from 1items_issuance where BoqID=$BoqID  AND Status='1'";
                    $runallquery=mysqli_query($conn,$allquery);
                    $getallquery=mysqli_fetch_assoc($runallquery);
                    $num=mysqli_num_rows($runallquery);
                    if ($num>0) {
                        echo'
                            <tbody>
                                <tr>
                                    <td colspan="17"></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-success" data-toggle="tooltip" data-placement="top" title="All Items Issuance" onclick="issued_all_items('.$getallquery['BoqID'].', '.$getallquery['Status'].')"><i class="fas fa-save"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        ';
                    }else {
                        echo '';
                    }
                echo '
            </table>
        ';
    }

    if (isset($_POST['reserve_items_modal'])) {
        $query="select a.BoqID, b.ItemID, sum(a.Qty*c.Qty) as TotalReq, concat(b.ItemCode, '-', b.ItemDescription) as Des, concat('BOQ-',a.BoqID) AS BOQ, d.ClientName, a.ClientID from 2boqsub a join 1tccode c on a.MatCode=c.ClientCode join 1items b on b.ItemID=c.ItemID join 1clients d on a.ClientID=d.ClientID where a.BoqID='$_POST[BoqID]' and b.ItemID='$_POST[ItemID]' and a.ClientID='$_POST[ClientID]' "; 
        $run=mysqli_query($conn,$query);
        $row=mysqli_fetch_assoc($run);

        $bal="select * from 1items_issuance where BoqID='$_POST[BoqID]' and ItemID='$_POST[ItemID]' and Status='2'";
        $runbal=mysqli_query($conn,$bal);
        $getbal=mysqli_fetch_assoc($runbal);
        if (!empty($getbal['Qty'])) {
            $totalissueditems=$getbal['Qty'];
        }else {
            $totalissueditems=0;
        }
        $balanceitems=$row['TotalReq']-$totalissueditems;

        echo "<script> $('#modal').modal('show');</script>";
        echo '
            <div class="modal" id="modal" style="color:black;">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><b>Reservation of Items</b></h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label for="" class="col-form-label"><b>Client Name</b></label>
                                    <input type="text" class="form-control" value="'.$row['ClientName'].'" id="" readonly>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="" class="col-form-label"><b>BOQ No.</b></label>
                                    <input type="text" class="form-control" value="'.$row['BOQ'].'" id="" readonly>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="" class="col-form-label"><b>Item Code</b></label>
                                    <input type="text" class="form-control" value="'.$row['Des'].'" id="" readonly>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="" class="col-form-label"><b>Quantity Needed</b></label>
                                    <input type="text" class="form-control" value="'.$row['TotalReq'].'" id="" readonly>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="" class="col-form-label"><b>Balance</b></label>
                                    <input type="text" class="form-control" value="'.$balanceitems.'" id="balance" readonly>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="" class="col-form-label"><b>Items Reservation</b></label>
                                    <input type="text" class="form-control" id="Qty" onkeyup="check()">
                                </div>
                            </div>
                        <div class="modal-footer">
                            <button id="" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>

                            <button id="save_item_reservation" type="button" class="btn btn-success" onclick="save_item_reservation('.$row['BoqID'].','.$row['ItemID'].','.$row['ClientID'].')"><i class="fas fa-check-circle"></i> Reserve</button>
                        </div>
                    </div>
                </div>
            </div>
        ';
    } 

    
    if (isset($_POST['save_item_reservation'])) {
        //checking
        $query="INSERT INTO `1items_issuance` (`ItemID`, `BoqID`, `ClientID`, `Qty`, `EncodedBy`, `ReserveTS`, `IssuedTS`, `Status`) VALUES ('$_POST[ItemID]', '$_POST[BoqID]', '$_POST[ClientID]', $_POST[Qty], $EmpID, NOW(), '', '1')";
        $runquery=mysqli_query($conn,$query);
    }

    if (isset($_POST['view_totalitems_reserved_modal'])) {
        $query="select b.BoqID, b.ItemID, concat(c.ItemCode, ' - ', c.Itemdescription) AS Des, c.ItemDescription, concat('BOQ-',b.BoqID) AS BOQ, b.Qty, b.ReserveID from 1items_issuance b join 2boqsub a on a.BoqID=b.BoqID join 1items c on b.ItemID=c.ItemID where b.ItemID='$_POST[ItemID]' AND b.Status='1' ";   
        $run=mysqli_query($conn,$query);
        while ($row=mysqli_fetch_assoc($run)) {
                echo "<script> $('#modal').modal('show');</script>";
        echo '
            <div class="modal modal1" id="modal" style="color:black">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><b>Reserved Items</b></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered" style="color:black">
                                <thead>
                                    <tr>
                                        <th>ITEMCODE</th>
                                        <th colspan="2">'.$row['Des'].'</th>
                                    </tr>
                                    <tr class="text-center bg-info" >
                                        <th width="1%">#</th>
                                        <th>BOQ NO</th>
                                        <th>Quantity</th>
                                        <th width="1%"></th>
                                    </tr>
                                </thead>';
                                $query1= $query." group by a.BoqID";  
                                // echo $query; 
                                $run1=mysqli_query($conn,$query1);
                                $count=0;
                                while ($rowdata=mysqli_fetch_assoc($run1)) {
                                    echo '
                                            
                                        <tbody>
                                            <tr class="text-center">
                                                <td>'.++$count.'.</td>
                                                <td>'.$rowdata['BOQ'].'</td>
                                                <td>'.$rowdata['Qty'].'</td>
                                                <td><button class="btn btn-sm btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Cancel Reserved Items" onclick="cancel_items_reserve('.$rowdata['ReserveID'].')"><i class="fas fa-window-close"></i></i></button></td>
                                            </tr>
                                        </tbody>
                                    ';
                                }echo '
                                
                            </table>
                    </div>
                </div>
            </div>
        ';
           
        }
    }

    if (isset($_POST['cancel_reserve_items_modal'])) {
        $query="select b.BoqID, b.ItemID, concat(c.ItemCode, ' - ', c.Itemdescription) AS Des, c.ItemDescription, concat('BOQ-',b.BoqID) AS BOQ, b.Qty, b.ReserveID from 1items_issuance b join 2boqsub a on a.BoqID=b.BoqID join 1items c on b.ItemID=c.ItemID where b.ReserveID='$_POST[ReserveID]' ";   
        $run=mysqli_query($conn,$query);
        $row=mysqli_fetch_assoc($run);
        
        echo "<script> $('#modal').modal('show');</script>";
        echo '
            <div class="modal" id="modal" style="color:black">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><b>Cancellation of Reserved Items</b></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label for="" class="col-form-label"><b>BOQ No.</b></label>
                                    <input type="text" class="form-control" value="'.$row['BOQ'].'" id="" readonly>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="" class="col-form-label"><b>Item Code</b></label>
                                    <input type="text" class="form-control" value="'.$row['Des'].'" id="" readonly>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="" class="col-form-label"><b>Items Reserved</b></label>
                                    <input type="text" class="form-control" id="uQty" value="'.$row['Qty'].'">
                                </div>
                            </div>
                        <div class="modal-footer">
                            <button id="" type="button" class="btn btn-success" onclick="cancel('.$row['ReserveID'].')"><i class="fas fa-check-circle"></i> Update</button>
                        </div>
                    </div>
                </div>
            </div>
        ';
    } 

    if (isset($_POST['per_items_issuance_update'])) {
        $item="select ItemID,ItemAvailable from 1items where ItemID=$_POST[ItemID]";
        $runitem=mysqli_query($conn,$item);
        $getitem=mysqli_fetch_assoc($runitem);
        $itemqty=$getitem['ItemAvailable'];

        $itemissued="select ReserveID, Qty from 1items_issuance where ReserveID=$_POST[ReserveID]";
        $runitemissued=mysqli_query($conn,$itemissued);
        $getitemissued=mysqli_fetch_assoc($runitemissued);
        $itemissuedqty=$getitemissued['Qty'];

        $updateditemqty=$itemqty-$itemissuedqty;
        
        $update="UPDATE `1items_issuance` SET  `Status` = '2', `IssuedTS`=NOW() WHERE (ReserveID=$_POST[ReserveID])";
        $runupdate=mysqli_query($conn,$update);
        $update1="UPDATE `1items` SET  `ItemAvailable` = '$updateditemqty' WHERE `ItemID`='$_POST[ItemID]'";
        $runupdate1=mysqli_query($conn,$update1);

    }

    if (isset($_POST['items_issuance_update'])) {
        $select= $itemres. " from 1items_issuance where BoqID=$_POST[BoqID] and Status=$_POST[Status]";
        $run=mysqli_query($select);
        while ($row=mysqli_fetch_assoc($run)) {
            $update="UPDATE `1items_issuance` SET  `Status` = '2', `IssuedTS`=NOW() WHERE (BoqID=$run[BoqID] and Status=$run[Status])";
            $runupdate=mysqli_query($conn,$update);
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
    
    // function check() {

    //     if (document.getElementById("Qty")>document.getElementById("balance")) {
            
    //     }
    //     let x = document.getElementById("Qty");
    //     let balance = document.getElementById("balance");
    //     document.getElementById("save_item_reservation").style.visibility = "hidden";
    //     x.value = x.value.toUpperCase();
    //     alert(balance);
    // }
</script>