<!-- class="active" ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link collapsed sidebarleft" id="dashboard" parentid="" href="?page=dashboard">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <!-- <li class="nav-heading">Shortcut</li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="?page=orders&form=add">
                <i class="bi bi-basket2"></i>
                <span>Form Add Orders</span>
            </a>
        </li>  -->

        <li class="nav-heading" id="headingmasters">Masters</li>
        <li class="nav-item">
            <a class="nav-link collapsed" id="masters" data-bs-target="#masters-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-folder"></i><span>Masters</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="masters-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="?page=users" id="users" parentid="masters" class="sidebarleft">
                        <i class="bi bi-play-fill"></i><span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="?page=instructors" id="instructors" parentid="masters" class="sidebarleft">
                        <i class="bi bi-play-fill"></i><span>Instructors</span>
                    </a>
                </li>
                <li>
                    <a href="?page=majors" id="majors" parentid="masters" class="sidebarleft">
                        <i class="bi bi-play-fill"></i><span>Majors</span>
                    </a>
                </li>
                <li>
                    <a href="?page=students" id="students" parentid="masters" class="sidebarleft">
                        <i class="bi bi-play-fill"></i><span>Students</span>
                    </a>
                </li>
                <li>
                    <a href="?page=roles" id="roles" parentid="masters" class="sidebarleft">
                        <i class="bi bi-play-fill"></i><span>Level</span>
                    </a>
                </li>

            </ul>
        </li><!-- End Tables Nav -->

        <li class="nav-heading" id="headingtransactions">Management Modul</li>
        <li class="nav-item">
            <a class="nav-link collapsed" id="transactions" data-bs-target="#transactions-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-folder"></i><span>Management Modul</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="transactions-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="?page=learning_moduls" id="learning_moduls" parentid="transactions" class="sidebarleft">
                        <i class="bi bi-play-fill"></i><span>Management Modul</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Tables Nav -->

        <li class="nav-heading" id="headingreports">Reports</li>
        <li class="nav-item">
            <a class="nav-link collapsed" id="reports" data-bs-target="#reports-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-folder"></i><span>Reports</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="reports-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="?page=allreports" id="allreports" parentid="reports" class="sidebarleft">
                        <i class="bi bi-play-fill"></i><span>Order Reports</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Tables Nav -->


    </ul>

</aside><!-- End Sidebar -->