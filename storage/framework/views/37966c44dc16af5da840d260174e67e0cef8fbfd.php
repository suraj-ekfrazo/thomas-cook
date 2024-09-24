<tr>
    <th style="font-weight: 800;">Type of Booking</th>
    <th style="font-weight: 800;">Incident Count</th>
</tr>
<tr>
    <th style="color: #2565ab; font-weight: 800;">Buy</th>
    <td><?php echo e($IncidentBuy); ?></td>
</tr>
<tr>
    <th style="color: #2565ab; font-weight: 800;">Sell(Block Rate)</th>
    <td><?php echo e($IncidentSellBlockRate); ?></td>
</tr>
<tr>
    <th style="color: #2565ab; font-weight: 800;">Sell(With doc)</th>
    <td><?php echo e($IncidentSellWithDoc); ?></td>
</tr>
<tr>
    <th style="color: #2565ab; font-weight: 800;">Accepted</th>
    <td><?php echo e($IncidentDeclined); ?></td>
</tr>
<tr>
    <th style="color: #2565ab; font-weight: 800;">Rejected</th>
    <td><?php echo e($IncidentAccepted); ?></td>
</tr>
<!--<tr>
    <th style="color: #2565ab; font-weight: 800;">Reinitiated</th>
    <td>0</td>
</tr>-->
<tr>
    <th style="color: #2565ab; font-weight: 800;">Under Progress</th>
    <td><?php echo e($IncidentPending); ?></td>
</tr>
<?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/Modules/AdminIncidents/Resources/views/modal/report-summary-table.blade.php ENDPATH**/ ?>