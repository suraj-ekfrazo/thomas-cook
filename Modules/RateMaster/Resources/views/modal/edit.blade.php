<div class="modal fade" id="editData" tabindex="-1" aria-hidden="true" style="background: rgba(6,39,75,0.5);">
    <div class="modal-dialog  modal-lg modal-dialog-centered">
        {!! Form::open([
            'route' => ['rate-master.update'],
            'class' => 'update-data-form',
            'id' => 'update-data-form',
            'data-toggle' => 'validator',
            'enctype' => 'multipart/form-data',
            'files' => true,
        ]) !!}

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold" style="color: #2565ab;">Edit Detail</h5>
                <div type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></div>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id" name="id" value="{{ $data->id }}">
                <div class="row mt-3 bgc m-2">
                    <div class="col-lg-12 col-sm-12 mt-3">
                        <label style="color: #ADAEB0; font-size: 14px; " for="user_code">Currency Name</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input type="text" name="currency_name" id="currency_name"
                                class="form-control border-0 border-bottom bg-transparent"
                                value="{{ $data->currency_name }}" readonly>

                        </div>
                    </div>
                    

                    {{--<div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('sell_margin') ? 'has-error' : '' }}">--}}
                        {{--<label style="color: #ADAEB0; font-size: 14px; " for="user_code">Sell Margin</label>--}}
                        {{--<div class="input-group mb-3">--}}
                            {{--<span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img--}}
                                    {{--src="{{ asset('admin-assets/svg/popup/username.svg') }}">--}}
                            {{--</span>--}}
                            {{--<input type="text" name="sell_margin" id="sell_margin"--}}
                                {{--class="form-control border-0 border-bottom bg-transparent"--}}
                                {{--placeholder="Enter Buy Margin" value="{{ $data->sell_margin }}">--}}
                            {{--@component('components.ajax-error', ['field' => 'sell_margin'])--}}
                            {{--@endcomponent--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('sell_margin_10_12') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px; " for="user_code">Sell Margin 10-12</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input type="text" name="sell_margin_10_12" id="sell_margin_10_12"
                                class="form-control border-0 border-bottom bg-transparent"
                                placeholder="Enter Sell Margin" value="{{ $data->sell_margin_10_12 }}">
                            @component('components.ajax-error', ['field' => 'sell_margin_10_12'])
                            @endcomponent
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('sell_margin_12_2') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px; " for="user_code">Sell Margin 12-2</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input type="text" name="sell_margin_12_2" id="sell_margin_12_2"
                                class="form-control border-0 border-bottom bg-transparent"
                                placeholder="Enter Sell Margin" value="{{ $data->sell_margin_12_2 }}">
                            @component('components.ajax-error', ['field' => 'sell_margin_12_2'])
                            @endcomponent
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('sell_margin_2_3_30') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px; " for="user_code">Sell Margin 2 - 3:30</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input type="text" name="sell_margin_2_3_30" id="sell_margin_2_3_30"
                                class="form-control border-0 border-bottom bg-transparent"
                                placeholder="Enter Sell Margin" value="{{ $data->sell_margin_2_3_30 }}">
                            @component('components.ajax-error', ['field' => 'sell_margin_2_3_30'])
                            @endcomponent
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('sell_margin_3_30_end') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px; " for="user_code">Sell Margin 3:30 end</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom"
                                id="basic-addon1"><img src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input type="text" name="sell_margin_3_30_end" id="sell_margin_3_30_end"
                                class="form-control border-0 border-bottom bg-transparent"
                                placeholder="Enter Sell Margin" value="{{ $data->sell_margin_3_30_end }}">
                            @component('components.ajax-error', ['field' => 'sell_margin_3_30_end'])
                            @endcomponent
                        </div>
                    </div>
		    <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('buy_margin') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px; " for="user_code">Buy Margin</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                    src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input type="text" name="buy_margin" id="buy_margin"
                                class="form-control border-0 border-bottom bg-transparent"
                                placeholder="Enter Buy Margin" value="{{ $data->buy_margin }}">
                            @component('components.ajax-error', ['field' => 'buy_margin'])
                            @endcomponent
                        </div>
                    </div>
			 <div class="col-lg-6 col-sm-6 mt-3 {{ $errors->has('holiday_margin') ? 'has-error' : '' }}">
                        <label style="color: #ADAEB0; font-size: 14px; " for="holiday_margin">Holiday Margin</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-transparent border-0 border-bottom" id="basic-addon1"><img
                                        src="{{ asset('admin-assets/svg/popup/username.svg') }}">
                            </span>
                            <input type="text" name="holiday_margin" id="holiday_margin"
                                   class="form-control border-0 border-bottom bg-transparent"
                                   placeholder="Enter Buy Margin" value="{{ $data->holiday_margin }}">
                            @component('components.ajax-error', ['field' => 'holiday_margin'])
                            @endcomponent
                        </div>
                    </div>
		
                </div>
            </div>
            <div class="modal-footer text-center">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <button type="submit" class="btn btn-primary mr-1 mb-1">Update</button>
                <button type="reset" class="btn btn-danger mr-1 mb-1">Reset</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<script>
    /* Datepicker */
    $('#validity_from,#validity_till').datepicker({
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        todayBtn: "linked",
        language: 'en',
        autoclose: true
    });

    //Close edit model
    $(document).on('click', '.btn-close ', function() {
        $('#editData').modal('hide');
    });

    /* Reset Btn */
    $(document).on('click', '.update-data-form button[type="reset"] ', function() {
        $('.ajax-error strong').html('');
    });


    //-------Update admin record----------
    $(document).on('submit', '.update-data-form', function(event) {
        var status = document.activeElement.innerHTML;
        event.preventDefault();
        if (status) {
            $('.ajax-error').html('');
            var serializeData = $(this).serializeArray();
            var data = {};
            var fd = new FormData();
            $.each(serializeData, function(key, val) {
                fd.append(val['name'], val['value']);
            });
            $.ajax({
                url: $(this).attr('action'),
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
