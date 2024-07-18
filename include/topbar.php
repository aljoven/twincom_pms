<?php
    include ('db.php');
    $query="select NickName from 1employees where EmpID=$_SESSION[empid]";
    $run=mysqli_query($conn,$query);
    $row=mysqli_fetch_assoc($run);
?>
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    

    <!-- Topbar Search -->
    <!-- <div class="d-none d-sm-inline-block form-inline mr-2 navbar-search col-sm-3">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-1 small" placeholder="Search for..."
                aria-label="Search" aria-describedby="basic-addon2" id="myInput" onkeyup="myInput1()">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="d-none d-sm-inline-block form-inline mr-2 navbar-search col-sm-3">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-1 small" placeholder="Search for..."
                aria-label="Search" aria-describedby="basic-addon2" id="myInput" onkeyup="myInput2()">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="d-none d-sm-inline-block form-inline mr-2 navbar-search col-sm-3">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-1 small" placeholder="Search for..."
                aria-label="Search" aria-describedby="basic-addon2" id="myInput" onkeyup="myInput3()">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </div> -->
    

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo strtoupper($row['NickName']); ?></span>
                <img class="img-profile rounded-circle"
                    src="img/profile.jpg">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="logout.php">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>