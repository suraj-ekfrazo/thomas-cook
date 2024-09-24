<footer class="text-center pb-3 pt-3">
    <a href="#">
        <img src="{{ asset('admin-assets/img/group.png') }}">
    </a>
</footer>


@push('pagescript')
    <script>
        $(document).ready(function() {
            $('.bg-dashboard').click(function() {
                $('.bg-dashboard').removeClass("active");
                $(this).addClass("active");
            });
        });
    </script>
@endpush

{{-- Change password for employee --}}
<div class="modal fade" id="getajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading">Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open([
                'id' => 'passwordForm',
                'name' => 'passwordForm',
                'class' => 'form-horizontal',
                'method' => 'POST',
            ]) !!}
            <div class="modal-body">
                <div class="form-group col-sm-12">
                    <label for="branch_name" class="control-label">New Password</label>
                    {!! Form::password('new_password', [
                        'placeholder' => 'Enter New Password',
                        'id' => 'new_password',
                        'class' => 'form-control',
                    ]) !!}
                    <span class="text-danger" id="newpassword-error"></span>
                </div>
                <div class="form-group col-sm-12">
                    <label class="control-label">Confirm Password</label>
                    {!! Form::password('confirm_password', [
                        'placeholder' => 'Enter confirm Password',
                        'id' => 'confirm_password',
                        'class' => 'form-control',
                    ]) !!}
                    <span class="text-danger" id="confirmpassword-error"></span>
                </div>

                <div class="form-group col-sm-12">
                    <label class="control-label">Profile</label>
                    {!! Form::file('user_profile', ['class' => 'form-control']) !!}
                    <span class="text-danger" id="user_profile-error"></span>
                    <p><img src="" id="profileoutput" width="100" /></p>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="savePsw" value="change">Submit</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

{{-- Update Profile for admin and super-admins --}}
@if (Auth::guard('admin')->check())
    <div class="modal fade" id="admingetajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="adminModelHeading">Password</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {!! Form::open([
                    'id' => 'profileForm',
                    'name' => 'profileForm',
                    'class' => 'form-horizontal',
                    'method' => 'POST',
                ]) !!}
                <div class="modal-body">
                    <div class="form-group col-sm-12">
                        <strong>Name:</strong>
                        <label for="email" class="control-label">Name</label>
                        {!! Form::text('name', \Auth::user()->name, [
                            'placeholder' => 'Name',
                            'id' => 'name',
                            'class' => 'form-control',
                        ]) !!}
                        <span class="text-danger" id="admin-name-error"></span>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="email" class="control-label">Email</label>
                        {!! Form::email('email', \Auth::user()->email, [
                            'placeholder' => 'Email',
                            'id' => 'email',
                            'class' => 'form-control',
                        ]) !!}
                        <span class="text-danger" id="admin-email-error"></span>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="admin-new-password" class="control-label">New Password</label>
                        {!! Form::password('new_password', [
                            'placeholder' => 'Enter New Password',
                            'id' => 'admin-new-password',
                            'class' => 'form-control',
                        ]) !!}
                        <span class="text-danger" id="admin-new-password-error"></span>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="admin-confirm-password" class="control-label">Confirm Password</label>
                        {!! Form::password('confirm_password', [
                            'placeholder' => 'Enter confirm Password',
                            'id' => 'admin-confirm-password',
                            'class' => 'form-control',
                        ]) !!}
                        <span class="text-danger" id="admin-confirm-password-error"></span>
                    </div>

                    <div class="form-group col-sm-12">
                        <label class="control-label">Profile:</label>
                        {!! Form::file('user_profile', ['class' => 'form-control']) !!}
                        <span class="text-danger" id="admin-user-profile-error"></span>
                        <p><img src="" id="adminoutput" width="100" /></p>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="adminsavePsw" value="change">Submit</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endif
