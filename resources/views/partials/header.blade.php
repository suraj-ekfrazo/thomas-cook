<!-- Topbar Start -->
<nav class="navbar navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard.index') }}">
            <!-- <img src="{{ asset('admin-assets/img/logo2.png') }}" class="img-fluid" alt="Responsive image" /> -->
            <img src="{{ asset('assets/images/LOGO.png') }}" class="img-fluid" alt="Responsive image" />
        </a>
        <!-- <a href="#" class="notification ms-auto">
            <img src="{{ asset('admin-assets/svg/dashboard/ic_notification.svg') }}">
        </a> -->
        <div class="dropdown">
            <a class=" " href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                @if (Auth::guard('admin')->check())
                    @php
                        $adminProfile = Auth::user()->user_profile != null ? Auth::user()->user_profile : 'default.png';
                    @endphp
                    <img src="{{ asset('users/admin/profile/' . $adminProfile) }}"
                        class="avatar img-fluid rounded-circle me-1" alt="user-image" />
			<span class="text-dark">{{ ucwords(Auth::user()->name) }}</span>
                @else
                    <img src="{{ asset('images/logo_sm.png') }}" class="avatar img-fluid rounded-circle me-1"
                        alt="user-image">
			<span class="text-dark"></span>
                @endif

                
                <span style="color:  rgba(0,0,0,0.62) ;">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6">
                            <path id="Polygon_36" data-name="Polygon 36"
                                d="M4.232.922a1,1,0,0,1,1.536,0L8.633,4.36A1,1,0,0,1,7.865,6H2.135a1,1,0,0,1-.768-1.64Z"
                                transform="translate(10 6) rotate(180)" opacity="0.62" />
                        </svg>
                    </span>
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <form method="post" action="{{ route('admin.logout') }}">
                    @csrf
                    <a class="dropdown-item" href="javascript:void(0);"
                        onclick="$(this).closest('form').submit();">Logout</a>
                </form>
            </div>
        </div>
    </div>
</nav>
<!-- end Topbar -->
