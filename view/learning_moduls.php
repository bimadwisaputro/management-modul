 <?php
    $where = '';
    $where_drop = '';

    if (in_array($_SESSION['role_id'], [3])) {
        $where = " where b.majors_id in (select majors_id from majors_detail a where user_id='" . $_SESSION['userid'] . "') ";
        $where_drop = " and  a.majors_id in (select majors_id from majors_detail where user_id='" . $_SESSION['userid'] . "') ";
    }
    if (in_array($_SESSION['role_id'], [4])) {
        $where = " where a.instructor_id='" . $_SESSION['instructor_id'] . "'  ";
        $where_drop = " and a.id='" . $_SESSION['instructor_id'] . "' ";
    }

    $getdata = mysqli_query($conn, "SELECT a.*,c.name as instructor 
                                          ,case a.is_active when '1' then 'Active' else 'Not Active' end as is_activelabel 
                                        ,case a.is_active when '1' then 'success' else 'danger' end as is_activecolor
                                        ,DATE_FORMAT(a.created_at, '%W , %d %M %Y') dates 
                                         from learning_moduls a 
                                         left join instructors b on a.instructor_id=b.id 
                                         left join users c on b.user_id=c.id   
                                         " . $where . "
                                         order by a.id desc");
    $numdata = mysqli_num_rows($getdata);

    ?>
 <main id="main" class="main">
     <div class="pagetitle">
         <h1>Managements Modul</h1>
         <nav>
             <ol class="breadcrumb">
                 <li class="breadcrumb-item"><a href="#">Managements Modul</a></li>
                 <li class="breadcrumb-item active">learning_moduls</li>
             </ol>
         </nav>
     </div><!-- End Page Title -->

     <section class="section dashboard">
         <div class="row">
             <?php if (!isset($_GET['form'])) { ?>
                 <div class="col-12">
                     <div class="card top-selling overflow-auto effectup">
                         <div class="card-body pb-0">
                             <div align="right">
                                 <a class="btn btn-success mt-3 mb-3 float-right pull-right" href="<?= $links_path; ?>&form=add">Create</a>
                             </div>
                             <table class="table table-striped table-bordered datatable mt-3">
                                 <thead>
                                     <tr>
                                         <th>No</th>
                                         <th>Instructor</th>
                                         <th>Modul Name</th>
                                         <th>Description</th>
                                         <th>Modul Files</th>
                                         <th>is_active</th>
                                         <th>Date</th>
                                         <th>#</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php if ($numdata > 0) {
                                            $i = 1;
                                        ?>
                                         <?php while ($rows = mysqli_fetch_assoc($getdata)) {
                                                // $fee = $rows['amount'] - $rows['price'];
                                            ?>
                                             <tr>
                                                 <td><?= $i++; ?></td>
                                                 <td><?= $rows['instructor']; ?></td>
                                                 <td><?= $rows['name']; ?></td>
                                                 <td><?= $rows['description']; ?></td>
                                                 <td>
                                                     <?php
                                                        $getcatblog = mysqli_query($conn, "SELECT * from learning_modul_details where learning_modul_id='" . $rows['id'] . "'");
                                                        $numcatblog = mysqli_num_rows($getcatblog);
                                                        $rowcatblog = mysqli_fetch_all($getcatblog, MYSQLI_ASSOC);
                                                        if ($numcatblog > 0) {
                                                            foreach ($rowcatblog as $rowscb) {
                                                        ?>
                                                             <a href="<?= $rowscb['file']; ?>" data-fancybox class="badge text-bg-warning"><?= $rowscb['file_name']; ?></a>
                                                     <?php
                                                            }
                                                        }
                                                        ?>

                                                 </td>
                                                 <td class="text-center">
                                                     <span class="badge bg-<?= $rows['is_activecolor']; ?>"><?= $rows['is_activelabel']; ?></span>
                                                 </td>
                                                 <td><?= $rows['dates']; ?></td>
                                                 <td class="text-center" style="width:20%;">
                                                     <a href="<?= $links_path; ?>&form=edit&tid=<?= base64_encode($rows['id']); ?>" class="btn btn-primary"><i class="bi bi-pencil"></i></a>
                                                     <a href="#" id="delete_<?= $rows['id']; ?>" tid="<?= $rows['id']; ?>" tipe="<?= $_GET['page']; ?>" class="btn btn-danger"><i class="bi bi-trash"></i></a>

                                                 </td>
                                             </tr>
                                         <?php } ?>
                                     <?php } else { ?>
                                         <tr>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                         </tr>
                                     <?php } ?>

                                 </tbody>
                             </table>
                         </div>
                     </div>
                 </div><!-- End Top Selling -->
             <?php } else {

                    $getinstructor = mysqli_query($conn, "SELECT a.*,b.name username,c.name majorsname from instructors a left join users b on a.user_id=b.id left join majors c on a.majors_id=c.id 
                                                            where a.is_active='1' " . $where_drop . "");
                    $cekinstructor = mysqli_num_rows($getinstructor);
                    $rowinstructor = mysqli_fetch_all($getinstructor, MYSQLI_ASSOC);
                    if (isset($_GET['tid'])) {
                        $label = 'Edit';
                        $labelbutton = 'Update';
                        $tid = base64_decode($_GET['tid']);
                        $getdata = mysqli_query($conn, "
                                       SELECT a.*,c.name as instructor 
                                        ,case a.is_active when 'Finish' then 'success' when 'Reject' then 'danger' else 'success' end as is_activecolor 
                                        ,DATE_FORMAT(a.created_at, '%W , %d %M %Y') dates 
                                         from learning_moduls a 
                                         left join instructors b on a.instructor_id=b.id 
                                         left join users c on b.user_id=c.id  
                                         where a.id = '$tid'");
                        $rows = mysqli_fetch_assoc($getdata);

                        $getdata_detail = mysqli_query($conn, "SELECT * from learning_modul_details where learning_modul_id = '$tid'  ");
                        $checkdetail = mysqli_num_rows($getdata_detail);
                        $rowsdetail = mysqli_fetch_all($getdata_detail, MYSQLI_ASSOC);

                        $name = $rows['name'];
                        $instructor_id = $rows['instructor_id'];
                        $description = $rows['description'];
                        $is_active = $rows['is_active'];
                    } else {
                        $code = strtolower(substr(md5(uniqid(mt_rand(), true)), 0, 8));
                        $label = 'Add';
                        $labelbutton = 'Save';
                        $tid = 0;
                        $instructor_id = 0;
                        $name = '';
                        $description = '';
                        $is_active = 0;
                        $checkdetail = 0;
                    }
                ?>
                 <style>
                     .row {
                         display: flex;
                         flex-wrap: wrap;
                     }

                     .col-6 .card {
                         display: flex;
                         flex-direction: column;
                         justify-content: stretch;
                         height: 96.3%;
                     }
                 </style>
                 <div class="col-12">
                     <div class="card top-selling overflow-auto effectup">
                         <div class="card-body pb-0">
                             <input type="hidden" id="tid" name="tid" class="learning_modulsform" value="<?= $tid; ?>">
                             <h5 class="card-title"><?= $label; ?> learning_moduls Form</h5>
                             <div class="row g-3">
                                 <?php if (in_array($_SESSION['role_id'], [4])) { ?>
                                     <input type="hidden" name="instructor_id" id="instructor_id" value="<?= $_SESSION['userid']; ?>">
                                 <?php } else { ?>
                                     <div class="col-md-12 mb-2">
                                         <label for="instructor_id">Instructor</label>
                                         <select class="select2tags form-control learning_modulsform" name="instructor_id" id="instructor_id" required>
                                             <option value="">Choose Instructor</option>
                                             <?php if ($cekinstructor > 0) { ?>
                                                 <?php foreach ($rowinstructor as  $rowcus) { ?>
                                                     <option value="<?= $rowcus['id']; ?>" <?php if ($rowcus['id'] == $instructor_id) echo 'selected'; ?>><?= $rowcus['username']; ?> - <?= $rowcus['majorsname']; ?></option>
                                                 <?php } ?>
                                             <?php } ?>
                                         </select>
                                     </div>
                                 <?php } ?>
                                 <div class="col-md-12 mb-3">
                                     <div class="form-floating">
                                         <input type="text" class="form-control learning_modulsform" name="name" id="name" value="<?= $name; ?>" placeholder="Modul Name" required>
                                         <label for="name">Modul Name</label>
                                     </div>
                                 </div>
                                 <div class="col-12 mb-3">
                                     <div class="form-floating">
                                         <textarea class="form-control learning_modulsform" placeholder="Description" name="description" id="description" style="height: 100px;"><?= $description; ?></textarea>
                                         <label for="description">Description</label>
                                     </div>
                                 </div>
                                 <div class="col-md-12">
                                     <div class="form-floating mb-5">
                                         <select class="form-select instructorsform" id="is_active" aria-label="is_active">
                                             <option value="1" <?php if ($is_active == 1) echo 'selected'; ?>>Active</option>
                                             <option value="0" <?php if ($is_active == 0) echo 'selected'; ?>>Non Active</option>
                                         </select>
                                         <label for="is_active">is_active</label>
                                     </div>
                                 </div>

                             </div>
                         </div>
                     </div>
                 </div>

                 <div class="col-12">
                     <div class="card top-selling overflow-auto effectup">
                         <div class="card-body pb-0">
                             <div class="row">
                                 <div class="col-6">
                                     <h5 class="card-title">Files Details </h5>
                                 </div>
                                 <div class="col-6 mt-3" align="right">
                                     <button class="btn btn-success">
                                         <a class="icon text-white" href="#" id="add_item"><i class="fe fe-plus"></i> Add File</a>
                                     </button>
                                 </div>
                             </div>

                             <div class="col-md-12 mb-5">
                                 <table class="table mb-0" id="item_list">
                                     <thead>
                                         <tr>
                                             <th style="width:70%;">Reference Link</th>
                                             <th style="width:25%;">File</th>
                                             <th>#</th>
                                         </tr>
                                     </thead>
                                     <?php
                                        $item_counter = 0;
                                        $grand_total = 0;
                                        ?>
                                     <tbody id="t">
                                         <?php if ($checkdetail > 0) {
                                            ?>
                                             <?php foreach ($rowsdetail as $in => $rowd) {
                                                    $photodetail[$in] = '<div class="row">';
                                                    if ($rowd['file'] != '' || $rowd['file'] == null) {
                                                        $photodetail[$in] .=  ' 
                                                                      <div class="col-md-12 mb-3 ">  
                                                                        <a href="' . $rowd['file'] . '"  data-fancybox>
                                                                        <img src="assets/img/pdf.png" alt="logo">
                                                                        <br>
                                                                        ' . $rowd['file_name'] . '
                                                                        </a>   
                                                                      </div>';
                                                    }

                                                    $photodetail[$in] .= '</div>';

                                                ?>
                                                 <tr id="sub_row<?php echo $item_counter; ?>">
                                                     <td>
                                                         <input type="hidden" value="<?= $rowd['file']; ?>" class="learning_modulsformdetail<?php echo $item_counter; ?>" id="file<?php echo $item_counter; ?>" counter="<?php echo $item_counter; ?>" name="file[]">
                                                         <input type="hidden" value="<?= $rowd['file_name']; ?>" class="learning_modulsformdetail<?php echo $item_counter; ?>" id="file_name<?php echo $item_counter; ?>" counter="<?php echo $item_counter; ?>" name="file_name[]">
                                                         <div class="input-group">
                                                             <textarea class="reference_link form-control text-right learning_modulsformdetail<?php echo $item_counter; ?>" id="reference_link<?php echo $item_counter; ?>" counter="<?php echo $item_counter; ?>" name="reference_link[]"><?= $rowd['reference_link']; ?></textarea>
                                                         </div>
                                                     </td>
                                                     <td>
                                                         <?= $photodetail[$in]; ?>
                                                         <input type="file" id="photo<?php echo $item_counter; ?>" class="form-control learning_modulsformdetail<?php echo $item_counter; ?>" name="photo[]" counter="<?php echo $item_counter; ?>" multiple>
                                                     </td>
                                                     <td class="pr-0" class="align-middle">
                                                         <span class="icon fe-md text-primary pointer" onclick="removesdetail(<?php echo $item_counter; ?>)">
                                                             <i class="bi bi-x-square "></i>
                                                         </span>
                                                     </td>
                                                 </tr>
                                             <?php $item_counter++;
                                                } ?>
                                         <?php } else { ?>
                                             <tr id="sub_row<?php echo $item_counter; ?>">
                                                 <td>
                                                     <input type="hidden" value="" class=" learning_modulsformdetail<?php echo $item_counter; ?>" id="file<?php echo $item_counter; ?>" counter="<?php echo $item_counter; ?>" name="file[]">
                                                     <input type="hidden" value="" class="learning_modulsformdetail<?php echo $item_counter; ?>" id="file_name<?php echo $item_counter; ?>" counter="<?php echo $item_counter; ?>" name="file_name[]">
                                                     <div class="input-group">
                                                         <textarea class="reference_link form-control text-right learning_modulsformdetail<?php echo $item_counter; ?>" id="reference_link<?php echo $item_counter; ?>" counter="<?php echo $item_counter; ?>" name="reference_link[]"></textarea>
                                                     </div>
                                                 </td>
                                                 <td><input type="file" id="photo<?php echo $item_counter; ?>" class="form-control learning_modulsformdetail<?php echo $item_counter; ?>" name="photo[]" counter="<?php echo $item_counter; ?>" multiple></td>
                                                 <td class="pr-0" class="align-middle">
                                                     <span class="icon fe-md text-primary pointer" onclick="removesdetail(<?php echo $item_counter; ?>)">
                                                         <i class="bi bi-x-square "></i>
                                                     </span>
                                                 </td>
                                             </tr>
                                         <?php $item_counter++;
                                            } ?>

                                     </tbody>
                                 </table>
                             </div>

                         </div>
                     </div>
                 </div><!-- End Top Selling -->
                 <div class="col-12">
                     <div class="card top-selling overflow-auto effectup">
                         <div class="card-body pb-0">
                             <div class="row">
                                 <div class="col-12">
                                     <div class="text-center mb-3 mt-4">
                                         <a href="<?= $links_path; ?>" class="btn btn-danger">Back</a>
                                         <span name="simpan" id="simpanmodul_" tipe="<?= $_GET['page']; ?>" class="btn btn-primary" mode="<?= $label; ?>"><?= $labelbutton; ?></span>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             <?php } ?>
             <!-- End floating Labels Form -->
         </div>
         </div>
         </div><!-- End Top Selling -->


         </div>
     </section>

 </main><!-- End #main -->

 <div class="modal fade" id="modalDialogPickups" tabindex="-1">
     <div class="modal-dialog modal-lg modal-dialog-scrollable">
         <div class="modal-content">
             <div class="modal-header">
                 <h3 class="modal-title page-title"><span id="titlecardpickups"></span></h3>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <div id="showdatapickups"></div>
                 <input type="hidden" id="tid" name="tid" class="pickupsform" value="0">
                 <input type="hidden" id="is_active" name="is_active" class="pickupsform" value="1">
                 <input type="hidden" id="learning_moduls_id" name="learning_moduls_id" class="pickupsform" value="0">
                 <input type="hidden" id="customers_id" name="customers_id" class="pickupsform" value="0">
                 <div class="row g-3 mt-4">
                     <div class="col-md-12 mb-2">
                         <h5 class="card-title">Pickup Details</h5>
                     </div>
                     <div class="col-md-12 mb-2">
                         <div class="form-floating">
                             <input type="date" class="form-control pickupsform" name="date" id="date" value="<?= date('Y-m-d'); ?>" placeholder="Date Pickup" required>
                             <label for="name">Date Pickup</label>
                         </div>
                     </div>
                     <div class="col-md-12 mb-2">
                         <div class="form-floating">
                             <textarea type="text" class="form-control pickupsform" name="notes" style="height:100px;" id="notes" placeholder="Notes"></textarea>
                             <label for="notes">Notes</label>
                         </div>
                     </div>
                     <div class="text-center mb-3 mt-4">
                     </div>
                 </div>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" id="closemodalpickups" data-bs-dismiss="modal">Close</button>
                 <span name="simpan" id="simpan_" tipe="pickups-modal" class="btn btn-primary" mode="Add">Save Pickup</span>
             </div>
         </div>
     </div>
 </div><!-- End Modal Dialog Scrollable-->



 <div class="modal fade" id="modalDialogScrollable" tabindex="-1">
     <div class="modal-dialog modal-dialog-scrollable">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title card-title">Add Customers Form</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <input type="hidden" id="tid" name="tid" class="customersform" value="0">
                 <div class="row g-3">
                     <div class="col-md-12 mb-2">
                         <div class="form-floating">
                             <input type="text" class="form-control customersform" name="name" id="name" placeholder="Name" required>
                             <label for="name">Name</label>
                         </div>
                     </div>
                     <div class="col-md-12 mb-2">
                         <div class="form-floating">
                             <input type="text" class="form-control customersform" name="phone" id="phone" placeholder="Phone" required>
                             <label for="name">Phone</label>
                         </div>
                     </div>
                     <div class="col-md-12 mb-2">
                         <div class="form-floating">
                             <textarea type="text" class="form-control customersform" name="address" id="address" placeholder="Address"></textarea>
                             <label for="address">Address</label>
                             se</button>
                             <span name="simpan" id="simpan_" tipe="customers-modal" class="btn btn-primary" mode="Add">Save Customers</span>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>