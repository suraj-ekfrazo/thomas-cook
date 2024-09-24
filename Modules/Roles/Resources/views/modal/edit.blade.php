<link rel="stylesheet" href="{{ asset('plugins/datepicker/bootstrap-datepicker.min.css') }}" type="text/css" />

<div class="modal fade" id="editData" aria-hidden="true" style="top: 15px;">
    <div class="modal-dialog modal-lg">
        {!! Form::open([
            'route' => ['roles.update'],
            'class' => 'form form-vertical update-data-form',
            'id' => 'update-data-form',
            'data-toggle' => 'validator',
            'enctype' => 'multipart/form-data',
            'files' => true,
        ]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Role</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <div class="modal-body">
                <div class="form-body">
                    <input type="hidden" id="id" name="id" value="{{ $role->id }}">

                    <div class="form-row">
                        <div class="form-group col-md-6 {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name">Role Name</label>
                            <input type="text" name="name" id="name" placeholder="Enter role name"
                                class="form-control" autocomplete="off" value="{{ $role->name }}">
                            @component('components.ajax-error', ['field' => 'name'])@endcomponent
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
                                            <input class="custom-control-input" id="customCheck<?php echo $attendance;?>" name="permission[]" type="checkbox" value="<?php echo $attendance; ?>" <?php if(in_array($attendance, $rolePermissions)){ echo "checked";}; ?>>
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
            <div class="modal-footer">
                <div class="col-12 d-flex mt-1">
                    <button type="submit" class="btn btn-primary mr-1 mb-1">Update</button>
                    <button type="reset" class="btn btn-danger mr-1 mb-1">Reset</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
<script src="{{ asset('plugins/datepicker/bootstrap-datepicker.min.js') }}"></script>
<script>
    /* Reset Btn */
    $('.update-data-form button[type="reset"]').click(function() {
        $('.ajax-error strong').html('');
    });

    /* Update form */
    $('.update-data-form').submit(function(event) {
        var status = document.activeElement.innerHTML;
        event.preventDefault();
        if (status) {
            $('.ajax-error').html('');
            var serializeData = $(this).serialize();
            console.log('serializeData', serializeData);
            var data = {};
            $.ajax({
                url: $(this).attr("action"),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: serializeData,
                success: function(result) {
                    $(this).attr("disabled", false);
                    if (result.type === 'SUCCESS') {
                        toastr.success(result.message);
                        $('#editData').modal('hide');
                        $('#data-datatable').DataTable().ajax.reload();
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
