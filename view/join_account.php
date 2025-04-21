<?php
$getdata = mysqli_query($conn, "SELECT a.*,b.name bank 
                                        ,case a.status when '1' then 'Active' else 'Not Active' end as statuslabel 
                                        ,case a.status when '1' then 'success' else 'danger' end as statuscolor
                                         from join_account a 
                                         left join banks b on a.bank_id=b.id  
                                         where a.deleted_at is null 
                                         order by a.id desc"); //and a.id not in (1) administrator
$numdata = mysqli_num_rows($getdata);

?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Join Account</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Masters</a></li>
                <li class="breadcrumb-item active">Join Account</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-12">
                <div class="card top-selling overflow-auto effectup">
                    <div class="card-body pb-0">
                        <?php if (!isset($_GET['form'])) { ?>
                            <div align="right">
                                <a class="btn btn-success mt-3 mb-3 float-right pull-right" href="<?= $links_path; ?>&form=add">Create</a>
                            </div>
                            <table class="table table-striped table-bordered datatable mt-3">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Bank</th>
                                        <th>Name</th>
                                        <th>Number</th>
                                        <th>Status</th>
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
                                                <td><?= $rows['bank']; ?></td>
                                                <td><?= $rows['name']; ?></td>
                                                <td><?= $rows['number']; ?></td>
                                                <td class="text-center">
                                                    <span class="badge bg-<?= $rows['statuscolor']; ?>"><?= $rows['statuslabel']; ?></span>
                                                </td>
                                                <td class="text-center" style="width:20%;">
                                                    <a href="<?= $links_path; ?>&form=edit&tid=<?= base64_encode($rows['id']); ?>" class="btn btn-primary"><i class="bi bi-pencil"></i></a>
                                                    <a href="#" id="delete_<?= $rows['id']; ?>" tid="<?= $rows['id']; ?>" tipe="join_account" class="btn btn-danger"><i class="bi bi-trash"></i></a>
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

                        <?php } else {
                            $getbank = mysqli_query($conn, "SELECT * from banks order by name asc");
                            $numbank = mysqli_num_rows($getbank);
                            $rowbank = mysqli_fetch_all($getbank, MYSQLI_ASSOC);
                            if (isset($_GET['tid'])) {
                                $label = 'Edit';
                                $labelbutton = 'Update';
                                $tid = base64_decode($_GET['tid']);
                                $getdata = mysqli_query($conn, "SELECT a.*,b.name bank 
                                                                from join_account a 
                                                                left join banks b on a.bank_id=b.id  
                                                                where a.id = '$tid'");
                                $rows = mysqli_fetch_assoc($getdata);
                                $name = $rows['name'];
                                $bank = $rows['bank'];
                                $bank_id = $rows['bank_id'];
                                $number = $rows['number'];
                                $status = $rows['status'];
                            } else {
                                $label = 'Add';
                                $labelbutton = 'Save';
                                $tid = 0;
                                $name = '';
                                $bank = '';
                                $bank_id = '';
                                $number = '';
                                $status = 0;
                            }
                        ?>
                            <input type="hidden" id="tid" name="tid" class="join_accountform" value="<?= $tid; ?>">
                            <h5 class="card-title"><?= $label; ?> Form</h5>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="form-floating mb-2">
                                        <select class="form-control join_accountform" name="bank_id" id="bank_id">
                                            <option value="">Choose bank</option>
                                            <?php foreach ($rowbank as $rowlev) { ?>
                                                <option value="<?= $rowlev['id']; ?>" <?php if ($rowlev['id'] == $bank_id) echo 'selected'; ?>><?= $rowlev['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <label for="bank_id">Banks</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control join_accountform" name="name" id="name" value="<?= $name; ?>" placeholder="Name" required>
                                        <label for="name">Name</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control join_accountform" name="number" id="number" value="<?= $number; ?>" placeholder="Number" required>
                                        <label for="name">Number</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating mb-2">
                                        <select class="form-select join_accountform" id="status" aria-label="Status">
                                            <option value="1" <?php if ($status == 1) echo 'selected'; ?>>Active</option>
                                            <option value="0" <?php if ($status == 0) echo 'selected'; ?>>Non Active</option>
                                        </select>
                                        <label for="status">Status</label>
                                    </div>
                                </div>

                                <div class="text-center mb-3 mt-4">
                                    <a href="<?= $links_path; ?>" class="btn btn-danger">Cancel</a>
                                    <span name="simpan" id="simpan_" tipe="<?= $_GET['page']; ?>" class="btn btn-primary" mode="<?= $label; ?>"><?= $labelbutton; ?></span>
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