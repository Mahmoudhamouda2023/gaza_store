<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title', env('APP_NAME'))</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('back/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('back/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        /* ===== DARK MODE STYLES ===== */
        body.dark-mode {
            background-color: #1a1a2e !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode #wrapper {
            background-color: #1a1a2e;
        }

        /* Sidebar */
        body.dark-mode .sidebar {
            background: linear-gradient(180deg, #0d0d1a 10%, #1a1a2e 100%) !important;
        }

        /* Topbar */
        body.dark-mode .topbar {
            background-color: #16213e !important;
        }

        body.dark-mode .navbar-nav .nav-link {
            color: #c0c0c0 !important;
        }

        body.dark-mode .text-gray-600 {
            color: #b0b0b0 !important;
        }

        /* Content Wrapper */
        body.dark-mode #content-wrapper {
            background-color: #1a1a2e !important;
        }

        /* Cards */
        body.dark-mode .card {
            background-color: #16213e !important;
            border-color: #2a2a4a !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .card-header {
            background-color: #0f3460 !important;
            border-bottom-color: #2a2a4a !important;
            color: #e0e0e0 !important;
        }

        /* Tables */
        body.dark-mode .table {
            color: #e0e0e0 !important;
        }

        body.dark-mode .table thead th {
            border-bottom-color: #2a2a4a !important;
            background-color: #0f3460 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .table td,
        body.dark-mode .table th {
            border-top-color: #2a2a4a !important;
        }

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

        /* Footer */
        body.dark-mode .sticky-footer {
            background-color: #16213e !important;
            color: #b0b0b0 !important;
        }

        /* Dropdowns */
        body.dark-mode .dropdown-menu {
            background-color: #16213e !important;
            border-color: #2a2a4a !important;
        }

        body.dark-mode .dropdown-item {
            color: #c0c0c0 !important;
        }

        body.dark-mode .dropdown-item:hover {
            background-color: #0f3460 !important;
            color: #ffffff !important;
        }

        body.dark-mode .dropdown-divider {
            border-top-color: #2a2a4a !important;
        }

        body.dark-mode .dropdown-header {
            background-color: #0f3460 !important;
            color: #c0c0c0 !important;
        }

        /* Forms */
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

        /* Modals */
        body.dark-mode .modal-content {
            background-color: #16213e !important;
            border-color: #2a2a4a !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .modal-header {
            border-bottom-color: #2a2a4a !important;
        }

        body.dark-mode .modal-footer {
            border-top-color: #2a2a4a !important;
        }

        body.dark-mode .close {
            color: #e0e0e0 !important;
        }

        /* Divider */
        body.dark-mode .topbar-divider {
            border-right-color: #2a2a4a !important;
        }

        /* Scroll to top button */
        body.dark-mode .scroll-to-top {
            background-color: #4a90e2 !important;
        }

        /* ===== TOGGLE BUTTON STYLES ===== */
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
    </style>

    @yield('css')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('admin.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <div class="language-selector">
                            <select id="languageDropdown">
                                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    <option
                                        value="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                        {{ $properties['native'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- ===== DARK MODE TOGGLE ===== -->
                        <li class="nav-item d-flex align-items-center">
                            <button id="darkModeToggle" title="Toggle Dark/Light Mode">
                                <i class="toggle-icon fas fa-moon"></i>
                            </button>
                        </li>
                        <!-- ===== END DARK MODE TOGGLE ===== -->

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                {{-- <span class="badge badge-danger badge-counter">{{ Auth::User()->unreadnotifications->count() }}</span> --}}
                                @php
                                    $count = Auth::user()->unreadNotifications->count();
                                @endphp

                                @if ($count != 0)
                                    <span class="badge badge-danger badge-counter">
                                        @php
                                            if ($count > 5) {
                                                echo '5+';
                                            } else {
                                                echo $count;
                                            }
                                        @endphp
                                    </span>
                                @endif
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Notification Center
                                </h6>
                                @foreach (Auth::User()->notifications()->take(5)->get() as $item)
                                    <a class="dropdown-item d-flex align-items-center {{ $item->read_at ? '' : 'bg-light' }}"
                                        href="{{ $item->data['url'] }}?id={{ $item->id }}">

                                        <div>
                                            <div class="small text-gray-500">{{ $item->created_at->format('F d,Y') }}
                                            </div>
                                            <span class="font-weight-bold">{{ $item->data['msg'] }}</span>
                                        </div>
                                    </a>
                                @endforeach

                                <a class="dropdown-item text-center small text-gray-500"
                                    href="{{ route('admin.notifications') }}">Show All
                                    Alerts</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @php
                                    if (Auth::user()->image) {
                                        // $src = asset('images/' . Auth::user()->image->path);
                                        $src = asset('images/' . Auth::user()->image->path);
                                    } else {
                                        # code...

                                        $src =
                                            'https://ui-avatars.com/api/?background=random&name=' . Auth::user()->name;
                                    }
                                @endphp
                                <img class="img-profile rounded-circle" src="{{ $src }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                {{-- <a href="{{ route('admin.profile') }}">Profile</a> --}}
                                <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                {{-- <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button>{{ __('admin.out') }}</button>
                                </form> --}}

                                {{-- كود جديد --}}
                                <a class="dropdown-item" href="#"
                                    onclick="document.getElementById('logout-form').submit()">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{ __('admin.out') }}
                                </a>





                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @yield('content')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('back/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('back/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('back/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('back/js/sb-admin-2.min.js') }}"></script>

    <!-- ===== DARK MODE SCRIPT ===== -->
    <script>
        (function() {
            const toggle = document.getElementById('darkModeToggle');
            const icon = toggle.querySelector('.toggle-icon');
            const body = document.body;

            // Load saved preference from localStorage
            if (localStorage.getItem('darkMode') === 'enabled') {
                body.classList.add('dark-mode');
                icon.classList.replace('fa-moon', 'fa-sun');
            }

            toggle.addEventListener('click', function() {
                if (body.classList.contains('dark-mode')) {
                    body.classList.remove('dark-mode');
                    icon.classList.replace('fa-sun', 'fa-moon');
                    localStorage.setItem('darkMode', 'disabled');
                } else {
                    body.classList.add('dark-mode');
                    icon.classList.replace('fa-moon', 'fa-sun');
                    localStorage.setItem('darkMode', 'enabled');
                }
            });
        })();
    </script>
    <!-- ===== END DARK MODE SCRIPT ===== -->

    @yield('js')

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">
        @csrf
    </form>
</body>

</html>
