<?php $__env->startSection('content'); ?>
<div class="w-100 bg-cover flickity-cell is-selected" style="background-image: url(<?php echo e(asset('admin-assets/img/admin/heading.jpg')); ?>); transform: translateX(0%); opacity: 1;">
    <div class="bg-dark-20">
        <div class=" container  justify-content-between">
            <div class=" " style="min-height: 150px;">
                <div class="d-flex pt-5">
                    <a href="<?php echo e(route('dashboard.index')); ?>" class="D-icon">
                        <i class="fa-solid fa-house ms-2 me-2"></i>Go To Dashboard
                    </a>
                    <div class="text-light text-center" style="font-size :24px; flex: 0.8; font-weight: 600;">Travel
                        Agent
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="background-image: url(<?php echo e(asset('admin-assets/img/main_bg.jpg')); ?>);">
    <!--  Start Container  -->
    <div class="container">
        <!--Sub heading -->
        <div class="row pt-5 pb-5 justify-content-center">
            <div class="col-md-3 col-lg-3 col-sm-3">
                <a href="<?php echo e(route('agent.add')); ?>">
                    <div class="widget-stat card bg-dashboard m-3 <?php if(request()->segment(1) == 'agent' && request()->segment(2) == 'create'): ?> active <?php endif; ?>">
                        <div class="card-body ">
                            <div class="media">
                                <span class="me-3">
                                    <img src="<?php echo e(asset('admin-assets/svg/travel agent/travel-agent-create.svg')); ?>">
                                </span>
                                <div class=" fw-bold">Create
                                    Travel Agent</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-3">
                <a href="<?php echo e(route('agent.index')); ?>">
                    <div class="widget-stat card bg-dashboard m-3 <?php if(request()->segment(1) == 'agent' && request()->segment(2) == ''): ?> active <?php endif; ?>">
                        <div class="card-body ">
                            <div class="media">
                                <span class="me-3">
                                    <img src="<?php echo e(asset('admin-assets/svg/travel agent/travel-agent-list.svg')); ?>">
                                </span>
                                <div class=" fw-bold">Travel Agent List</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-3">
                <a href="<?php echo e(route('subagent.add')); ?>">
                    <div class="widget-stat card bg-dashboard m-3 <?php if(request()->segment(1) == 'subagent' && request()->segment(2) == 'create'): ?> active <?php endif; ?>">
                        <div class="card-body ">
                            <div class="media">
                                <span class="me-3">
                                    <img src="<?php echo e(asset('admin-assets/svg/travel agent/travel-agent-list.svg')); ?>">
                                </span>
                                <div class=" fw-bold">Create Sub Agent </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 col-lg-3 col-sm-3">
                <a href="<?php echo e(route('subagent.index')); ?>">
                    <div class="widget-stat card bg-dashboard m-3 <?php if(request()->segment(1) == 'subagent' && request()->segment(2) == ''): ?> active <?php endif; ?>">
                        <div class="card-body ">
                            <div class="media">
                                <span class="me-3">
                                    <img src="<?php echo e(asset('admin-assets/svg/travel agent/travel-agent-list.svg')); ?>">
                                </span>
                                <div class=" fw-bold">Sub Agent List</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
             <div class="col-md-3 col-lg-3 col-sm-3">
                    <a href="<?php echo e(route('agent.importView')); ?>">
                        <div class="widget-stat card bg-dashboard m-3 <?php if(request()->segment(1) == 'agent' && request()->segment(2) == 'importView'): ?> active <?php endif; ?>">
                            <div class="card-body ">
                                <div class="media">
                                    <span class="me-3">
                                        <img src="<?php echo e(asset('admin-assets/svg/travel agent/travel-agent-list.svg')); ?>">
                                    </span>
                                    <div class=" fw-bold">Import Agent</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
        </div>
        <!--End sub heading -->
        <!-- Start Form-->
        <?php echo Form::open([
        'route' => ['agent.import'],
        'class' => 'form form-vertical save-data-form',
        'id' => 'save-data-form',
        'data-toggle' => 'validator',
        'enctype' => 'multipart/form-data',
        'files' => true,
        ]); ?>

        <div class="bg-white p-2 shadow" style="border-radius: 20px;  ">
            <div class="row mt-3 m-2">
                <div class="col-lg-4 col-sm-4 mt-3 <?php echo e($errors->has('name') ? 'has-error' : ''); ?>">
                    <label style="color: #ADAEB0; font-size: 14px; ">Import File</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img src="<?php echo e(asset('admin-assets/svg/popup/username.svg')); ?>">
                        </span>
                        <input name="file" id="file" class="form-control border-0 border-bottom bg-transparent " type="file" placeholder="Enter User Name" autocomplete="off">

                        <?php $__env->startComponent('components.ajax-error', ['field' => 'file']); ?>
                        <?php echo $__env->renderComponent(); ?>
                    </div>
                    <p id="warning-message" style="color:red" ></p>
                    <div id="uname_response"></div>
                </div>
                
                <div class="d-flex mb-2">
                    <button type="submit" class="btn-lg btn-primary ">Save</button>
                    <button type="reset" class="btn-lg btn-primary  ">Reset</button>
                </div>
            </div>
        </div>

    </div>
    <!--  End Container  -->
</div>
<?php echo Form::close(); ?>

<!-- End Form-->
<?php $__env->stopSection(); ?>

<?php $__env->startPush('pagescript'); ?>


<script>
    /* Reset Btn */
    $('.save-data-form button[type="reset"]').click(function() {
        $('.ajax-error strong').html('');
    });

    /* Add Form */
    $('.save-data-form').submit(function(event) {
        var status = document.activeElement.innerHTML;
        event.preventDefault();
        if (status) {
            $('.ajax-error').html('');
            var serializeData = $(this).serializeArray();
            var data = {};
            var fd = new FormData();
            var files = $('#file')[0].files[0];
            fd.append('file', files == undefined ? "" : files);
            

            $.ajax({
                url: $(this).attr("action"),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: fd,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                success: function(result) {
                    $(this).attr("disabled", false);
                    if (result.type === 'SUCCESS') {
                        var redirectUrl = "<?php echo e(route('agent.index')); ?>";
                        toastr.success(result.message);
                        window.location.href = redirectUrl;
                        // $('#data-datatable').DataTable().ajax.reload();
                    } else {
                        toastr.error(result.message);
                    }
                },
                error: function(error) {
                    $(this).attr("disabled", false);
                    let errors = error.responseJSON.errors,
                        errorsHtml = '';
                    $.each(errors, function(key, value) {
                        errorsHtml = '<strong>' + value[0] + '</strong>';
                        $('.' + key).html(errorsHtml);
                    });
                }
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/Modules/Agent/Resources/views/importFile.blade.php ENDPATH**/ ?>