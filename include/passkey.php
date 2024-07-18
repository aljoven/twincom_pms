<?php
    if (!empty($_SESSION['empid'])) {
        $EmpID=$_SESSION['empid'];
    }else {
        header('location: login.php');
    }
    
?>