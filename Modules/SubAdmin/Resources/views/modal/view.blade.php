<link rel="stylesheet" href="{{ asset('plugins/datepicker/bootstrap-datepicker.min.css') }}" type="text/css" />

<div class="modal fade" id="showData" aria-hidden="true" style="top: 15px;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View User</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- Profile -->
                        <div class="card">
                            <div class="card-body profile-user-box">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="media">
                                            <span class="float-left m-2 mr-4">
                                                @php $uprofile = $data['profile'] != NUll ? $data['profile'] : 'default.png'; @endphp<img src="{{ asset('/users/admin/profile/' . $uprofile) }}"
                                                    style="height: 100px; width:100px;" alt=""
                                                    class="rounded-circle img-thumbnail"></span>
                                            <div class="media-body">

                                                <h4 class="my-1">{{ $data['first_name'] }}</h4>
                                                <p class="font-13 text-muted">{{ $data['last_name'] }}</p>

                                                <ul class="mb-0 list-inline">
                                                    <li class="list-inline-item mr-3">
                                                        <h5 class="mb-1">User Name</h5>
                                                        <p class="mb-0 font-13">{{ $data['name'] }}</p>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <h5 class="mb-1">User Code</h5>
                                                        <p class="mb-0 font-13">{{ $data['user_code'] }}</p>
                                                    </li>
                                                </ul>
                                            </div> <!-- end media-body-->
                                        </div>
                                    </div> <!-- end col-->
                                </div> <!-- end row -->

                            </div> <!-- end card-body/ profile-user-box-->
                        </div>
                        <!--end profile/ card -->
                    </div> <!-- end col-->
                </div>
                <!-- end row -->
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Chart-->
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title mt-0 mb-3">Personal Information</h4>
                                <hr />
                                <div class="text-left">
                                    <p class="text-muted">
                                        <strong>Full Name :</strong>
                                        <span class="ml-2">{{ $data['first_name'] . ' ' . $data['last_name'] }}</span>
                                    </p>
                                    <p class="text-muted">
                                        <strong>Mobile :</strong>
                                        <span class="ml-2">{{ $data['user_mobile'] }}</span>
                                    </p>
                                    <p class="text-muted">
                                        <strong>Gender :</strong>
                                        <span class="ml-2">{{ $data['gender'] }}</span>
                                    </p>
                                    <p class="text-muted mb-0">
                                        <strong>Date of Joining :</strong>
                                        <span class="ml-2">{{ date('F j, Y', strtotime($data['created_at'])) }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
            </div>
        </div>
    </div>
</div>
