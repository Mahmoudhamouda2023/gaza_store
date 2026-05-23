<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title', env('APP_NAME'))</title>

    <link href="{{ asset('back/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

    <link href="{{ asset('back/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        body.dark-mode {
            background-color: #1a1a2e !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode #wrapper,
        body.dark-mode #content-wrapper {
            background-color: #1a1a2e !important;
        }

        body.dark-mode .sidebar {
            background: linear-gradient(180deg, #0d0d1a 10%, #1a1a2e 100%) !important;
        }

        body.dark-mode .topbar,
        body.dark-mode .sticky-footer {
            background-color: #16213e !important;
            color: #b0b0b0 !important;
        }

        body.dark-mode .navbar-nav .nav-link,
        body.dark-mode .text-gray-600 {
            color: #b0b0b0 !important;
        }

        body.dark-mode .card,
        body.dark-mode .modal-content,
        body.dark-mode .dropdown-menu {
            background-color: #16213e !important;
            border-color: #2a2a4a !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .card-header,
        body.dark-mode .table thead th,
        body.dark-mode .dropdown-header {
            background-color: #0f3460 !important;
            border-color: #2a2a4a !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .table {
            color: #e0e0e0 !important;
        }

        body.dark-mode .table td,
        body.dark-mode .table th,
        body.dark-mode .table-bordered td,
        body.dark-mode .table-bordered th {
            border-color: #2a2a4a !important;
        }

        body.dark-mode .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.05) !important;
        }

        body.dark-mode .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.08) !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .dropdown-item {
            color: #c0c0c0 !important;
        }

        body.dark-mode .dropdown-item:hover {
            background-color: #0f3460 !important;
            color: #ffffff !important;
        }

        body.dark-mode .form-control {
            background-color: #0f3460 !important;
            border-color: #2a2a4a !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .form-control:focus {
            background-color: #16213e !important;
            border-color: #4a90e2 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .form-control::placeholder {
            color: #7a7a9a !important;
        }

        body.dark-mode .modal-header,
        body.dark-mode .modal-footer,
        body.dark-mode .dropdown-divider {
            border-color: #2a2a4a !important;
        }

        body.dark-mode .close {
            color: #e0e0e0 !important;
        }

        body.dark-mode .scroll-to-top {
            background-color: #4a90e2 !important;
        }

        #darkModeToggle {
            cursor: pointer;
            border: none;
            background: transparent;
            padding: 0 0.5rem;
            display: flex;
            align-items: center;
            font-size: 1.1rem;
            color: #858796;
            transition: color 0.2s;
        }

        #darkModeToggle:hover {
            color: #4a90e2;
        }

        #darkModeToggle .toggle-icon {
            font-size: 1rem;
        }

        .language-selector select {
            min-width: 120px;
            height: 34px;
            border-radius: 6px;
            border: 1px solid #d1d3e2;
            padding: 0 8px;
            color: #6e707e;
            background: #fff;
            outline: none;
        }

        .pagination {
            gap: 6px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .pagination .page-item {
            margin: 0 2px;
        }

        .pagination .page-link {
            width: 36px !important;
            height: 36px !important;
            padding: 0 !important;
            border-radius: 8px !important;
            display: flex !important;
            align-items: center;
            justify-content: center;
            font-size: 14px !important;
            line-height: 1 !important;
        }

        .pagination .page-item svg,
        .pagination svg,
        nav[role="navigation"] svg {
            width: 16px !important;
            height: 16px !important;
            max-width: 16px !important;
            max-height: 16px !important;
        }

        nav[role="navigation"]>div:first-child {
            display: none !important;
        }

        html[dir="rtl"] body {
            font-family: 'Cairo', sans-serif;
            text-align: right;
        }

        html[dir="rtl"] .sidebar,
        html[dir="rtl"] .topbar,
        html[dir="rtl"] .dropdown-menu {
            direction: rtl;
            text-align: right;
        }

        html[dir="rtl"] .sidebar .nav-item .nav-link,
        html[dir="rtl"] .collapse-inner {
            text-align: right;
        }

        html[dir="rtl"] table {
            direction: rtl;
        }

        html[dir="rtl"] .table th,
        html[dir="rtl"] .table td {
            text-align: right !important;
        }

        html[dir="rtl"] .mr-2 {
            margin-right: 0 !important;
            margin-left: .5rem !important;
        }

        html[dir="rtl"] .ml-auto {
            margin-left: unset !important;
            margin-right: auto !important;
        }

        html[dir="rtl"] .dropdown-menu-right {
            right: auto;
            left: 0;
        }

        html[dir="rtl"] .sidebar .nav-link i {
            margin-left: 8px;
            margin-right: 0;
        }

        html[dir="rtl"] .sidebar .nav-item .nav-link[data-toggle="collapse"] {
            display: flex !important;
            align-items: center;
            justify-content: flex-start;
            width: 100%;
        }

        html[dir="rtl"] .sidebar .nav-item .nav-link[data-toggle="collapse"] i {
            flex: 0 0 auto;
            margin-left: 8px;
            margin-right: 0;
        }

        html[dir="rtl"] .sidebar .nav-item .nav-link[data-toggle="collapse"] span {
            flex: 1 1 auto;
        }

        html[dir="rtl"] .sidebar .nav-item .nav-link[data-toggle="collapse"]::after {
            float: none !important;
            position: static !important;
            flex: 0 0 auto;
            margin-right: auto !important;
            margin-left: 0 !important;
            transform: rotate(180deg);
        }

        html[dir="rtl"] .sidebar .nav-item .nav-link[data-toggle="collapse"].collapsed::after {
            transform: rotate(180deg);
        }

        html[dir="rtl"] .card-header,
        html[dir="rtl"] .card-body {
            text-align: right;
        }

        html[dir="rtl"] .btn {
            direction: rtl;
        }
    </style>

    @yield('css')
</head>

<body id="page-top">

    <div id="wrapper">

        @include('admin.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item d-flex align-items-center mx-2">
                            <div class="language-selector">
                                <select id="languageDropdown">
                                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        <option
                                            value="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                                            {{ app()->getLocale() == $localeCode ? 'selected' : '' }}>
                                            {{ $properties['native'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </li>

                        <li class="nav-item d-flex align-items-center">
                            <button id="darkModeToggle" title="Toggle Dark/Light Mode">
                                <i class="toggle-icon fas fa-moon"></i>
                            </button>
                        </li>

                        <li class="nav-item dropdown no-arrow mx-1">

                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                <i class="fas fa-bell fa-fw"></i>

                                @php
                                    $count = Auth::guard('admin')->user()->unreadNotifications->count() ?? 0;
                                @endphp

                                <span class="{{ $count == 0 ? 'd-none' : '' }} badge badge-danger badge-counter"
                                    data-count="{{ $count }}">
                                    {{ $count > 5 ? '5+' : $count }}
                                </span>
                            </a>

                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">

                                <h6 class="dropdown-header">
                                    {{ __('admin.notification_center') }}
                                </h6>

                                @foreach (Auth::guard('admin')->user()->notifications()->take(5)->get() as $item)
                                    <a class="dropdown-item d-flex align-items-center {{ $item->read_at ? '' : 'bg-light' }}"
                                        href="{{ $item->data['url'] }}?id={{ $item->id }}">

                                        <div>
                                            <div class="small text-gray-500">
                                                {{ $item->created_at->format('F d,Y') }}
                                            </div>

                                            <span class="font-weight-bold">
                                                {{ $item->data['msg'] }}
                                            </span>
                                        </div>
                                    </a>
                                @endforeach

                                <a class="dropdown-item text-center small text-gray-500"
                                    href="{{ route('admin.notifications') }}">
                                    {{ __('admin.show_all_alerts') }}
                                </a>

                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item dropdown no-arrow">

                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                @php
                                    $adminUser = Auth::guard('admin')->user();

                                    if ($adminUser && $adminUser->image) {
                                        $src = asset('images/' . $adminUser->image->path);
                                    } else {
                                        $src =
                                            'https://ui-avatars.com/api/?background=random&name=' .
                                            ($adminUser->name ?? 'Admin');
                                    }
                                @endphp

                                <img class="img-profile rounded-circle" src="{{ $src }}">
                            </a>

                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">

                                <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{ __('admin.profile') }}
                                </a>

                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{ __('admin.settings') }}
                                </a>

                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{ __('admin.activity_logs') }}
                                </a>

                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{ __('admin.out') }}
                                </a>

                            </div>
                        </li>

                    </ul>

                </nav>

                <div class="container-fluid">
                    @yield('content')
                </div>

            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>{{ __('admin.copyright') }}</span>
                    </div>
                </div>
            </footer>

        </div>

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="{{ asset('back/vendor/jquery/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('back/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('back/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('back/js/sb-admin-2.min.js') }}"></script>

    <script>
        (function() {
            const languageDropdown = document.getElementById('languageDropdown');

            if (languageDropdown) {
                languageDropdown.addEventListener('change', function() {
                    window.location.href = this.value;
                });
            }
        })();
    </script>

    <script>
        (function() {
            const toggle = document.getElementById('darkModeToggle');

            if (!toggle) {
                return;
            }

            const icon = toggle.querySelector('.toggle-icon');
            const body = document.body;

            if (localStorage.getItem('darkMode') === 'enabled') {
                body.classList.add('dark-mode');

                if (icon) {
                    icon.classList.replace('fa-moon', 'fa-sun');
                }
            }

            toggle.addEventListener('click', function() {
                if (body.classList.contains('dark-mode')) {
                    body.classList.remove('dark-mode');

                    if (icon) {
                        icon.classList.replace('fa-sun', 'fa-moon');
                    }

                    localStorage.setItem('darkMode', 'disabled');
                } else {
                    body.classList.add('dark-mode');

                    if (icon) {
                        icon.classList.replace('fa-moon', 'fa-sun');
                    }

                    localStorage.setItem('darkMode', 'enabled');
                }
            });
        })();
    </script>

    <script>
        window.userId = '{{ Auth::guard('admin')->id() }}';
    </script>

    @vite(['resources/js/app.js'])

    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('js')
</body>

</html>
