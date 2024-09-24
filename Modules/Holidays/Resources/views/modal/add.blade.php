
<link rel="stylesheet" href="{{ asset('plugins/datepicker/bootstrap-datepicker.min.css') }}" type="text/css" />

<div class="modal fade" id="AddHoliday" aria-hidden="true" style="top: 15px;">
    <div class="modal-dialog modal-lg ">
        {!! Form::open([
            'route' => ['holidays.save'],
            'class' => 'form form-vertical save-holiday-form',
            'id' => 'save-holiday-form',
            'data-toggle' => 'validator',
            'enctype' => 'multipart/form-data',
            'files' => true,
        ]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Holiday</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <div class="form-body">
                    <div class="row">
                        <div class="col-6 mb-1">
                            <label for="first-name-vertical">Holiday Name</label>
                            <input class="form-control" type="text" id="holiday_name" name="holiday_name"
                                autocomplete="off" placeholder="Enter holiday name">
                            @component('components.ajax-error', ['field' => 'holiday_name'])
                            @endcomponent
                        </div>
                        <div class="col-6 mb-1">
                            <label for="first-name-vertical">Holiday Date</label>
                            <input class="form-control" type="text" id="holiday_date" name="holiday_date"
                                autocomplete="off" placeholder="Enter holiday date">
                            @component('components.ajax-error', ['field' => 'holiday_date'])
                            @endcomponent
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-12 d-flex mt-1">
                    <button type="submit" class="btn btn-primary mr-1 mb-1">Save</button>
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
    $('.save-holiday-form button[type="reset"]').click(function() {
        $('.ajax-error strong').html('');
    });

    /* Datepicker */
    $('#holiday_date').datepicker({
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        todayBtn: "linked",
        language: 'en',
        autoclose: true
    });

    /* Add Form */
    $('.save-holiday-form').submit(function(event) {
        var status = document.activeElement.innerHTML;
        event.preventDefault();
        if (status) {
            $('.ajax-error').html('');
            var serializeData = $(this).serializeArray();
            var data = {};
            $.each(serializeData, function(key, val) {
                data[val['name']] = val['value'];
            });

            $.ajax({
                url: $(this).attr("action"),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: JSON.stringify(data),
                contentType: "application/json",
                success: function(result) {
                    $(this).attr("disabled", false);
                    if (result.type === 'SUCCESS') {
                        toastr.success(result.message);
                        $('#AddHoliday').modal('hide');
                        $('#holiday-datatable').DataTable().ajax.reload();
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
