 <?php
    if (isset($_POST)) {
        if (isset($_POST['reporttype']) && $_POST['reporttype'] != '') {
            $reporttype = $_POST['reporttype'];
            $datefrom = $_POST['datefrom'];
            $dateto = $_POST['dateto'];

            if ($reporttype == '1') { //Orders
                $getdata = mysqli_query($conn, "SELECT  a.*,ifnull(b.total,0) totalpic,ifnull(c.total,0) totalmodul,ifnull(d.total,0) totalinstructor,ifnull(d.total,0) totalstudent
                                             FROM majors a 
                                             left join (select count(id) total,majors_id from majors_detail group by majors_id) b on a.id=b.majors_id  
                                             left join (SELECT count(a.id) total,b.majors_id FROM `learning_moduls` a left join instructors b on a.instructor_id=b.id where b.majors_id is not null group by b.majors_id) c on a.id=c.majors_id  
                                             left join (select count(id) total,majors_id from instructors group by majors_id) d on a.id=d.majors_id  
                                             left join (select count(id) total,majors_id from students group by majors_id) e on a.id=e.majors_id  
                                             
                                             where  a.is_active='1' and date(a.created_at) >= '" . $datefrom . "' and date(a.created_at) <= '" . $dateto . "'
                                         order by a.id desc");
            }
            $numdata = mysqli_num_rows($getdata);
            $alerts = '';
        } else {
            $alerts = '
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-1"></i>
                Please Choose Report Type !
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            ';
            $reporttype = '';
            $datefrom = date('Y-m-d');
            $dateto = date('Y-m-d');
        }
    } else {
        $alerts = '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <h4 class="alert-heading"><i class="bi bi-info-circle me-1"></i> Information Report Menu</h4>
                <p>Please choose <b>Report Type</b>. and you can filter date range. Please check again your date from & date to !</p>
                <hr>
                <p class="mb-0">Thank You !</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
        ';
        $reporttype = '';
        $datefrom = date('Y-m-d');
        $dateto = date('Y-m-d');
    }
    ?>

 <main id="main" class="main">
     <div class="pagetitle">
         <h1>Order Reports</h1>
         <nav>
             <ol class="breadcrumb">
                 <li class="breadcrumb-item"><a href="home.php">Reports</a></li>
                 <li class="breadcrumb-item active">Order Reports</li>
             </ol>
         </nav>
     </div><!-- End Page Title -->

     <section class="section dashboard">
         <div class="row">
             <div class="col-lg-12">
                 <div class="card top-selling overflow-auto effectup">
                     <div class="card-body pb-0">
                         <h5 class="card-title">Filters</h5>
                         <form action="" method="post">
                             <div class="row mb-4">
                                 <div class="col-5">
                                     <label for="reporttype">Report Type</label>
                                     <select name="reporttype" class="form-control" id="reporttype">
                                         <option value="">Choose Report Type</option>
                                         <option value="1" <?php if ($reporttype == '1') echo 'selected'; ?>>Majors Summary Report</option>

                                     </select>
                                 </div>
                                 <div class="col-3">
                                     <label for="datefrom">Date From</label>
                                     <input type="date" class="form-control" value="<?= $datefrom; ?>" name="datefrom" id="datefrom">
                                 </div>
                                 <div class="col-3">
                                     <label for="datefrom">Date To</label>
                                     <input type="date" class="form-control" value="<?= $dateto; ?>" name="dateto" id="dateto">
                                 </div>
                                 <div class="col-1">
                                     <br>
                                     <button type="submit" class="btn btn-primary" id="submitreport" name="submitreport"> <i class="bi bi-search"></i> Search</button>
                                 </div>
                             </div>
                         </form>
                     </div>
                 </div>
                 <div class="col-lg-12">
                     <div class="card top-selling overflow-auto effectup">
                         <div class="card-body pb-0">
                             <h5 class="card-title">View Reports</h5>
                             <?php
                                if (isset($_POST)) {
                                    if (isset($_POST['reporttype']) && $_POST['reporttype'] != '') {
                                ?>
                                     <table class="table table-border stripe">
                                         <?php
                                            if ($_POST['reporttype'] == '1') {
                                            ?>
                                             <thead>
                                                 <tr class="text-center">
                                                     <th>No</th>
                                                     <th>Majors</th>
                                                     <th>Pic</th>
                                                     <th>Instructor</th>
                                                     <th>Student</th>
                                                     <th>Modul</th>
                                                 </tr>
                                             </thead>
                                             <tbody>
                                                 <?php if ($numdata > 0) {
                                                        $i = 1;
                                                    ?>
                                                     <?php while ($rows = mysqli_fetch_assoc($getdata)) {  ?>
                                                         <tr>
                                                         <tr>
                                                             <td><?= $i++; ?></td>
                                                             <td><a href="#" class="text-primary fw-bold"><?= $rows['name']; ?></a></td>
                                                             <td style="text-align:center;"><?= number_format($rows['totalpic']); ?> </td>
                                                             <td style="text-align:center;"><?= number_format($rows['totalinstructor']); ?> </td>
                                                             <td style="text-align:center;"><?= number_format($rows['totalstudent']); ?> </td>
                                                             <td style="text-align:center;"><?= number_format($rows['totalmodul']); ?> </td>

                                                             </td>
                                                         </tr>
                                                     <?php } ?>
                                                 <?php } ?>
                                             </tbody>
                                         <?php } ?>



                                     </table>
                             <?php }
                                } ?>
                         </div>
                     </div>
                 </div>
             </div>
     </section>

 </main><!-- End #main -->