<?php
  session_start();
  include ('include/db.php');
  
	if (isset($_POST['login'])) {
    
    $query = mysqli_query($conn, "SELECT * FROM 1accounts WHERE Empid = '$_POST[empid]' AND password = '$_POST[password]'"); 
    $num=mysqli_num_rows($query);
    $row=mysqli_fetch_assoc($query);

    $empid=$_POST['empid'];
    $_SESSION['empid']=$empid;
    $_SESSION['last_timestamp'] = time();

    if ($num > 0) {
      $save="insert into 1logs (`EmpID`,`TS`) values ('$empid', NOW())";
      $run=mysqli_query($conn,$save);
      $_SESSION['AcctType'] = $row['AcctType'];
      if ($row['AcctType'] == 'admin') {
        $_SESSION['AcctID'] = $row['AcctID'];
        header("Location: dashboard.php");
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="img/twincom.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets1/css/bootstrap.min.css">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="assets1/css/all.min.css">
    <link rel="stylesheet" href="assets1/css/uf-style.css">
    <title>Login</title>
  </head>
  <body>
    <div class="uf-form-signin">
      <div class="text-center">
        <a href="#"><img src="img/twincom.png" alt="" width="340" height="150"></a>
      <h1 class="text-white h3"><b>Account Login</b></h1>
      </div>
      <form class="mt-4" method="POST">
        <div class="input-group uf-input-group input-group-lg mb-3">
          <span class="input-group-text fa fa-user"></span>
          <input type="text" name="empid" class="form-control" autofocus autocomplete="off" placeholder="Employee ID No">
        </div>
        <div class="input-group uf-input-group input-group-lg mb-3">
          <span class="input-group-text fa fa-lock"></span>
          <input type="password" name="password" class="form-control" placeholder="Password">
        </div>
        <div class="d-grid mb-4"><br>
          <button type="submit" name="login" class="btn uf-btn-primary btn-lg">Login</button>
        </div>
      </form>
    </div>

    <!-- JavaScript -->

    <!-- Separate Popper and Bootstrap JS -->
    <script src="assets1/js/popper.min.js"></script>
    <script src="assets1/js/bootstrap.min.js"></script>
  </body>
</html>