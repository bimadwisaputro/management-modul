<?php
$where = '';
$where_drop = '';
foreach ($_SESSION['roles'] as $rsess) {
    if ($rsess['role_id'] == '3') {
        $where = " where a.majors_id in (select majors_id from majors_detail where user_id='" . $_SESSION['userid'] . "') ";
        $where_drop = " where  id in (select majors_id from majors_detail where user_id='" . $_SESSION['userid'] . "') ";
    }
}
$getdata = mysqli_query($conn, "SELECT a.* ,c.name,b.name majors
                                        ,case a.is_active when '1' then 'Active' else 'Not Active' end as is_activelabel 
                                        ,case a.is_active when '1' then 'success' else 'danger' end as is_activecolor
                                        ,case a.gender when '1' then 'Male' else 'Female' end as genders
                                         from instructors a   
                                         left join majors b on a.majors_id=b.id
                                         left join users c on a.user_id=c.id
                                         " . $where . "
                                         order by a.id desc"); //and a.id not in (1) administrator
$numdata = mysqli_num_rows($getdata);

?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Instructors</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Masters</a></li>
                <li class="breadcrumb-item active">Instructors</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <?php if (!isset($_GET['form'])) { ?>
            <div class="row">
                <div class="col-12">
                    <div class="card  overflow-auto effectup">
                        <div class="card-body pb-0">
                            <div align="right">
                                <a class="btn btn-success mt-3 mb-3 float-right pull-right" href="<?= $links_path; ?>&form=add">Create</a>
                            </div>
                            <table class="table table-striped table-bordered datatable mt-3">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Majors</th>
                                        <th>
                                            <b>N</b>ame
                                        </th>
                                        <th>Title</th>
                                        <th>Gender</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Photo</th>
                                        <th>is_active</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($numdata > 0) {
                                        $i = 1;
                                    ?>
                                        <?php while ($rows = mysqli_fetch_assoc($getdata)) { ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $rows['majors']; ?></td>
                                                <td><?= $rows['name']; ?></td>
                                                <td><?= $rows['title']; ?></td>
                                                <td><?= $rows['genders']; ?></td>
                                                <td><?= $rows['address']; ?></td>
                                                <td><?= $rows['phone']; ?></td>
                                                <td class="text-center">
                                                    <?php if ($rows['photo'] != '' || $rows['photo'] != null) { ?>
                                                        <div class="circular">
                                                            <a href="<?= $rows['photo']; ?>" data-fancybox>
                                                                <img src="<?= $rows['photo']; ?>" alt="logo">
                                                            </a>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-<?= $rows['is_activecolor']; ?>"><?= $rows['is_activelabel']; ?></span>
                                                </td>
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
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else {

            $getmajors = mysqli_query($conn, "SELECT * from majors " . $where_drop . "");
            $cekmajors = mysqli_num_rows($getmajors);
            $rowmajors = mysqli_fetch_all($getmajors, MYSQLI_ASSOC);

            $getusers = mysqli_query($conn, "SELECT b.* from user_role a left join users b on a.user_id=b.id where a.role_id='4' ");
            $cekusers = mysqli_num_rows($getusers);
            $rowusers = mysqli_fetch_all($getusers, MYSQLI_ASSOC);


            if (isset($_GET['tid'])) {
                $label = 'Edit';
                $labelbutton = 'Update';
                $tid = base64_decode($_GET['tid']);
                $getdata = mysqli_query($conn, "SELECT a.* from instructors a where a.id = '$tid'");
                $rows = mysqli_fetch_assoc($getdata);
                $user_id = $rows['user_id'];
                $majors_id = $rows['majors_id'];
                $name = $rows['name'];
                $is_active = $rows['is_active'];
                $title = $rows['title'];
                $address = $rows['address'];
                $gender = $rows['gender'];
                $phone = $rows['phone'];
                if ($rows['photo'] == '' || $rows['photo'] == null) {
                    $photo = '';
                } else {
                    $photo =  '<div class="col-md-12 mt-4"> 
                                    <div class="alert alert-light border-primary alert-dismissible fade show" role="alert"> 
                                       <a href="' . $rows['photo'] . '" data-fancybox >
                                            <img src="' . $rows['photo'] . '" alt="foto" style="max-width:150px;max-height:150px;"  class="img-thumbnail">
                                        </a>
                                        <div class="col-12 mt-4"> 
                                            <span class="btn btn-danger" id="deletefoto" tfd="photo" tid="' . $tid . '" tipe="testimonies"  ><i class="bi bi-trash"></i> Hapus Foto </span>
                                        </div>
                                    </div>
                                  </div>    
                                ';
                }
            } else {
                $label = 'Add';
                $labelbutton = 'Save';
                $tid = 0;
                $user_id = '';
                $majors_id = '';
                $name = '';
                $is_active = 0;
                $checkdetail = 0;
                $address = '';
                $title = '';
                $gender = '';
                $phone = '';
                $photo = '';
            }
        ?>

            <div class="card">
                <div class="card-body">
                    <!-- Default Tabs -->
                    <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">Profile</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="transaction-tab" data-bs-toggle="tab" data-bs-target="#transaction" type="button" role="tab" aria-controls="transaction" aria-selected="false" tabindex="-1">Management Modul</button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content pt-2" id="myTabContent">
                <div class="tab-pane fade active show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="row">
                        <div class="col-12">
                            <div class="card  overflow-auto effectup">
                                <div class="card-body pb-0">
                                    <input type="hidden" id="tid" name="tid" class="instructorsform" value="<?= $tid; ?>">
                                    <h5 class="card-title"><?= $label; ?> Form</h5>
                                    <div class="row g-3">
                                        <div class="col-md-12 mb-2">
                                            <select class="select2tags form-control instructorsform" name="majors_id" id="majors_id" required>
                                                <option value="">Choose Majors</option>
                                                <?php if ($cekmajors > 0) { ?>
                                                    <?php foreach ($rowmajors as  $rowcma) { ?>
                                                        <option value="<?= $rowcma['id']; ?>" <?php if ($rowcma['id'] == $majors_id) echo 'selected'; ?>><?= $rowcma['name']; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <select class="select2tags form-control instructorsform" name="user_id" id="user_id" required>
                                                <option value="">Choose Users</option>
                                                <?php if ($cekusers > 0) { ?>
                                                    <?php foreach ($rowusers as  $rowcus) { ?>
                                                        <option value="<?= $rowcus['id']; ?>" <?php if ($rowcus['id'] == $user_id) echo 'selected'; ?>><?= $rowcus['name']; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <div class="form-floating">
                                                <input type="text" class="form-control instructorsform" name="title" id="title" value="<?= $title; ?>" placeholder="Title" required>
                                                <label for="title">Title</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <select class="form-control instructorsform" name="gender" id="gender" required>
                                                <option value="">Choose Gender</option>
                                                <option value="1" <?php if ($gender == '1') echo 'selected'; ?>>Male</option>
                                                <option value="2" <?php if ($gender == '2') echo 'selected'; ?>>Female</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <div class="form-floating">
                                                <input type="text" class="form-control instructorsform" name="phone" id="phone" value="<?= $phone; ?>" placeholder="Phone" required>
                                                <label for="phone">Phone</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <textarea class="form-control instructorsform" placeholder="Address" name="address" id="address" style="height: 100px;"><?= $address; ?></textarea>
                                                <label for="address">Address</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <label for="photo">Photo</label>
                                                <input type="file" class="form-control mt-1" name="photo" id="photo" placeholder="Photo">
                                            </div>
                                            <?= $photo; ?>
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
                            <div class="card  overflow-auto effectup">
                                <div class="card-body pb-0">
                                    <div class="text-center mb-3 mt-4">
                                        <a href="<?= $links_path; ?>" class="btn btn-danger">Cancel</a>
                                        <span name="simpan" id="simpan_" tipe="<?= $_GET['page']; ?>" class="btn btn-primary" mode="<?= $label; ?>"><?= $labelbutton; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="transaction" role="tabpanel" aria-labelledby="transaction-tab">
                    <div class="col-12">
                        <div class="card overflow-auto effectup">
                            <div class="card-body pb-0 mb-5">
                                <br>
                                <table class="table table-striped table-bordered datatable mt-5">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Modul Name</th>
                                            <th>Description</th>
                                            <th>File</th>
                                            <th>is_active</th>
                                            <th>Date</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        /*
                                        if (isset($_GET['tid']) && $numdatatransaction > 0) {
                                            $i = 1;
                                        ?>
                                            <?php while ($rows = mysqli_fetch_assoc($getdatatransaction)) {
                                                $fee = $rows['amount'] - $rows['price'];
                                            ?>
                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $rows['code']; ?></td>
                                                    <td><?= $rows['seller']; ?></td>
                                                    <td><?= $rows['buyer']; ?></td>
                                                    <td><?= number_format($rows['price']); ?></td>
                                                    <td><?= number_format($fee); ?></td>
                                                    <td><?= number_format($rows['amount']); ?></td>
                                                    <td><?= $rows['roles']; ?> ( <?= $rows['roles_code']; ?> ) <?= $rows['accname']; ?> - <?= $rows['accnumber']; ?></td>

                                                    <td><?= $rows['description']; ?></td>
                                                    <td class="text-center">
                                                        <?php if ($rows['photo'] != '' || $rows['photo'] != null) { ?>
                                                            <div class="circular">
                                                                <a href="<?= $rows['photo']; ?>" data-fancybox>
                                                                    <img src="<?= $rows['photo']; ?>" alt="logo">
                                                                </a>
                                                            </div>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-<?= $rows['is_activecolor']; ?>"><?= $rows['is_activelabel']; ?></span>
                                                    </td>
                                                    <td><?= $rows['dates']; ?></td>
                                                    <td class="text-center" style="width:20%;">
                                                        <a href="<?= $links_path; ?>&form=edit&tid=<?= base64_encode($rows['id']); ?>" class="btn btn-primary"><i class="bi bi-pencil"></i></a>
                                                        <a href="#" id="delete_<?= $rows['id']; ?>" tid="<?= $rows['id']; ?>" tipe="tx_orders" class="btn btn-danger"><i class="bi bi-trash"></i></a>
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
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        <?php } */ ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Default Tabs -->

        <?php } ?>


    </section>

</main><!-- End #main -->