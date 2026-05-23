<!-- Sidebar -->

<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-store"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ env('APP_NAME') }}</div>
    </a>

    <hr class="sidebar-divider my-0">

    @can('view dashboard')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.index') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>{{ __('admin.dash') }}</span>
            </a>
        </li>
    @endcan

    <hr class="sidebar-divider">

    <div class="sidebar-heading">{{ __('admin.interface') }}</div>

    <!-- Categories -->
    @if (auth('admin')->user()->can('view categories') || auth('admin')->user()->can('create categories'))
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategory">
                <i class="fas fa-fw fa-tags"></i>
                <span>{{ __('admin.categories') }}</span>
            </a>

            <div id="collapseCategory" class="collapse" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @can('view categories')
                        <a class="collapse-item" href="{{ route('admin.categories.index') }}">
                            {{ __('admin.all_categories') }}
                        </a>
                    @endcan

                    @can('create categories')
                        <a class="collapse-item" href="{{ route('admin.categories.create') }}">
                            {{ __('admin.add_new') }}
                        </a>
                    @endcan
                </div>
            </div>
        </li>
    @endif

    <!-- Products -->
    @if (auth('admin')->user()->can('view products') || auth('admin')->user()->can('create products'))
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProduct">
                <i class="fas fa-fw fa-heart"></i>
                <span>{{ __('admin.products') }}</span>
            </a>

            <div id="collapseProduct" class="collapse" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @can('view products')
                        <a class="collapse-item" href="{{ route('admin.products.index') }}">
                            {{ __('admin.all_products') }}
                        </a>
                    @endcan

                    @can('create products')
                        <a class="collapse-item" href="{{ route('admin.products.create') }}">
                            {{ __('admin.add_new') }}
                        </a>
                    @endcan
                </div>
            </div>
        </li>
    @endif

    <hr class="sidebar-divider my-0">

    @can('view orders')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.orders') }}">
                <i class="fas fa-fw fa-shopping-cart"></i>
                <span>{{ __('admin.orders') }}</span>
            </a>
        </li>
    @endcan

    @can('view payments')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.payments.index') }}">
                <i class="fas fa-fw fa-dollar-sign"></i>
                <span>{{ __('admin.payments') }}</span>
            </a>
        </li>
    @endcan

    @can('view customers')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.customers.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>{{ __('admin.customers') }}</span>
            </a>
        </li>
    @endcan

    <!-- Managers -->
    @if (auth('admin')->user()->can('view managers') || auth('admin')->user()->can('create managers'))
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseManager">
                <i class="fas fa-fw fa-user-tie"></i>
                <span>{{ __('admin.managers') }}</span>
            </a>

            <div id="collapseManager" class="collapse" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @can('view managers')
                        <a class="collapse-item" href="{{ route('admin.managers.index') }}">
                            {{ __('admin.all_managers') }}
                        </a>
                    @endcan

                    @can('create managers')
                        <a class="collapse-item" href="{{ route('admin.managers.create') }}">
                            {{ __('admin.add_new_manager') }}
                        </a>
                    @endcan
                </div>
            </div>
        </li>
    @endif

    <!-- Employees -->
    @if (auth('admin')->user()->can('view employees') || auth('admin')->user()->can('create employees'))
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEmployee">
                <i class="fas fa-fw fa-users-cog"></i>
                <span>{{ __('admin.employees') }}</span>
            </a>

            <div id="collapseEmployee" class="collapse" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @can('view employees')
                        <a class="collapse-item" href="{{ route('admin.employees.index') }}">
                            {{ __('admin.all_employees') }}
                        </a>
                    @endcan

                    @can('create employees')
                        <a class="collapse-item" href="{{ route('admin.employees.create') }}">
                            {{ __('admin.add_new_employee') }}
                        </a>
                    @endcan
                </div>
            </div>
        </li>
    @endif

    @can('view roles')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.roles.index') }}">
                <i class="fas fa-fw fa-lock"></i>
                <span>{{ __('admin.role') }}</span>
            </a>
        </li>
    @endcan
    @role('admin')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.activity.logs') }}">
                <i class="fas fa-history"></i>
                <span>{{ __('admin.activity_logs') }}</span>
            </a>
        </li>
    @endrole

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

<!-- End of Sidebar -->
