<?php
function gettotal($total, $totalcompare, $tipe)
{

    if ($totalcompare == 0) {
        $return['label'] = "all active";
        $return['color'] = "success";
        $return['percent'] = "";
    } else {
        $return['label'] = "not active";
        $return['color'] = "danger";
        $return['percent'] = $totalcompare;
    }
    //die('((' . $selisihorder . ') / ' . $total . ') * 100');
    return $return;
}

if ($_SESSION['role_id'] == '5') {
    $getdata_modulsstudent = mysqli_query($conn, "
    SELECT  a.*,c.name instructor,DATE_FORMAT(a.created_at, '%W , %d %M %Y') dates ,d.name majors
    FROM learning_moduls a 
    left join instructors b on a.instructor_id=b.id  
    left join users c on b.user_id=c.id  
    left join majors d on b.majors_id=d.id  
    where  a.is_active='1' 
    and b.majors_id in (select majors_id from students a where user_id='" . $_SESSION['userid'] . "') 
    order by a.id desc limit 10");
    $num_modulsstudent = mysqli_num_rows($getdata_modulsstudent);
    $rows_modulsstudent = mysqli_fetch_all($getdata_modulsstudent, MYSQLI_ASSOC);
} else {

    $getdata = mysqli_query($conn, " SELECT 
                                 (SELECT count(*) from majors ) as totalmajor,
                                (SELECT count(*) from majors where is_active='0'  ) as totalmajornotactive,
                                 (SELECT count(*) from user_role where  role_id='4'  ) as totalinstructor,
                                (SELECT count(*) from user_role a left join users b on a.user_id=b.id where  a.role_id='4' and b.is_active='0'  ) as totalinstructornotactive,
                                 (SELECT count(*) from user_role where  role_id='5'  ) as totalstudent,
                                (SELECT count(*) from user_role a left join users b on a.user_id=b.id where  a.role_id='5' and b.is_active='0' ) as totalstudentnotactive
                                
                        ");
    $numdata = mysqli_num_rows($getdata);
    $rows = mysqli_fetch_all($getdata, MYSQLI_ASSOC);

    $getdata_top10new = mysqli_query($conn, "SELECT  a.*,ifnull(b.total,0) totalpic,ifnull(c.total,0) totalmodul,ifnull(d.total,0) totalinstructor,ifnull(d.total,0) totalstudent
                                             FROM majors a 
                                             left join (select count(id) total,majors_id from majors_detail group by majors_id) b on a.id=b.majors_id  
                                             left join (SELECT count(a.id) total,b.majors_id FROM `learning_moduls` a left join instructors b on a.instructor_id=b.id where b.majors_id is not null group by b.majors_id) c on a.id=c.majors_id  
                                             left join (select count(id) total,majors_id from instructors group by majors_id) d on a.id=d.majors_id  
                                             left join (select count(id) total,majors_id from students group by majors_id) e on a.id=e.majors_id  
                                             
                                             where  a.is_active='1'
                                             order by a.id desc limit 10");
    $num_top10new = mysqli_num_rows($getdata_top10new);
    $rows_top10new = mysqli_fetch_all($getdata_top10new, MYSQLI_ASSOC);

    $getdata_last10rec = mysqli_query($conn, "SELECT  a.*,c.name instructor,DATE_FORMAT(a.created_at, '%W , %d %M %Y') dates 
                                             FROM learning_moduls a 
                                             left join instructors b on a.instructor_id=b.id  
                                             left join users c on b.user_id=c.id  
                                            " . get_modul_session($_SESSION['roles'])['where'] . "
                                             order by a.id desc limit 10");
    $num_last10rec = mysqli_num_rows($getdata_last10rec);
    $rows_last10rec = mysqli_fetch_all($getdata_last10rec, MYSQLI_ASSOC);

    $getdata_last10tra = mysqli_query($conn, "SELECT  a.* FROM majors a  where  a.is_active='1'  
                                             order by a.id desc limit 10");
    $num_last10tra = mysqli_num_rows($getdata_last10tra);
    $rows_last10tra = mysqli_fetch_all($getdata_last10tra, MYSQLI_ASSOC);
}
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $links_path; ?>">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->

            <?php if ($_SESSION['role_id'] == '5') { ?>
                <div class="col-lg-12">
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <i class="bi bi-info-circle me-1"></i>
                        Welcome Back ! to Management Modul Dashboard.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div><!-- End Left side columns -->

                <div class="col-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>
                                <li><a class="dropdown-item" href="#">Today</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Moduls List <span>| Active</span></h5>
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Majors</th>
                                        <th scope="col">Instructor</th>
                                        <th scope="col">Modul</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    if ($num_modulsstudent > 0) {
                                        $n = 1;
                                        foreach ($rows_modulsstudent as $row10tra) { ?>
                                            <tr>
                                                <td><?= $n++; ?></td>
                                                <td><?= $row10tra['majors']; ?></td>
                                                <td><?= $row10tra['instructor']; ?></td>
                                                <td><?= $row10tra['name']; ?></td>
                                                <td><?= $row10tra['description']; ?></td>
                                                <td>
                                                    <?php
                                                    $getcatblog = mysqli_query($conn, "SELECT * from learning_modul_details where learning_modul_id='" . $row10tra['id'] . "'");
                                                    $numcatblog = mysqli_num_rows($getcatblog);
                                                    $rowcatblog = mysqli_fetch_all($getcatblog, MYSQLI_ASSOC);
                                                    foreach ($rowcatblog as $rowscb) {
                                                    ?>
                                                        <a href="<?= $rowscb['file']; ?>" data-fancybox class="badge text-bg-warning"><?= $rowscb['file_name']; ?></a>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php }  ?>
                                    <?php } else {  ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    <?php }   ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- End Recent Sales -->
            <?php } else { ?>

                <div class="col-lg-8">
                    <div class="row">
                        <!-- Sales Card -->
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>

                                        <li><a class="dropdown-item" href="#">Today</a></li>
                                        <li><a class="dropdown-item" href="#">This Month</a></li>
                                        <li><a class="dropdown-item" href="#">This Year</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Majors <span>| All</span></h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-easel"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?= $rows[0]['totalmajor']; ?></h6>
                                            <span class="small pt-1 fw-bold"><?= gettotal($rows[0]['totalmajor'], $rows[0]['totalmajornotactive'], 'customers')['percent']; ?></span> <span class="text-<?= gettotal($rows[0]['totalmajor'], $rows[0]['totalmajornotactive'], 'customers')['color']; ?>    small pt-2 ps-1"><?= gettotal($rows[0]['totalmajor'], $rows[0]['totalmajornotactive'], 'customers')['label']; ?></span>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Sales Card -->
                        <!-- Revenue Card -->
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card revenue-card">
                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="#">Today</a></li>
                                        <li><a class="dropdown-item" href="#">This Month</a></li>
                                        <li><a class="dropdown-item" href="#">This Year</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Instructors <span>| All</span></h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-person"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?= $rows[0]['totalinstructor']; ?></h6>
                                            <span class=" small pt-1 fw-bold"><?= gettotal($rows[0]['totalinstructor'], $rows[0]['totalinstructornotactive'], 'customers')['percent']; ?></span> <span class="text-<?= gettotal($rows[0]['totalinstructor'], $rows[0]['totalinstructornotactive'], 'customers')['color']; ?>   small pt-2 ps-1"><?= gettotal($rows[0]['totalinstructor'], $rows[0]['totalinstructornotactive'], 'customers')['label']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Revenue Card -->
                        <!-- instructor Card -->
                        <div class="col-xxl-4 col-xl-12">
                            <div class="card info-card customers-card">
                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="#">Today</a></li>
                                        <li><a class="dropdown-item" href="#">This Month</a></li>
                                        <li><a class="dropdown-item" href="#">This Year</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Students <span>| All</span></h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?= $rows[0]['totalstudent']; ?></h6>
                                            <span class=" small pt-1 fw-bold"><?= gettotal($rows[0]['totalstudent'], $rows[0]['totalstudentnotactive'], 'customers')['percent']; ?></span> <span class="text-<?= gettotal($rows[0]['totalstudent'], $rows[0]['totalstudentnotactive'], 'customers')['color']; ?>   small pt-2 ps-1"><?= gettotal($rows[0]['totalstudent'], $rows[0]['totalstudentnotactive'], 'customers')['label']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End instructor Card -->
                        <!-- Recent Sales -->
                        <div class="col-12">
                            <div class="card recent-sales overflow-auto">
                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="#">Today</a></li>
                                        <li><a class="dropdown-item" href="#">This Month</a></li>
                                        <li><a class="dropdown-item" href="#">This Year</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Last 10 Modul <span>| Active</span></h5>
                                    <table class="table table-borderless datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Instructor</th>
                                                <th scope="col">Modul</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">File</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            if ($num_last10rec > 0) {
                                                $n = 1;
                                                foreach ($rows_last10rec as $row10rec) { ?>
                                                    <tr>
                                                        <td><?= $n++; ?></td>
                                                        <td><?= $row10rec['instructor']; ?></td>
                                                        <td><?= $row10rec['name']; ?></td>
                                                        <td> <?= $row10rec['description']; ?> </td>
                                                        <td>
                                                            <?php
                                                            $getcatblog = mysqli_query($conn, "SELECT * from learning_modul_details where learning_modul_id='" . $row10rec['id'] . "'");
                                                            $numcatblog = mysqli_num_rows($getcatblog);
                                                            $rowcatblog = mysqli_fetch_all($getcatblog, MYSQLI_ASSOC);
                                                            foreach ($rowcatblog as $rowscb) {
                                                            ?>
                                                                <a href="<?= $rowscb['file']; ?>" data-fancybox class="badge text-bg-warning"><?= $rowscb['file_name']; ?></a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="text-center"><?= $row10rec['dates']; ?></td>
                                                        <td>
                                                            <?php if (in_array($_SESSION['role_id'], [1, 2])) { ?>
                                                                <a href="home.php?page=learning_moduls&form=edit&tid=<?= base64_encode($row10rec['id']); ?>"><i class="bi bi-pencil"></i></a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php }  ?>
                                            <?php } else {  ?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            <?php }   ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div><!-- End Recent Sales -->
                        <div class="col-12">
                            <div class="card recent-sales overflow-auto">
                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="#">Today</a></li>
                                        <li><a class="dropdown-item" href="#">This Month</a></li>
                                        <li><a class="dropdown-item" href="#">This Year</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Last 10 Majors <span>| Active</span></h5>
                                    <table class="table table-borderless datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Majors</th>
                                                <th scope="col">Pic</th>
                                                <th scope="col">Instructor</th>
                                                <th scope="col">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            if ($num_last10tra > 0) {
                                                $n = 1;
                                                foreach ($rows_last10tra as $row10tra) { ?>
                                                    <tr>
                                                        <td><?= $n++; ?></td>
                                                        <td><?= $row10tra['name']; ?></td>
                                                        <td>
                                                            <?php
                                                            $getcatblog = mysqli_query($conn, "SELECT b.* from majors_detail a left join users b on a.user_id=b.id where a.majors_id='" . $row10tra['id'] . "'");
                                                            $numcatblog = mysqli_num_rows($getcatblog);
                                                            $rowcatblog = mysqli_fetch_all($getcatblog, MYSQLI_ASSOC);
                                                            foreach ($rowcatblog as $rowscb) {
                                                            ?>
                                                                <span class="badge text-bg-warning"><?= $rowscb['name']; ?></span>
                                                            <?php
                                                            }
                                                            ?>

                                                        </td>
                                                        <td>
                                                            <?php
                                                            $getins = mysqli_query($conn, "SELECT b.* from instructors a left join users b on a.user_id=b.id where a.majors_id='" . $row10tra['id'] . "'");
                                                            $numins = mysqli_num_rows($getins);
                                                            $rowins = mysqli_fetch_all($getins, MYSQLI_ASSOC);
                                                            foreach ($rowins as $rowsi) {
                                                            ?>
                                                                <span class="badge text-bg-secondary"><?= $rowsi['name']; ?></span>
                                                            <?php
                                                            }
                                                            ?>

                                                        </td>
                                                        <td>
                                                            <?php if (in_array($_SESSION['role_id'], [1, 2])) { ?>
                                                                <a href="home?page=majors&form=edit&tid=<?= base64_encode($row10tra['id']); ?>"><i class="bi bi-pencil"></i></a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php }  ?>
                                            <?php } else {  ?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            <?php }   ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div><!-- End Recent Sales -->

                        <!-- Top Selling -->
                    </div>
                </div><!-- End Left side columns -->
                <!-- Right side columns -->
                <div class="col-lg-4">
                    <div class="col-12">
                        <div class="card top-selling overflow-auto">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>
                            <div class="card-body pb-0">
                                <h5 class="card-title">Top 10 Summary Majors <span>| Active</span></h5>
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th scope="col">Majors</th>
                                            <th scope="col">Pic</th>
                                            <th scope="col">Instructor</th>
                                            <th scope="col">Student</th>
                                            <th scope="col">Modul</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if ($num_top10new > 0) {
                                            $n = 1;
                                            foreach ($rows_top10new as $rowtop10new) { ?>
                                                <tr>
                                                    <td>
                                                        <?php if (in_array($_SESSION['role_id'], [1, 2])) { ?>
                                                            <a href="home?page=majors&form=edit&tid=<?= base64_encode($rowtop10new['id']); ?>" class="text-primary fw-bold"><?= $rowtop10new['name']; ?></a>
                                                        <?php } else { ?>
                                                            <a href="#" class="text-primary fw-bold"><?= $rowtop10new['name']; ?></a>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="fw-bold text=center"><?= number_format($rowtop10new['totalpic']); ?> </td>
                                                    <td class="fw-bold text=center"><?= number_format($rowtop10new['totalinstructor']); ?> </td>
                                                    <td class="fw-bold text=center"><?= number_format($rowtop10new['totalstudent']); ?> </td>
                                                    <td class="fw-bold text=center"><?= number_format($rowtop10new['totalmodul']); ?> </td>
                                                </tr>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <tr>
                                                <td colspan="5"> No Data Entry</td>
                                            </tr>
                                        <?php }   ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- End Top Selling -->
                    <!-- Budget Report -->

                </div><!-- End Right side columns -->
            <?php }  ?>
        </div>
    </section>

</main><!-- End #main -->