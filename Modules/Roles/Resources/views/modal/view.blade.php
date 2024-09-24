<link rel="stylesheet" href="{{ asset('plugins/datepicker/bootstrap-datepicker.min.css') }}" type="text/css" />

<div class="modal fade" id="showData" aria-hidden="true" style="top: 15px;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Role</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Role Name:</strong>
                            {{ $role->name }}
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-centered mb-0">
                            <thead>
                                <tr>
                                    <th>MODULE</th>
                                    <th>VIEW</th>
                                    <th>ADD</th>
                                    <th>EDIT</th>
                                    <th>DELETE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permission as $permissionData)
                                <tr>
                                    @foreach($permissionData as $key => $attendance)
                                    @if ($loop->first)
                                        <td>{{ $key }}</td>
                                    @endif
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" id="customCheck<?php echo $attendance;?>" name="permission[]" type="checkbox" value="<?php echo $attendance; ?>" <?php if(in_array($attendance, $rolePermissions)){ echo "checked";}; ?> disabled>
                                            <label class="custom-control-label" for="customCheck<?php echo $attendance;?>"></label>
                                        </div>
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                                @component('components.ajax-error', ['field' => 'permission'])@endcomponent
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
