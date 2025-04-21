<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="copyright">
        &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<script src=" https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="assets/bootstrap-tags/bootstrap-tagsinput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

<!-- Vendor JS Files -->
<script src="assets/adminlte/assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="assets/adminlte/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/adminlte/assets/vendor/chart.js/chart.umd.js"></script>
<script src="assets/adminlte/assets/vendor/echarts/echarts.min.js"></script>
<script src="assets/adminlte/assets/vendor/quill/quill.js"></script>
<script src="assets/adminlte/assets/vendor/tinymce/tinymce.min.js"></script>
<script src="assets/adminlte/assets/vendor/php-email-form/validate.js"></script>
<!-- gsap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<!-- izitoast -->
<script src="assets/iziToast/dist/js/iziToast.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>


<script>
    <?= checkMenuRole($_SESSION['role_id'], $getpage); ?>

    $('.datatable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });


    //style="display:none;"

    $('.select2tags').select2();
    // var url = window.location.href;
    // var res = url.split('/');
    // countres = res.length - 1;
    // var filename = res[countres].split('.');
    // console.log(filename[0]);

    //sidebarleft
    $.each($(".sidebarleft"), function(index, value) {
        var id = $(this).attr('id');
        var parentid = $(this).attr('parentid');
        if (id == '<?= $getpage; ?>') {
            if (parentid == '') {
                $("#" + id).removeClass('collapsed');
            } else {
                $("#" + id).addClass('active');
                $("#" + parentid + "-nav").addClass('show');
                $("#" + parentid + "").removeClass('collapsed');
            }
        }

    })

    setTimeout(function() {
        $('#loading').hide();
    }, 2000);

    iziToast.settings({
        timeout: 3000, // default timeout
        resetOnHover: true,
        transitionIn: 'flipInX',
        transitionOut: 'flipOutX',
        position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
        onOpen: function() {
            console.log('callback abriu!');
        },
        onClose: function() {
            console.log("callback fechou!");
        }
    });

    function callsuccesstoast(title, description, type) {

        if (type == 'danger') {
            iziToast.danger({
                timeout: 5000,
                icon: 'fa fa-close',
                title: '' + title + '',
                message: '' + description + ''
            });
        } else if (type == 'success') {
            iziToast.success({
                timeout: 5000,
                icon: 'fa fa-check',
                title: '' + title + '',
                message: '' + description + ''
            });
        }


    }
    gsap.from(".effectup", {
        y: 50,
        duration: 3,
        ease: "power3.out",
    });

    <?php if ($getpage == 'majors' && isset($_GET['form'])) { ?>

        function removesdetail(counter) {
            $("#sub_row" + counter).remove();
        }
        var item_counter = <?php echo $item_counter; ?>;

        $("#add_item").click(function() {
            counter = 1;
            $('[name="user_id[]"]').each(function() {
                counter++;
            })

            if (counter > 26) {
                alert('Maksimum 26 item');
                return false;
            }
            var listrole = '';
            <?php if ($numrole > 0) { ?>
                <?php foreach ($rowrole as  $rowser) { ?>
                    listrole += '<option value = "<?= $rowser['id']; ?>" ><?= $rowser['name']; ?></option>';
                <?php } ?>
            <?php } ?>

            $("#item_list tbody#t").append(`
        <tr id="sub_row${item_counter}">
        <td class="pl-0">
            <select class="select2tags custom-select user_id form-control majorsdetailform${item_counter}" counter="${item_counter}" name="user_id[]" id="user_id${item_counter}">
                <option value="">Choose role</option>
                ${listrole}
            </select>
        </td> 
        <td class="pr-0" class="align-middle">
            <a href="#" class="icon fe-md" onclick="removesdetail(${item_counter})">
                <i class="bi bi-x-square "></i>
            </a>
        </td>
    </tr>`);
            item_counter++;
            return false;
        });


    <?php } ?>


    <?php if ($getpage == 'users' && isset($_GET['form'])) { ?>

        function removesdetail(counter) {
            $("#sub_row" + counter).remove();
        }
        var item_counter = <?php echo $item_counter; ?>;

        $("#add_item").click(function() {
            counter = 1;
            $('[name="role_id[]"]').each(function() {
                counter++;
            })

            if (counter > 26) {
                alert('Maksimum 26 item');
                return false;
            }
            var listrole = '';
            <?php if ($numrole > 0) { ?>
                <?php foreach ($rowrole as  $rowser) { ?>
                    listrole += '<option value = "<?= $rowser['id']; ?>" ><?= $rowser['name']; ?></option>';
                <?php } ?>
            <?php } ?>

            $("#item_list tbody#t").append(`
                <tr id="sub_row${item_counter}">
                <td class="pl-0">
                    <select class="select2tags custom-select role_id form-control userroleform${item_counter}" counter="${item_counter}" name="role_id[]" id="role_id${item_counter}">
                        <option value="">Choose role</option>
                        ${listrole}
                    </select>
                </td> 
                <td class="pr-0" class="align-middle">
                    <a href="#" class="icon fe-md" onclick="removesdetail(${item_counter})">
                        <i class="bi bi-x-square "></i>
                    </a>
                </td>
            </tr>`);
            item_counter++;
            return false;
        });


    <?php } ?>
    <?php if ($getpage == 'learning_moduls' && isset($_GET['form'])) { ?>

        function removesdetail(counter) {
            $("#sub_row" + counter).remove();
        }
        var item_counter = <?php echo $item_counter; ?>;

        $("#add_item").click(function() {
            counter = 1;
            $('[name="reference_link[]"]').each(function() {
                counter++;
            })

            if (counter > 26) {
                alert('Maksimum 41 item');
                return false;
            }

            $("#item_list tbody#t").append(`
                 <tr id="sub_row${item_counter}"> 
                    <td>
                     <input type="hidden" value="" class="learning_modulsformdetail${item_counter}" id="file${item_counter}" counter="${item_counter}" name="file[]">
                     <input type="hidden" value="" class="learning_modulsformdetail${item_counter}" id="file_name${item_counter}" counter="${item_counter}" name="file_name[]">                      
                        <div class="input-group">
                        <textarea class="reference_link form-control text-right learning_modulsformdetail${item_counter}" id="reference_link${item_counter}" counter="${item_counter}" name="reference_link[]"></textarea>
                        </div>
                    </td>
                    <td><input type="file" id="photo${item_counter}" class="form-control learning_modulsformdetail${item_counter}" name="photo[]" counter="${item_counter}" multiple></td>
                    <td class="pr-0" class="align-middle">
                        <span class="icon fe-md text-primary pointer" onclick="removesdetail(${item_counter})">
                         <i class="bi bi-x-square "></i>
                        </span>
                    </td>
            </tr>`);
            item_counter++;
            return false;
        });

        $(document).on('input', '.allow_decimal', function(evt) {
            var self = $(this);
            self.val(self.val().replace(/[^0-9\.]/g, ''));
            if ((evt.key != 46 || self.val().indexOf('.') != -1) && (evt.key < 48 || evt.key > 57)) {
                evt.preventDefault();
            }
        });


        $(document).on('input', '.allow_integer', function(evt) {
            var self = $(this);
            self.val(self.val().replace(/[^0-9\.]/g, ''));
            if ((evt.key != 46 || self.val().indexOf('.') != -1) && (evt.key < 48 || evt.key > 57)) {
                evt.preventDefault();
            }
        });


    <?php } ?>
</script>

<!-- Template Main JS File -->
<script src="assets/adminlte/assets/js/main.js?v=<?= time(); ?>"></script>
<script src="js/custom.js?v=<?= time(); ?>"></script>
<div class="modal fade" id="logoutmodal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confimation Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are You Sure Wants To Logout ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a type="button" class="btn btn-danger" href="php/logout.php">Logout</a>
            </div>
        </div>
    </div>
</div><!-- End Small Modal-->

</body>

</html>