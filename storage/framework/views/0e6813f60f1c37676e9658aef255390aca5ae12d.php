<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.admin.sub-heading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
<?php echo $__env->make('stacks.js.modules.subadmin.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/Modules/SubAdmin/Resources/views/index.blade.php ENDPATH**/ ?>