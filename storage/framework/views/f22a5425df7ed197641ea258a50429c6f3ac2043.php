<?php $__env->startSection('content'); ?>
    <div class="w-100 bg-cover flickity-cell is-selected"
        style="background-image: url(<?php echo e(asset('admin-assets/img/admin/heading.jpg')); ?>); transform: translateX(0%); opacity: 1;">
        <div class="bg-dark-20">
            <div class=" container  justify-content-between">
                <div class=" " style="min-height: 150px;">
                    <div class="d-flex pt-5">
                        <a href="<?php echo e(route('dashboard.index')); ?>" class="D-icon">
                            <i class="fa-solid fa-house ms-2 me-2"></i>Go To Dashboard
                        </a>
                        <div class="text-light text-center" style="font-size :24px; flex: 0.8; font-weight: 600;">View All
                            Request
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="background-image: url(<?php echo e(asset('admin-assets/img/main_bg.jpg')); ?>);">
        <div class="container">
            <?php if(\Session::has('error')): ?>
                <div class="alert alert-danger mt-2">
                    <?php echo \Session::get('error'); ?>


                </div>
            <?php endif; ?>
            <?php if(\Session::has('success')): ?>
                <div class="alert alert-success mt-2">
                    <?php echo \Session::get('success'); ?>

                </div>
            <?php endif; ?>
            <div class="row mt-5">
                <div class="col-md-2">
                    <input type="date" name="from_date" id="from_date" class="form-control" />
                </div>
                <div class="col-md-2">
                    <input type="date" name="to_date" id="to_date" class="form-control" />
                </div>
                <div class="col-md-2">
                    <button class="btn btn-success" id="filterBtn">Filter</button>
                </div>
		<div class="col-md-2">
                    <button type="button" class="btn btn-success m-0 ms-auto" onclick="exportExcel();"
                            style="background-color: #FEC948 !important; color: black; font-weight: 600;">Export
                    </button>
                </div>
            </div>
            <div class="table-responsive table-striped p-3 mb-3 mt-3 bg-white shadow rounded-5">
                <div class="d-flex justify-content mb-4">
                    <div class="border-1"></div>
                    <div class="ps-1 fw-bold" style="color: #1E1E1E;">View All Request
                    </div>
                </div>
                <table id="data-datatable" class="table roundedTable table w-100 nowrap">
                    <thead style="backgrounD-color: #F4F6F8;">
                        <tr>
                            <th style="color: #2565ab; font-weight: 800;">#</th>
                            <th style="color: #2565ab; font-weight: 800;">Incident Number</th>
                            <th style="color: #2565ab; font-weight: 800;">TC User Name</th>
                            <th style="color: #2565ab; font-weight: 800;">Agent Code</th>
                            <th style="color: #2565ab; font-weight: 800;">Agent Name</th>
                            
                            <th style="color: #2565ab; font-weight: 800;">Card Number</th>
                            <th style="color: #2565ab; font-weight: 800;">Passport No.</th>
                            <th style="color: #2565ab; font-weight: 800;">Transaction Type</th>
                            <th style="color: #2565ab; font-weight: 800;">FX Currency</th>
                            <th style="color: #2565ab; font-weight: 800;">FX Amount</th>
                            
                            <th style="color: #2565ab; font-weight: 800;">FX Rate</th>
                            <th style="color: #2565ab; font-weight: 800;">INR Amount</th>
                            <th style="color: #2565ab; font-weight: 800;">With Documents?</th>
                            <th style="color: #2565ab; font-weight: 800;">Status</th>
                            
                            <th style="color: #2565ab; font-weight: 800;">Departure Date</th>
                            <th style="color: #2565ab; font-weight: 800;">Bordx no</th>
                            <th style="color: #2565ab; font-weight: 800;">Cashier</th>
                            <th style="color: #2565ab; font-weight: 800;">Booking Date</th>
                            <th style="color: #2565ab; font-weight: 800;">Booking Time</th>
                            
                            <th style="color: #2565ab; font-weight: 800;">Doc Upload Date</th>
                            <th style="color: #2565ab; font-weight: 800;">Doc Upload Time</th>
                            <th style="color: #2565ab; font-weight: 800;">Completed Date</th>
                            <th style="color: #2565ab; font-weight: 800;">Completed Time</th>
                            <th style="color: #2565ab; font-weight: 800;">Comment</th>
                            <th style="color: #2565ab; font-weight: 800;">Create Date</th>
                            <th style="color: #2565ab; font-weight: 800;">View Document</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="addModals"></div>

    <?php $__env->startPush('pagescript'); ?>
        <?php echo $__env->make('stacks.js.datatables', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('stacks.js.modules.admin-incident-requests.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/Modules/AdminIncidentRequest/Resources/views/index.blade.php ENDPATH**/ ?>