<?php $__env->startSection('content'); ?>
<div class="w-100 bg-cover flickity-cell is-selected" style="background-image: url(<?php echo e(asset('admin-assets/img/admin/heading.jpg')); ?>); transform: translateX(0%); opacity: 1;">
    <div class="bg-dark-20">
        <div class=" container  justify-content-between">
            <div class=" " style="min-height: 150px;">
                <div class="d-flex pt-5">
                    <a href="<?php echo e(route('dashboard.index')); ?>" class="D-icon">
                        <i class="fa-solid fa-house ms-2 me-2"></i>Go To Dashboard
                    </a>
                    <div class="text-light text-center" style="font-size :24px; flex: 0.8; font-weight: 600;">Tc User
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="background-image: url(<?php echo e(asset('admin-assets/img/main_bg.jpg')); ?>);">
    <div class="container">
        <!--Sub heading -->
        <div class="row pt-5 pb-5 justify-content-center">
            <div class="col-md-6 col-lg-4 col-sm-3">
                <a href="<?php echo e(route('tcuser.add')); ?>">
                    <div class="widget-stat card bg-dashboard m-3 <?php if(request()->segment(1) == 'tcuser' && request()->segment(2) == 'create'): ?> active <?php endif; ?>">
                        <div class="card-body ">
                            <div class="media">
                                <span class="me-3">
                                    <img src="<?php echo e(asset('admin-assets/svg/dashboard/ic_tc_user.svg')); ?>">
                                </span>
                                <div class=" fw-bold">Create
                                    Tc User</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-4 col-sm-3">
                <a href="<?php echo e(route('tcuser.index')); ?>">
                    <div class="widget-stat card bg-dashboard m-3 <?php if(request()->segment(1) == 'tcuser' && request()->segment(2) == ''): ?> active <?php endif; ?> ">
                        <div class="card-body ">
                            <div class="media">
                                <span class="me-3">
                                    <img src="<?php echo e(asset('admin-assets/svg/dashboard/ic_rate_master.svg')); ?>">
                                </span>
                                <div class=" fw-bold">Tc User List</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!--End sub heading -->
		 <a class="btn btn-warning" href="<?php echo e(route('export')); ?>">Export TCUser Data</a>
        <div class="table-responsive table-striped p-3 mb-3 mt-3 bg-white shadow rounded-5">
            <table id="data-datatable" class="table roundedTable table w-100 nowrap">
                <thead style="backgrounD-color: #F4F6F8;">
                    <tr>
                        <th style="color: #2565ab; font-weight: 800;  ">#</th>
                        <th style="color: #2565ab; font-weight: 800;  " class="noExport">Profile</th>
                        <th style="color: #2565ab; font-weight: 800;  ">Name</th>
                        <th style="color: #2565ab; font-weight: 800;  ">Email</th>
                        <th style="color: #2565ab; font-weight: 800;  ">Role</th>
                        <th style="color: #2565ab; font-weight: 800;  ">Create Date</th>
                        <th style="color: #2565ab; font-weight: 800;  ">Status</th>
                        <th style="color: #2565ab; font-weight: 800;  ">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="addModals"></div>

<?php $__env->startPush('pagescript'); ?>
<?php echo $__env->make('stacks.js.datatables', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('stacks.js.modules.tcuser.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/Modules/TcUser/Resources/views/index.blade.php ENDPATH**/ ?>