

<script type="text/javascript" src="<?php echo e(asset('admin-assets/js/jquery-3.6.0.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('admin-assets/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('admin-assets/js/17301e251b.js')); ?>" crossorigin="anonymous"></script>
<script src="<?php echo e(asset('admin-assets/js/jquery-3.4.1.min.js')); ?>"></script>
<script src="<?php echo e(asset('admin-assets/js/owl.carousel.min.js')); ?>"></script>
<!-- MDB -->
<script type="text/javascript" src="<?php echo e(asset('admin-assets/js/mdb.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('admin-assets/js/jquery-3.6.0.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('admin-assets/js/jquery.dataTables.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('admin-assets/js/dataTables.bootstrap5.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('admin-assets/js/dataTables.select.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/datepicker/bootstrap-datepicker.min.js')); ?>"></script>
<script src="<?php echo e(asset('admin-assets/js/sweetalert.min.js')); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Datatable Export Button -->
<!-- <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script> -->

<script>
    // ==========================================================================
    $(document).ready(function() {
        $('#example').DataTable({});
    });

    $(document).ready(function() {
        $('#example1').DataTable({});
    });
</script>
<script>
    // ==========================================================================
    $('#ChangePassword').click(function() {
        $('#savePsw').val("change-password");
        $('#branch_id').val('');
        $('#brnachForm').trigger("reset");
        $('#modelHeading').html("Change Password");
        $('#newpassword-error').text('');
        $('#confirmpassword-error').text('');
        $('#user_profile-error').text('');
        $('#getajaxModel').modal('show');
    });

    $('#passwordForm').submit(function(event) {
        event.preventDefault();
        $('#savePsw').html('Sending..');
        $('#newpassword-error').text('');
        $('#confirmpassword-error').text('');
        $('#user_profile-error').text('');
        var formData = new FormData(this);
        // ajax send Form Data with image
        $.ajax({
            url: "<?php echo e(route('user-password.update')); ?>",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    if (data.success) {
                        swal({
                            title: "Great!",
                            text: data.success,
                            type: "success"
                        }).then(function() {
                            window.location.reload();
                        });
                    }
                } else {
                    printErrorMsg(data.error);
                    toastr.warning(data.error);
                    toastr.warning(data.responseJSON.error);
                }
                $('#savePsw').html('Submit');
                $('#passwordForm').trigger("reset");
                $('#getajaxModel').modal('hide');
            },
            error: function(data) {
                console.log('Error:', data);
                if (data.responseJSON.error) {
                    toastr.warning(data.responseJSON.error);
                }
                if (data.responseJSON.errors) {
                    $('#newpassword-error').text(data.responseJSON.errors.new_password);
                    $('#confirmpassword-error').text(data.responseJSON.errors.confirm_password);
                    $('#user_profile-error').text(data.responseJSON.errors.user_profile);
                }
                $('#savePsw').html('Submit');
            }
        });
    });

    $('#adminUpdateProfile').click(function() {
        $('#adminsavePsw').val("change-password");
        $('#adminModelHeading').html("Update Profile");
        $('#admin-new-password-error').text('');
        $('#admin-confirm-password-error').text('');
        $('#admin-email-error').text('');
        $('#admin-name-error').text('');
        $('#admingetajaxModel').modal('show');
    });

    $('#profileForm').submit(function(event) {
        event.preventDefault();
        $('#adminsavePsw').html('Sending..');
        $('#admin-newpassword-error').text('');
        $('#admin-confirm-password-error').text('');
        $('#admin-email-error').text('');
        $('#admin-name-error').text('');
        var formData = new FormData(this);
        // ajax send Form Data with image
        $.ajax({
            url: "<?php echo e(route('admin-profile.update')); ?>",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    if (data.success) {
                        swal({
                            title: "Great!",
                            text: data.success,
                            type: "success"
                        }).then(function() {
                            window.location.reload();
                        });
                    }

                } else {
                    printErrorMsg(data.error);
                    toastr.warning(data.error);
                    toastr.warning(data.responseJSON.error);
                }
                $('#adminsavePsw').html('Submit');
                $('#profileForm').trigger("reset");
                $('#admingetajaxModel').modal('hide');
            },
            error: function(data) {
                console.log('Error:', data);
                if (data.responseJSON.error) {
                    toastr.warning(data.responseJSON.error);
                }
                if (data.responseJSON.errors) {
                    $('#admin-new-password-error').text(data.responseJSON.errors.new_password);
                    $('#admin-confirm-password-error').text(data.responseJSON.errors
                        .confirm_password);
                    $('#admin-user-profile-error').text(data.responseJSON.errors.user_profile);
                    $('#admin-email-error').text(data.responseJSON.errors.email);
                    $('#admin-name-error').text(data.responseJSON.errors.name);
                }
                $('#adminsavePsw').html('Submit');
            }
        });
    });
</script>
<?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/resources/views/partials/script.blade.php ENDPATH**/ ?>