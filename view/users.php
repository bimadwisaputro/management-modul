<?php
$getdata = mysqli_query($conn, "SELECT a.* 
                                        ,case a.is_active when '1' then 'Active' else 'Not Active' end as is_activelabel 
                                        ,case a.is_active when '1' then 'success' else 'danger' end as is_activecolor
                                         from users a   
                                         order by a.id desc"); //and a.id not in (1) administrator
$numdata = mysqli_num_rows($getdata);

?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Users</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Masters</a></li>
                <li class="breadcrumb-item active">Users</li>
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
                                        <th>
                                            <b>N</b>ame
                                        </th>
                                        <th>Email</th>
                                        <th>Role</th>
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
                                                <td><?= $rows['name']; ?></td>
                                                <td><?= $rows['email']; ?></td>
                                                <td>
                                                    <?php
                                                    $getcatblog = mysqli_query($conn, "SELECT b.* from user_role a left join roles b on a.role_id=b.id where a.user_id='" . $rows['id'] . "'");
                                                    $numcatblog = mysqli_num_rows($getcatblog);
                                                    $rowcatblog = mysqli_fetch_all($getcatblog, MYSQLI_ASSOC);
                                                    foreach ($rowcatblog as $rowscb) {
                                                    ?>
                                                        <span class="badge text-bg-warning"><?= $rowscb['name']; ?></span>
                                                    <?php
                                                    }
                                                    ?>

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
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else {
            $getrole = mysqli_query($conn, "SELECT * from roles");
            $numrole = mysqli_num_rows($getrole);
            $rowrole = mysqli_fetch_all($getrole, MYSQLI_ASSOC);

            if (isset($_GET['tid'])) {
                $label = 'Edit';
                $labelbutton = 'Update';
                $tid = base64_decode($_GET['tid']);
                $getdata = mysqli_query($conn, "SELECT a.* from users a where a.id = '$tid'");
                $rows = mysqli_fetch_assoc($getdata);
                $name = $rows['name'];
                $email = $rows['email'];
                $password = $rows['password'];
                $is_active = $rows['is_active'];
                $getdata_detail = mysqli_query($conn, "SELECT * from user_role where user_id = '$tid'");
                $checkdetail = mysqli_num_rows($getdata_detail);
                $rowsdetail = mysqli_fetch_all($getdata_detail, MYSQLI_ASSOC);
            } else {
                $label = 'Add';
                $labelbutton = 'Save';
                $tid = 0;
                $name = '';
                $email = '';
                $password = '';
                $is_active = 0;
                $checkdetail = 0;
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
                        <div class="col-9">
                            <div class="card  overflow-auto effectup">
                                <div class="card-body pb-0">
                                    <input type="hidden" id="tid" name="tid" class="usersform" value="<?= $tid; ?>">
                                    <h5 class="card-title"><?= $label; ?> Form</h5>
                                    <div class="row g-3">
                                        <div class="col-md-12 mb-2">
                                            <div class="form-floating">
                                                <input type="text" class="form-control usersform" name="name" id="name" value="<?= $name; ?>" placeholder="Name" required>
                                                <label for="name">Name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <div class="form-floating">
                                                <input type="text" class="form-control usersform" name="email" id="email" value="<?= $email; ?>" placeholder="Email" required>
                                                <label for="email">Email</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <div class="form-floating">
                                                <input type="password" class="form-control usersform" name="password" id="password" value="<?= $password; ?>" placeholder="Password" required>
                                                <label for="password">Password</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-floating mb-5">
                                                <select class="form-select usersform" id="is_active" aria-label="is_active">
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
                        <div class="col-3">
                            <div class="card overflow-auto effectup">
                                <div class="card-body pb-0">
                                    <div class="row">
                                        <div class="col-6">
                                            <h5 class="card-title">Roles</h5>
                                        </div>
                                        <div class="col-6" align="right">
                                            <button class="btn btn-primary mt-3">
                                                <a class="icon text-white" href="#" id="add_item"><i class="fe fe-plus"></i> Add Role</a>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <table class="table mb-5  " id="item_list">
                                            <thead>
                                                <tr>
                                                    <th>Roles</th>
                                                    <th>#</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $item_counter = 0;
                                            $grand_total = 0;
                                            ?>
                                            <tbody id="t">
                                                <?php if ($checkdetail > 0) { ?>
                                                    <?php foreach ($rowsdetail as $rowd) { ?>
                                                        <tr id="sub_row<?php echo $item_counter; ?>">
                                                            <td class="pl-0">
                                                                <select class="select2tags custom-select role_id form-control userroleform<?php echo $item_counter; ?>" id="role_id<?php echo $item_counter; ?>" name="role_id[]" counter="<?php echo $item_counter; ?>">
                                                                    <option value="">Choose Roles</option>
                                                                    <?php if ($numrole > 0) { ?>
                                                                        <?php foreach ($rowrole as  $rowser) { ?>
                                                                            <option value="<?= $rowser['id']; ?>" <?php if ($rowser['id'] == $rowd['role_id']) echo 'selected'; ?>><?= $rowser['name']; ?></option>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                            <td class="pr-0" class="align-middle">
                                                                <a href="#" class="icon fe-md" onclick="removesdetail(<?php echo $item_counter; ?>)">
                                                                    <i class="bi bi-x-square "></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php $item_counter++;
                                                    } ?>
                                                <?php } else { ?>
                                                    <tr id="sub_row<?php echo $item_counter; ?>">
                                                        <td class="pl-0">
                                                            <select class="select2tags custom-select role_id form-control userroleform<?php echo $item_counter; ?>" id="role_id<?php echo $item_counter; ?>" name="role_id[]" counter="<?php echo $item_counter; ?>">
                                                                <option value="">Choose Role</option>
                                                                <?php if ($numrole > 0) { ?>
                                                                    <?php foreach ($rowrole as  $rowser) { ?>
                                                                        <option value="<?= $rowser['id']; ?>"><?= $rowser['name']; ?></option>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                        <td class="pr-0" class="align-middle">
                                                            <a href="#" class="icon fe-md" onclick="removesdetail(<?php echo $item_counter; ?>)">
                                                                <i class="bi bi-x-square "></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php $item_counter++;
                                                } ?>

                                            </tbody>
                                        </table>
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