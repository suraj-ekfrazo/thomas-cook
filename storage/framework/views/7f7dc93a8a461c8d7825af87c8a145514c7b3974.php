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
                        <div class="text-light text-center" style="font-size :24px; flex: 0.8; font-weight: 600;">Booking
                            Allocation
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="background-image: url(<?php echo e(asset('admin-assets/img/main_bg.jpg')); ?>);">
        <div class="container">
            <?php if(\Session::has('error')): ?>
                <div class="alert alert-danger">
                    <ul>
                        <li><?php echo \Session::get('error'); ?></li>
                    </ul>
                </div>
            <?php endif; ?>
            <?php if(\Session::has('success')): ?>
                <div class="alert alert-success">
                    <ul>
                        <li><?php echo \Session::get('success'); ?></li>
                    </ul>
                </div>
            <?php endif; ?>

	    <div class="row mt-5">
                <div class="col-md-2">
		    <label style="color: #ADAEB0; font-size: 14px; " for="from_date">FROM DATE</label>
                    <input type="date" name="from_date" id="from_date" class="form-control" />
                </div>
                <div class="col-md-2">
		    <label style="color: #ADAEB0; font-size: 14px; " for="to_date">TO DATE</label>
                    <input type="date" name="to_date" id="to_date" class="form-control" />
                </div>
                <div class="col-md-2">
		    <label style="color: #ADAEB0; font-size: 14px; " for="to_date">SELECT BOOKING TYPE</label>
                    <select class="form-select fw-bold border-0 border-bottom pb-0 bg-transparent" name="booking_type" id="booking_type">
                        <option value="">Select Booking Type</option>
                        <option value="0">Buy</option>
                        <option value="1">Sell</option>
                    </select>
                </div>
		
		<div class="col-md-2">
		    <label style="color: #ADAEB0; font-size: 14px; " for="to_date">SELECT Agent CODE</label>
                    <select class="form-select fw-bold border-0 border-bottom pb-0 bg-transparent" name="agent_id" id="agent_id">
                        <option value="">Select Agent</option>
                        <?php $__currentLoopData = $data_agent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item['id']); ?>">
                                <?php echo e($item['agent_code']); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-success" id="filterBtn">Filter</button>
                </div>
            </div>

            <div class="table-responsive table-striped p-3 mb-3 mt-3 bg-white shadow rounded-5">
                <div class="d-flex justify-content mb-4">
                    <div class="border-1"></div>
                    <div class="ps-1 fw-bold" style="color: #1E1E1E;">Booking Allocation
                    </div>
                </div>
                <table id="data-datatable" class="table roundedTable table w-100 nowrap">
                    <thead style="backgrounD-color: #F4F6F8;">
                        <tr>
                            <th style="color: #2565ab; font-weight: 800;  ">#</th>
				
                            <th style="color: #2565ab; font-weight: 800;  ">Incident No</th>
			    <th style="color: #2565ab; font-weight: 800;  ">Agent Code</th>
			    <th style="color: #2565ab; font-weight: 800;">Booking Type</th>
                            <th style="color: #2565ab; font-weight: 800;  ">Date of Departure</th>
                            <th style="color: #2565ab; font-weight: 800;  ">Issued TC-User</th>
                            <th style="color: #2565ab; font-weight: 800;  ">Allocate TC-User</th>
                            
                            
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="addModals"></div>

    <?php $__env->startPush('pagescript'); ?>
        <?php echo $__env->make('stacks.js.datatables', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('stacks.js.modules.booking-allocation.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/Modules/BookingAllocation/Resources/views/index.blade.php ENDPATH**/ ?>