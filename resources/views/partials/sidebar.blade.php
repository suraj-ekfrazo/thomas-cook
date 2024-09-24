<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!-- User box -->
        <div class="user-box text-center">
            <img src="../assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme"
                 class="rounded-circle avatar-md">
            <div class="dropdown">
                <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block"
                   data-toggle="dropdown">Geneva Kennedy</a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user mr-1"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings mr-1"></i>
                        <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock mr-1"></i>
                        <span>Lock Screen</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out mr-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>
            <p class="text-muted">Admin Head</p>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul id="side-menu">
                {{-- <li class="menu-title">Navigation</li> --}}
                <li>
                    <a href="{{ route('dashboard.index') }}">
                        <i data-feather="airplay"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                {{-- <li class="menu-title mt-2">Apps</li> --}}
                <li>
                    <a href="{{ route('holidays.index') }}">
                        <i data-feather="calendar"></i>
                        <span> Holidays </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('agent.index') }}">
                        <i data-feather="users"></i>
                        <span> Agents </span>
                    </a>
                </li>

                <li>
                    <a href="#sidebarCrm" data-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Admin Users </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarCrm">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('roles.index') }}">Roles</a>
                            </li>
                            <li>
                                <a href="{{ route('admin-users.index') }}">Users</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#deletedUsers" data-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Deleted Users </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="deletedUsers">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('agent.deleted.index') }}">Agents</a>
                            </li>
                            <li>
                                <a href="{{ route('admin-users.deleted.index') }}">Users</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="{{ route('admin-incidents.index') }}">
                        <i data-feather="calendar"></i>
                        <span> Reports </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin-incident-requests.index') }}">
                        <i data-feather="calendar"></i>
                        <span> All Request </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin-incidents.unassigned') }}">
                        <i data-feather="calendar"></i>
                        <span> Unassign Request </span>
                    </a>
                </li>

            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
