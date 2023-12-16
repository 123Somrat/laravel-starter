<!-- Sidebar -->
<nav id="sidebar">
    <!-- Sidebar Scroll Container -->
    <div id="sidebar-scroll">
        <!-- Sidebar Content -->
        <!-- Adding .sidebar-mini-hide to an element will hide it when the sidebar is in mini mode -->
        <div class="sidebar-content">
            <!-- Side Header -->
            <div class="side-header side-content bg-white-op">
                <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
                <button class="btn btn-link text-gray pull-right hidden-md hidden-lg" type="button"
                        data-toggle="layout" data-action="sidebar_close">
                    <i class="fa fa-times"></i>
                </button>
                <!-- Themes functionality initialized in App() -> uiHandleTheme() -->
                <a class="h5 text-white" href="{{route('home')}}">
                    <span class="h5 text-primary font-w600">Laravel </span> <span
                            class="h5 font-w600 sidebar-mini-hide">Starter</span>
                </a>
            </div>
            <!-- END Side Header -->

            <!-- Side Content -->
            <div class="side-content">
                <ul class="nav-main">
                    <li>
                        <a href="{{route('admin.home')}}"><i class="si si-speedometer"></i><span
                                    class="sidebar-mini-hide">Dashboard</span></a>
                    </li>
                    {{--<li class="nav-main-heading"><span class="sidebar-mini-hide">User Interface</span></li>--}}
                    @if(auth()->user()->hasRole('super_admin')|| auth()->user()->hasAnyPermission(['users.view','roles.view']))
                        <li>
                            <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-user"></i><span
                                        class="sidebar-mini-hide">Access</span></a>
                            <ul>
                                @can('users.view')
                                    <li>
                                        <a class="{{request()->routeIs('admin.users.*')?'active':''}}"
                                           href="{{route('admin.users.index')}}">User Management</a>
                                    </li>
                                @endcan
                                @can('roles.view')
                                    <li>
                                        <a class="{{request()->routeIs('admin.roles.*')?'active':''}}"
                                           href="{{route('admin.roles.index')}}">Role Management</a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endif
                    @if(auth()->user()->hasRole('super_admin')|| auth()->user()->hasAnyPermission(['posts.view']))
                        <li>
                            <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i
                                        class="si si-book-open"></i><span
                                        class="sidebar-mini-hide">Content Management</span></a>
                            <ul>
                                @can('posts.view')
                                    <li>
                                        <a class="{{request()->routeIs('admin.posts.*')?"active":""}}"
                                           href="{{route('admin.posts.index')}}">Post Management</a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
            <!-- END Side Content -->
        </div>
        <!-- Sidebar Content -->
    </div>
    <!-- END Sidebar Scroll Container -->
</nav>
<!-- END Sidebar -->