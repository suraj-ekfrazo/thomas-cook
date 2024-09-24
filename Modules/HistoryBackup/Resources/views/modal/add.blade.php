@extends('layouts.admin.app')

@section('content')
    <div class="w-100 bg-cover flickity-cell is-selected"
        style="background-image: url({{ asset('admin-assets/img/admin/heading.jpg') }}); transform: translateX(0%); opacity: 1;">
        <div class="bg-dark-20">
            <div class=" container  justify-content-between">
                <div class=" " style="min-height: 150px;">
                    <div class="d-flex pt-5">
                        <a href="{{ route('dashboard.index') }}" class="D-icon">
                            <i class="fa-solid fa-house ms-2 me-2"></i>Go To Dashboard
                        </a>
                        <div class="text-light text-center" style="font-size :24px; flex: 0.8; font-weight: 600;"> History
                            Backup
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="background-image: url({{ asset('admin-assets/img/main_bg.jpg') }});">
        <div class="container">
            <!--Sub heading -->
            <div class="row pt-5 pb-5 justify-content-center">
                <div class="col-md-6 col-lg-4 col-sm-3">
                    <a href="{{ route('history-backup.create') }}">
                        <div class="widget-stat card bg-dashboard m-3 @if (request()->segment(1) == 'historybackup' && request()->segment(2) == 'create') active @endif">
                            <div class="card-body ">
                                <div class="media">
                                    <span class="me-3">
                                        <img src="{{ asset('admin-assets/svg/dashboard/ic_tc_user.svg') }}">
                                    </span>
                                    <div class=" fw-bold">Create
                                        History Backup</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!--End sub heading -->
                <div class="bg-white p-2 mt-3" style="border-radius: 20px;">
                    <div class="row mt-3 bgc m-2">
                        <div class="col-lg-4 col-sm-4 mt-2" style="text-align:right">
                            <label style="color: #ADAEB0; font-size: 14px; " for="user_code">Backup Created Date</label>
                        </div>
                        <div class="col-lg-4 col-sm-4 ">

                            <input type="date" name="created_at" value="" id="created_at"
                                class="form-control border-0 border-bottom bg-transparent" placeholder="Enter Date"
                                autocomplete="off">
                        </div>
                        <div class="col-lg-4 col-sm-4 ">
                            <button class="btn btn-success" id="filterBtn" type="submit">Create <i
                                    class="loading-icon fa-lg fas fa-spinner fa-spin" style="display:none"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('pagescript')
    <script>
        $('#filterBtn').click(function() {
            var created_at = $('#created_at').val();
            $(this).attr("disabled", true);
            $('.loading-icon').show();

            $.ajax({
                url: "{{ route('history-backup.data') }}",
                type: 'GET',
                data: {
                    created_at: created_at
                },
                success: function(result) {

                    if (result.type === 'SUCCESS') {
                        toastr.success(result.message);
                        $('#filterBtn').attr("disabled", false);
                        $('.loading-icon').hide();
                        var redirectUrl = "{{ route('history-backup.index') }}";
                        //window.location.href = redirectUrl;
                    } else {
                        toastr.error(result.message);
                        $('#filterBtn').attr("disabled", false);
                        $('.loading-icon').hide();
                    }
                },

            });
        });
    </script>
@endpush
