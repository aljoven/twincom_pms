<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
                <div class="sidebar-brand-text mx-3">TWINCOM WMS</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="clients.php" data-toggle="collapse" data-target="#collapseClients"
                    aria-expanded="true" aria-controls="collapseClients">
                    <i class="fas fa-user"></i>
                    <span>Clients</span>
                </a>
                <div id="collapseClients" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="clients.php"><i class="fas fa-user"></i> Clients List</a>
                        <a class="collapse-item" href="clienttransaction_dashboard.php"><i class="fas fa-handshake"></i> Transaction Reports</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="supplier.php">
                    <i class="fas fa-portrait"></i>
                    <span>Supplier List</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="itemcategory.php">
                    <i class="fas fa-folder"></i> 
                     Category List
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="itemslocation.php">
                    <i class="fas fa-search-location"></i> 
                    Location List
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="items.php">
                    <i class="fas fa-wrench"></i> 
                    Items List
                </a>
            
            <li class="nav-item">
                <a class="nav-link" href="clienttransaction_dashboard.php">
                    <i class="fas fa-folder-plus"></i>
                    <span>Reserve/Issuance Items</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="items_matcode.php">
                    <i class="fas fa-folder-plus"></i>
                    <span>Items per MatCode</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="transaction_history.php">
                    <i class="fas fa-history"></i>
                    <span>Transaction History</span>
                </a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>