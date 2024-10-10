<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>Water Licensing System</title>

    <!-- Custom CSS for Progress Bar -->
    <link href="{{ asset('css/progressbar/progress.css') }}" rel="stylesheet">

    <!-- Vendor CSS -->
    <link href="{{ asset('sbadmin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('sbadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    {{-- Custom css --}}
    
    
    {{-- \css\progressbar\progress.css --}}
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
{{-- for progress bar --}}
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    {{-- toaster --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    {{-- sir adam css --}}
    <link href="bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker.min.css"  rel="stylesheet">
    
{{-- javascripts --}}

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('sbadmin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

   
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <style>
                .sidebar-brand-image {
                    height: 50px;
                    width: 50px;
                }
            </style>
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('dashboard')}}">
                <div class="sidebar-brand-icon">
                    <img class="sidebar-brand-image" src="/images/dohlogo.png" alt="Image is not available" />
                </div>
                <div class="sidebar-brand-text "> <sup>Water Licensing System</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{route('dashboard')}}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                APPLICATIONS
            </div>

            <!-- Nav Item - Pages Collapse Menu -->

            <li class="nav-item">
                <a class="nav-link" href="{{route('Initial')}}">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span>Initial Application</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('operational')}}">
                    <i class="fas fa-fw fa-file-alt "></i>
                    <span>Operational Application</span></a>
            </li>


            

          

            <!-- Divider -->
            <hr class="sidebar-divider">
{{-- ------------------reports---------------------- --}}
            <!-- Heading -->
            <div class="sidebar-heading">
                Transactions
            </div>
                {{-- initial and operational --}}

                <li class="nav-item">
                    <a class="nav-link" href="{{route('initialtransact')}}">
                        <i class="fas fa-fw fa-tasks"></i>
                        <span>Initial Transactions</span></a>
                </li>
    
                <li class="nav-item">
                    <a class="nav-link" href="{{route('operationaltransact')}}">
                        <i class="fas fa-fw fa-tasks"></i>
                        <span>Operational Transactions</span></a>
                </li>

                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{route('operationaltransact')}}">
                        <i class="fas fa-fw fa-tasks"></i>
                        <span>Inspector</span></a>
                </li> --}}
                {{-- inspector --}}
            @if(auth()->user()->role_id === 4 || auth()->user()->role_id === 2)

                <li class="nav-item">
                    <a
                        class="nav-link collapsed"
                        href="#"
                        data-toggle="collapse"
                        data-target="#collapseTwo"
                        aria-expanded="true"
                        aria-controls="collapseTwo"
                    >
                        <i class="fas fa-fw fa-cog"></i>
                        <span>List of Inspection</span>
                    </a>
                    <div
                        id="collapseTwo"
                        class="collapse"
                        aria-labelledby="headingTwo"
                        data-parent="#accordionSidebar"
                    >
                        <div class="bg-white py-2 collapse-inner rounded">
                            <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                            <a
                            class="collapse-item"
                            href="inspector"
                            style="
                                background-color: blue;
                                color: white;
                                margin-bottom: 5px;
                            "
                            >Inspection Schedule</a
                        >
                            <a
                                class="collapse-item"
                                href="inspection-not-visited"
                                style="
                                    background-color: green;
                                    color: white;
                                    margin-bottom: 5px;
                                "
                                >Not visited</a
                            >
                            <a
                                class="collapse-item"
                                href="inspection-overdue"
                                style="background-color: red; color: white"
                                >Overdue</a
                            >
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link collapsed"
                        href="#"
                        data-toggle="collapse"
                        data-target="#collapseUtilities"
                        aria-expanded="true"
                        aria-controls="collapseUtilities"
                    >
                        <i class="fas fa-fw fa-wrench"></i>
                        <span>Utilities</span>
                    </a>
                    <div
                        id="collapseUtilities"
                        class="collapse"
                        aria-labelledby="headingUtilities"
                        data-parent="#accordionSidebar"
                    >
                        <div class="bg-white py-2 collapse-inner rounded">
                            <!-- <h6 class="collapse-header">Custom Utilities:</h6> -->
                            <!-- <a
                                class="collapse-item bg-primary"
                                href="utilities-color.html"
                                style="color: white; margin-bottom: 5px"
                                >Inspector's Checklist</a
                            > -->
                            <a
                                class="collapse-item bg-primary"
                                href="/facilities"
                                style="color: white; margin-bottom: 5px"
                                >List of Facilities</a
                            >
                            <!-- <a
                                class="collapse-item bg-primary"
                                href="utilities-color.html"
                                style="color: white; margin-bottom: 5px"
                                >List of Applicants</a
                            > -->
                            <!-- <a
                                class="collapse-item bg-primary"
                                href="utilities-color.html"
                                style="color: white"
                                >Statistics</a
                            > -->
                            <!-- <a class="collapse-item" href="utilities-border.html">Borders</a>
                        <a class="collapse-item" href="utilities-animation.html">Animations</a>
                        <a class="collapse-item" href="utilities-other.html">Other</a> -->
                        </div>
                    </div>
                </li>
            @endif
                 <!-- Divider -->
            @if(auth()->user()->role_id === 4)
                 <hr class="sidebar-divider">
            {{-- ------------------reports---------------------- --}}
                        <!-- Heading -->
                        <div class="sidebar-heading">
                            Administrator
                        </div>
                            {{-- initial and operational --}}
            
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('roles.index')}}">
                                    <i class="fas fa-fw fa-users"></i>
                                    <span>User Accounts</span></a>
                            </li>
                            {{-- inspector list --}}
            @endif
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

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

                       
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{auth()->user()->fname}}</span>
                                <img class="img-profile rounded-circle"
                                    src="{{Vite::asset('resources/sbadmin/img/undraw_profile.svg')}}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
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
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
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

                    <!-- Page Heading -->
                    {{-- <h1 class="h3 mb-4 text-gray-800">Blank Page</h1> --}}

                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; DOH ICT 2024</span>
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
                    <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you want to logout?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
                    <a class="btn btn-primary" id="logout-btn" href="{{ route('logout') }}" >Yes</a>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('/sbadmin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/sbadmin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/Progressbar/progress.js') }}"></script>
    <script src="{{ asset('/sbadmin/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('/sbadmin/js/demo/datatables-demo.js')}}"></script>


   

</body>

</html>