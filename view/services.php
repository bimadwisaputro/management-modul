<?php
$getdata = mysqli_query($conn, "SELECT *,case status when '1' then 'Active' else 'Not Active' end as statuslabel 
                                        ,case status when '1' then 'success' else 'danger' end as statuscolor 
                                         from services 
                                         where deleted_at is null order by id desc");
$numdata = mysqli_num_rows($getdata);

?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Services</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Masters</a></li>
                <li class="breadcrumb-item active">Services</li>
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
                                        <th>Start Cost</th>
                                        <th>End Cost</th>
                                        <th>Price</th>
                                        <th>Percentage</th>
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
                                                <td><?= number_format($rows['start_cost']); ?></td>
                                                <td><?= number_format($rows['end_cost']); ?></td>
                                                <td><?= number_format($rows['price']); ?></td>
                                                <td class="text-center">
                                                    <?php echo ($rows['percentage'] == '1') ? '<span class="badge bg-success"><i class="bi bi-check-lg"></i></span>' :    ''; ?>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-<?= $rows['statuscolor']; ?>"><?= $rows['statuslabel']; ?></span>
                                                </td>
                                                <td class="text-center" style="width:20%;">
                                                    <a href="<?= $links_path; ?>&form=edit&tid=<?= base64_encode($rows['id']); ?>" class="btn btn-primary"><i class="bi bi-pencil"></i></a>
                                                    <a href="#" id="delete_<?= $rows['id']; ?>" tid="<?= $rows['id']; ?>" tipe="services" class="btn btn-danger"><i class="bi bi-trash"></i></a>
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
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>

                        <?php } else {
                            if (isset($_GET['tid'])) {
                                $label = 'Edit';
                                $labelbutton = 'Update';
                                $tid = base64_decode($_GET['tid']);
                                $getdata = mysqli_query($conn, "SELECT * from services where id = '$tid'");
                                $rows = mysqli_fetch_assoc($getdata);
                                $start_cost = $rows['start_cost'];
                                $end_cost = $rows['end_cost'];
                                $price = $rows['price'];
                                $percentage = $rows['percentage'];
                                $status = $rows['status'];
                            } else {
                                $label = 'Add';
                                $labelbutton = 'Save';
                                $tid = 0;
                                $start_cost = '';
                                $end_cost = '';
                                $price = '';
                                $percentage = 0;
                                $status = 0;
                            }
                        ?>
                            <input type="hidden" id="tid" name="tid" class="servicesform" value="<?= $tid; ?>">
                            <h5 class="card-title"><?= $label; ?> Form</h5>
                            <div class="row g-3">
                                <div class="col-md-6 mb-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control servicesform" name="start_cost" id="start_cost" value="<?= $start_cost; ?>" placeholder="Start Cost" required>
                                        <label for="name">Start Cost</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control servicesform" name="end_cost" id="end_cost" value="<?= $end_cost; ?>" placeholder="End Cost" required>
                                        <label for="name">End Cost</label>
                                    </div>
                                </div>
                                <div class="col-md-10 mb-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control servicesform" name="price" id="price" value="<?= $price; ?>" placeholder="Price" required>
                                        <label for="name">Price</label>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-floating">
                                        <select class="form-control servicesform" name="percentage" id="percentage">
                                            <option value="0" <?= ($percentage == '0') ? 'selected' : ''; ?>>Amount</option>
                                            <option value="1" <?= ($percentage == '1') ? 'selected' : ''; ?>>Percentage</option>
                                        </select>
                                        <label for="name">Percentage</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating mb-2">
                                        <select class="form-select servicesform" id="status" aria-label="Status">
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