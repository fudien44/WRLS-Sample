<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>Water Refilling Licensing System</title>

        <!-- Custom fonts for this template-->
        <link
            href="sbadmin/vendor/fontawesome-free/css/all.min.css"
            rel="stylesheet"
            type="text/css"
        />
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet"
        />

        <!-- Custom styles for this template-->
        <link href="sbadmin/css/sb-admin-2.min.css" rel="stylesheet" />

        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
            crossorigin="anonymous"
        />
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        />

        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.css"
            rel="stylesheet"
            crossorigin="anonymous"
        />

        {{-- Custom styles for the content --}}
        <link href="/css/default.css" rel="stylesheet" />

        {{-- jquery script --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        {{-- For CSRF Compliancy with Laravel --}}
        <script>
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });
        </script>

        <link
            rel="stylesheet"
            href="//cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css"
        />
    </head>

    <body id="page-top">
        <!-- Page Wrapper -->
        <div id="wrapper">
            <!-- Sidebar -->
            <ul
                class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
                id="accordionSidebar"
            >
                <!-- Sidebar - Brand -->
                <div
                    style="
                        text-align: center;
                        color: white;
                        font-family: Arial, Helvetica, sans-serif;
                        font-weight: bold;
                        margin-top: 10px;
                        font-size: x-large;
                    "
                >
                    <i class="fa fa-tint" aria-hidden="true"></i>
                    Water Refilling Licensing System
                </div>

                <!-- Divider -->
                <hr class="sidebar-divider my-0" />

                <!-- Nav Item - Dashboard -->
                <li class="nav-item active">
                    <a class="nav-link" href="inspector">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a
                    >
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider" />

                <!-- Heading -->
                <div class="sidebar-heading">Miscellaneous</div>

                <!-- Nav Item - Pages Collapse Menu -->
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

                <!-- Nav Item - Utilities Collapse Menu -->
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

                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block" />

                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button
                        class="rounded-circle border-0"
                        id="sidebarToggle"
                    ></button>
                </div>
            </ul>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <!-- Topbar -->
                    <nav
                        class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"
                    >
                        <!-- Sidebar Toggle (Topbar) -->
                        <button
                            id="sidebarToggleTop"
                            class="btn btn-link d-md-none rounded-circle mr-3"
                        >
                            <i class="fa fa-bars"></i>
                        </button>

                        <!-- Topbar Search -->
                        <!-- <form
                            class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"
                        >
                            <div class="input-group">
                                <input
                                    type="text"
                                    class="form-control bg-light border-0 small"
                                    placeholder="Search for..."
                                    aria-label="Search"
                                    aria-describedby="basic-addon2"
                                />
                                <div class="input-group-append">
                                    <button
                                        class="btn btn-primary"
                                        type="button"
                                    >
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form> -->

                        <!-- Topbar Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                            <li class="nav-item dropdown no-arrow d-sm-none">
                                <a
                                    class="nav-link dropdown-toggle"
                                    href="#"
                                    id="searchDropdown"
                                    role="button"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                >
                                    <i class="fas fa-search fa-fw"></i>
                                </a>
                                <!-- Dropdown - Messages -->
                                <div
                                    class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                    aria-labelledby="searchDropdown"
                                >
                                    <form
                                        class="form-inline mr-auto w-100 navbar-search"
                                    >
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                class="form-control bg-light border-0 small"
                                                placeholder="Search for..."
                                                aria-label="Search"
                                                aria-describedby="basic-addon2"
                                            />
                                            <div class="input-group-append">
                                                <button
                                                    class="btn btn-primary"
                                                    type="button"
                                                >
                                                    <i
                                                        class="fas fa-search fa-sm"
                                                    ></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </li>

                            <!-- Nav Item - Alerts -->
                            <li class="nav-item dropdown no-arrow mx-1">
                                <a
                                    class="nav-link dropdown-toggle"
                                    href="#"
                                    id="alertsDropdown"
                                    role="button"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                >
                                    <i class="fas fa-bell fa-fw"></i>
                                    <!-- Counter - Alerts -->
                                    <span
                                        class="badge badge-danger badge-counter"
                                        >0</span
                                    >
                                </a>
                                <!-- Dropdown - Alerts -->
                                <div
                                    class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="alertsDropdown"
                                >
                                    <h6 class="dropdown-header">
                                        Alerts Center
                                    </h6>

                                    <!-- Limit alerts to be viewed by three -->
                                    <a
                                        id="notification-icon"
                                        class="dropdown-item d-flex align-items-center"
                                        href="#"
                                        style="
                                            max-height: auto;
                                            overflow-y: auto;
                                        "
                                    >
                                        <span
                                            id="notification-list"
                                            style="
                                                text-align: center;
                                                width: 100%;
                                            "
                                        >
                                            <div>
                                                <center>
                                                    <div>
                                                        <div
                                                            class="icon-circle bg-primary"
                                                        >
                                                            <i
                                                                class="bi bi-building"
                                                                style="
                                                                    color: white;
                                                                    font-size: x-large;
                                                                "
                                                            ></i>
                                                        </div>
                                                    </div>
                                                </center>
                                                <div id="countdown-list">
                                                    <b
                                                        >No facilities pending
                                                        for inspection:</b
                                                    >
                                                </div>

                                                <br />
                                                <center>
                                                    <div>
                                                        <div
                                                            class="icon-circle badge-danger"
                                                        >
                                                            <i
                                                                class="bi bi-building-fill-exclamation"
                                                                style="
                                                                    font-size: x-large;
                                                                "
                                                            ></i>
                                                        </div>
                                                    </div>
                                                </center>
                                                <div id="overdue-list">
                                                    <b
                                                        >No facilities overdue
                                                        for inspection:</b
                                                    >
                                                </div>
                                            </div>
                                        </span>
                                    </a>
                                    <!-- View all alert -->
                                    <a
                                        class="dropdown-item text-center small text-gray-500"
                                        href="#"
                                        >Show All Alerts</a
                                    >
                                </div>
                            </li>

                            <div class="topbar-divider d-none d-sm-block"></div>

                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a
                                    class="nav-link dropdown-toggle"
                                    href="#"
                                    id="userDropdown"
                                    role="button"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                >
                                    <span
                                        class="mr-2 d-none d-lg-inline text-gray-600 small"
                                        >Douglas McGee</span
                                    >
                                    <img
                                        class="img-profile rounded-circle"
                                        src="sbadmin/img/undraw_profile.svg"
                                    />
                                </a>
                                <!-- Dropdown - User Information -->
                                <div
                                    class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="userDropdown"
                                >
                                    <a class="dropdown-item" href="#">
                                        <i
                                            class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"
                                        ></i>
                                        Profile
                                    </a>
                                    <!-- <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a> -->
                                    <div class="dropdown-divider"></div>
                                    <a
                                        class="dropdown-item"
                                        href="#"
                                        data-toggle="modal"
                                        data-target="#logoutModal"
                                    >
                                        <i
                                            class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"
                                        ></i>
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

                        @yield('content')
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container justify-content-center">
                        <div class="copyright text-center my-auto">
                            <h6 style="color: black; text-align: center">
                                Made by DOH 12 ICT Unit
                            </h6>
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
        <div
            class="modal fade"
            id="logoutModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Ready to Leave?
                        </h5>
                        <button
                            class="close"
                            type="button"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Select "Logout" below if you are ready to end your
                        current session.
                    </div>
                    <div class="modal-footer">
                        <button
                            class="btn btn-secondary"
                            type="button"
                            data-dismiss="modal"
                        >
                            Cancel
                        </button>
                        <a class="btn btn-primary" href="/">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Script for showing the alerts -->

        <script>
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });

            $countdowns = [];
            $overdues = [];

            // start = new Date();

            // setInterval(function () {
            //     $(".Timer").text((new Date() - start) / 1000 + " Seconds");
            //     $.ajax({
            //         type: "GET",
            //         dataType: "json",
            //         url: "/get-alerts",
            //         success: function (responses) {
            //             if ($countdowns.length != responses.countdowns.length) {
            //                 $countdowns = responses.countdowns;

            //                 $(".badge.badge-danger.badge-counter").html(
            //                     "" + responses.countdowns.length + ""
            //                 );

            //                 if ($countdowns.length != 0) {
            //                     $("#countdown-list").html(
            //                         "<div id='countdown-list'><b>Facilities pending for inspection:</b></div>"
            //                     );
            //                 }

            //                 jQuery.each($countdowns, (index, item) => {
            //                     item.countdownDays =
            //                         Number(item.countdownDays) == 0
            //                             ? "Today"
            //                             : item.countdownDays;
            //                     $("#countdown-list").append(
            //                         "<hr/><div class='small text-gray-500'></div><span>Inspection ID: <b>" +
            //                             item.inspection_id +
            //                             "</b></span>" +
            //                             "<div class='small text-gray-500'></div><span>Inspection Date: <b>" +
            //                             item.date_inspection +
            //                             "</b></span>" +
            //                             "<div class='small text-gray-500'></div><span>Days until inspection: <b>" +
            //                             item.countdownDays +
            //                             "</b></span>" +
            //                             "<div class='small text-gray-500'></div><span>Facility Name: <b>" +
            //                             item.facility_name +
            //                             "</b></span>" +
            //                             "<div class='small text-gray-500'></div><span>Facility Address: <b>" +
            //                             item.address +
            //                             "</b></span>" +
            //                             "<div class='small text-gray-500'></div><span>Facility Owner: <b>" +
            //                             item.owner +
            //                             "</b></span>" +
            //                             "<div class='small text-gray-500'></div><span>Client: <b>" +
            //                             item.client +
            //                             "</b></span>"
            //                     );
            //                 });
            //             }
            //             if ($overdues.length != responses.overdues.length) {
            //                 $overdues = responses.overdues;

            //                 // if ($overdues.length == 0) {
            //                 //     $("#notification-list").append(
            //                 //         "<br/><center><div><div class='icon-circle badge-danger'><i class='bi bi-building-fill-exclamation' style='font-size: x-large'></i></div></div></center>" +
            //                 //             "<div id='overdue-list'><b>No facilities overdue for inspection:</b></div>"
            //                 //     );
            //                 // } else {
            //                 //     $("#notification-list").append(
            //                 //         "<br/><center><div><div class='icon-circle badge-danger'><i class='bi bi-building-fill-exclamation' style='font-size: x-large'></i></div></div></center>" +
            //                 //             "<div id='overdue-list'><b>Facilities overdue for inspection:</b></div>" +
            //                 //             "<div id='overdue-10'><b>Overdue for 10 or more days:</b></div>" +
            //                 //             "<div id='overdue-15'><b>Overdue for 15 or more days:</b></div>" +
            //                 //             "<div id='overdue-17'><b>Overdue for 17 or more days:</b></div>" +
            //                 //             "<div id='overdue-20'><b>Overdue for 20 or more days:</b></div>"
            //                 //     );
            //                 // }

            //                 if ($overdues.length != 0) {
            //                     $("#overdue-list").html(
            //                         "<div id='overdue-list'><b>Facilities overdue for inspection:</b></div>" +
            //                             "<div id='overdue-10'><b>Overdue for 10 or more days:</b></div>" +
            //                             "<br/><div id='overdue-15'><b>Overdue for 15 or more days:</b></div>" +
            //                             "<br/><div id='overdue-17'><b>Overdue for 17 or more days:</b></div>" +
            //                             "<br/><div id='overdue-20'><b>Overdue for 20 or more days:</b></div>"
            //                     );
            //                 }

            //                 $("#overdue-10").hide();
            //                 $("#overdue-15").hide();
            //                 $("#overdue-17").hide();
            //                 $("#overdue-20").hide();

            //                 jQuery.each($overdues, (index, item) => {
            //                     if (
            //                         item.overdueDays >= 10 &&
            //                         item.overdueDays < 15
            //                     ) {
            //                         $("#overdue-10").show();
            //                         $badgeCount =
            //                             Number(
            //                                 $(
            //                                     ".badge.badge-danger.badge-counter"
            //                                 ).text()
            //                             ) + 1;
            //                         $(".badge.badge-danger.badge-counter").html(
            //                             "" + $badgeCount + ""
            //                         );
            //                         $("#overdue-10").append(
            //                             "<hr/>" +
            //                                 "<div class='small text-gray-500'></div><span>Inspection ID: <b>" +
            //                                 item.inspection_id +
            //                                 "</b></span>" +
            //                                 "<div class='small text-gray-500'></div><span>Inspection Date: <b>" +
            //                                 item.date_inspection +
            //                                 "</b></span>" +
            //                                 "<div class='small text-gray-500'></div><span>Days overdue: <b>" +
            //                                 item.overdueDays +
            //                                 "</b></span>" +
            //                                 "<div class='small text-gray-500'></div><span>Facility Name: <b>" +
            //                                 item.facility_name +
            //                                 "</b></span>" +
            //                                 "<div class='small text-gray-500'></div><span>Facility Address: <b>" +
            //                                 item.address +
            //                                 "</b></span>" +
            //                                 "<div class='small text-gray-500'></div><span>Facility Owner: <b>" +
            //                                 item.owner +
            //                                 "</b></span>" +
            //                                 "<div class='small text-gray-500'></div><span>Client: <b>" +
            //                                 item.client +
            //                                 "</b></span>"
            //                         );
            //                     }
            //                     if (
            //                         item.overdueDays >= 15 &&
            //                         item.overdueDays < 17
            //                     ) {
            //                         $("#overdue-15").show();
            //                         $badgeCount =
            //                             Number(
            //                                 $(
            //                                     ".badge.badge-danger.badge-counter"
            //                                 ).text()
            //                             ) + 1;
            //                         $(".badge.badge-danger.badge-counter").html(
            //                             "" + $badgeCount + ""
            //                         );
            //                         $("#overdue-15").append(
            //                             "<hr/>" +
            //                                 "<div class='small text-gray-500'></div><span>Inspection ID: <b>" +
            //                                 item.inspection_id +
            //                                 "</b></span>" +
            //                                 "<div class='small text-gray-500'></div><span>Inspection Date: <b>" +
            //                                 item.date_inspection +
            //                                 "</b></span>" +
            //                                 "<div class='small text-gray-500'></div><span>Days overdue: <b>" +
            //                                 item.overdueDays +
            //                                 "</b></span>" +
            //                                 "<div class='small text-gray-500'></div><span>Facility Name: <b>" +
            //                                 item.facility_name +
            //                                 "</b></span>" +
            //                                 "<div class='small text-gray-500'></div><span>Facility Address: <b>" +
            //                                 item.address +
            //                                 "</b></span>" +
            //                                 "<div class='small text-gray-500'></div><span>Facility Owner: <b>" +
            //                                 item.owner +
            //                                 "</b></span>" +
            //                                 "<div class='small text-gray-500'></div><span>Client: <b>" +
            //                                 item.client +
            //                                 "</b></span>"
            //                         );
            //                     }
            //                     if (
            //                         item.overdueDays >= 17 &&
            //                         item.overdueDays < 20
            //                     ) {
            //                         $("#overdue-17").show();
            //                         $badgeCount =
            //                             Number(
            //                                 $(
            //                                     ".badge.badge-danger.badge-counter"
            //                                 ).text()
            //                             ) + 1;
            //                         $(".badge.badge-danger.badge-counter").html(
            //                             "" + $badgeCount + ""
            //                         );
            //                         $("#overdue-17").append(
            //                             "<hr/>" +
            //                                 "<div class='small text-gray-500'></div><span>Inspection ID: <b>" +
            //                                 item.inspection_id +
            //                                 "</b></span>" +
            //                                 "<div class='small text-gray-500'></div><span>Inspection Date: <b>" +
            //                                 item.date_inspection +
            //                                 "</b></span>" +
            //                                 "<div class='small text-gray-500'></div><span>Days overdue: <b>" +
            //                                 item.overdueDays +
            //                                 "</b></span>" +
            //                                 "<div class='small text-gray-500'></div><span>Facility Name: <b>" +
            //                                 item.facility_name +
            //                                 "</b></span>" +
            //                                 "<div class='small text-gray-500'></div><span>Facility Address: <b>" +
            //                                 item.address +
            //                                 "</b></span>" +
            //                                 "<div class='small text-gray-500'></div><span>Facility Owner: <b>" +
            //                                 item.owner +
            //                                 "</b></span>" +
            //                                 "<div class='small text-gray-500'></div><span>Client: <b>" +
            //                                 item.client +
            //                                 "</b></span>"
            //                         );
            //                     }
            //                     if (item.overdueDays >= 20) {
            //                         $("#overdue-20").show();
            //                         $badgeCount =
            //                             Number(
            //                                 $(
            //                                     ".badge.badge-danger.badge-counter"
            //                                 ).text()
            //                             ) + 1;
            //                         $(".badge.badge-danger.badge-counter").html(
            //                             "" + $badgeCount + ""
            //                         );
            //                         $("#overdue-20").append(
            //                             "<hr/>" +
            //                                 "<div class='small text-gray-500'></div><span>Inspection ID: <b>" +
            //                                 item.inspection_id +
            //                                 "</b></span>" +
            //                                 "<div class='small text-gray-500'></div><span>Inspection Date: <b>" +
            //                                 item.date_inspection +
            //                                 "</b></span>" +
            //                                 "<div class='small text-gray-500'></div><span>Days overdue: <b>" +
            //                                 item.overdueDays +
            //                                 "</b></span>" +
            //                                 "<div class='small text-gray-500'></div><span>Facility Name: <b>" +
            //                                 item.facility_name +
            //                                 "</b></span>" +
            //                                 "<div class='small text-gray-500'></div><span>Facility Address: <b>" +
            //                                 item.address +
            //                                 "</b></span>" +
            //                                 "<div class='small text-gray-500'></div><span>Facility Owner: <b>" +
            //                                 item.owner +
            //                                 "</b></span>" +
            //                                 "<div class='small text-gray-500'></div><span>Client: <b>" +
            //                                 item.client +
            //                                 "</b></span>"
            //                         );
            //                     }
            //                 });
            //             }
            //         },
            //     });
            // }, 1000);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/get-alerts",
                success: function (responses) {
                    if ($countdowns.length != responses.countdowns.length) {
                        $countdowns = responses.countdowns;

                        $(".badge.badge-danger.badge-counter").html(
                            "" + responses.countdowns.length + ""
                        );

                        if ($countdowns.length != 0) {
                            $("#countdown-list").html(
                                "<div id='countdown-list'><b>Facilities pending for inspection:</b></div>"
                            );
                        }

                        jQuery.each($countdowns, (index, item) => {
                            $("#countdown-list").append(
                                "<hr/><div class='small text-gray-500'></div><span>Inspection ID: <b>" +
                                    item.inspection_id +
                                    "</b></span>" +
                                    "<div class='small text-gray-500'></div><span>Inspection Date: <b>" +
                                    item.date_inspection +
                                    "</b></span>" +
                                    "<div class='small text-gray-500'></div><span>Days until inspection: <b>" +
                                    item.countdownDays +
                                    "</b></span>" +
                                    "<div class='small text-gray-500'></div><span>Facility Name: <b>" +
                                    item.facility_name +
                                    "</b></span>" +
                                    "<div class='small text-gray-500'></div><span>Facility Address: <b>" +
                                    item.address +
                                    "</b></span>" +
                                    "<div class='small text-gray-500'></div><span>Facility Owner: <b>" +
                                    item.owner +
                                    "</b></span>" +
                                    "<div class='small text-gray-500'></div><span>Client: <b>" +
                                    item.client +
                                    "</b></span>"
                            );
                        });
                    }
                    if ($overdues.length != responses.overdues.length) {
                        $overdues = responses.overdues;

                        // if ($overdues.length == 0) {
                        //     $("#notification-list").append(
                        //         "<br/><center><div><div class='icon-circle badge-danger'><i class='bi bi-building-fill-exclamation' style='font-size: x-large'></i></div></div></center>" +
                        //             "<div id='overdue-list'><b>No facilities overdue for inspection:</b></div>"
                        //     );
                        // } else {
                        //     $("#notification-list").append(
                        //         "<br/><center><div><div class='icon-circle badge-danger'><i class='bi bi-building-fill-exclamation' style='font-size: x-large'></i></div></div></center>" +
                        //             "<div id='overdue-list'><b>Facilities overdue for inspection:</b></div>" +
                        //             "<div id='overdue-10'><b>Overdue for 10 or more days:</b></div>" +
                        //             "<div id='overdue-15'><b>Overdue for 15 or more days:</b></div>" +
                        //             "<div id='overdue-17'><b>Overdue for 17 or more days:</b></div>" +
                        //             "<div id='overdue-20'><b>Overdue for 20 or more days:</b></div>"
                        //     );
                        // }

                        if ($overdues.length != 0) {
                            $("#overdue-list").html(
                                "<div id='overdue-list'><b>Facilities overdue for inspection:</b></div>" +
                                    "<div id='overdue-10'><b>Overdue for 10 or more days:</b></div>" +
                                    "<br/><div id='overdue-15'><b>Overdue for 15 or more days:</b></div>" +
                                    "<br/><div id='overdue-17'><b>Overdue for 17 or more days:</b></div>" +
                                    "<br/><div id='overdue-20'><b>Overdue for 20 or more days:</b></div>"
                            );
                        }

                        $("#overdue-10").hide();
                        $("#overdue-15").hide();
                        $("#overdue-17").hide();
                        $("#overdue-20").hide();

                        jQuery.each($overdues, (index, item) => {
                            console.log(item)
                            if (
                                item.overdueDays >= 10 &&
                                item.overdueDays < 15
                            ) {
                                $("#overdue-10").show();
                                $badgeCount =
                                    Number(
                                        $(
                                            ".badge.badge-danger.badge-counter"
                                        ).text()
                                    ) + 1;
                                $(".badge.badge-danger.badge-counter").html(
                                    "" + $badgeCount + ""
                                );
                                $("#overdue-10").append(
                                    "<hr/>" +
                                        "<div class='small text-gray-500'></div><span>Inspection ID: <b>" +
                                        item.inspection_id +
                                        "</b></span>" +
                                        "<div class='small text-gray-500'></div><span>Inspection Date: <b>" +
                                        item.date_inspection +
                                        "</b></span>" +
                                        "<div class='small text-gray-500'></div><span>Days overdue: <b>" +
                                        item.overdueDays +
                                        "</b></span>" +
                                        "<div class='small text-gray-500'></div><span>Facility Name: <b>" +
                                        item.facility_name +
                                        "</b></span>" +
                                        "<div class='small text-gray-500'></div><span>Facility Address: <b>" +
                                        item.address +
                                        "</b></span>" +
                                        "<div class='small text-gray-500'></div><span>Facility Owner: <b>" +
                                        item.owner +
                                        "</b></span>" +
                                        "<div class='small text-gray-500'></div><span>Client: <b>" +
                                        item.client +
                                        "</b></span>"
                                );
                            }
                            if (
                                item.overdueDays >= 15 &&
                                item.overdueDays < 17
                            ) {
                                $("#overdue-15").show();
                                $badgeCount =
                                    Number(
                                        $(
                                            ".badge.badge-danger.badge-counter"
                                        ).text()
                                    ) + 1;
                                $(".badge.badge-danger.badge-counter").html(
                                    "" + $badgeCount + ""
                                );
                                $("#overdue-15").append(
                                    "<hr/>" +
                                        "<div class='small text-gray-500'></div><span>Inspection ID: <b>" +
                                        item.inspection_id +
                                        "</b></span>" +
                                        "<div class='small text-gray-500'></div><span>Inspection Date: <b>" +
                                        item.date_inspection +
                                        "</b></span>" +
                                        "<div class='small text-gray-500'></div><span>Days overdue: <b>" +
                                        item.overdueDays +
                                        "</b></span>" +
                                        "<div class='small text-gray-500'></div><span>Facility Name: <b>" +
                                        item.facility_name +
                                        "</b></span>" +
                                        "<div class='small text-gray-500'></div><span>Facility Address: <b>" +
                                        item.address +
                                        "</b></span>" +
                                        "<div class='small text-gray-500'></div><span>Facility Owner: <b>" +
                                        item.owner +
                                        "</b></span>" +
                                        "<div class='small text-gray-500'></div><span>Client: <b>" +
                                        item.client +
                                        "</b></span>"
                                );
                            }
                            if (
                                item.overdueDays >= 17 &&
                                item.overdueDays < 20
                            ) {
                                $("#overdue-17").show();
                                $badgeCount =
                                    Number(
                                        $(
                                            ".badge.badge-danger.badge-counter"
                                        ).text()
                                    ) + 1;
                                $(".badge.badge-danger.badge-counter").html(
                                    "" + $badgeCount + ""
                                );
                                $("#overdue-17").append(
                                    "<hr/>" +
                                        "<div class='small text-gray-500'></div><span>Inspection ID: <b>" +
                                        item.inspection_id +
                                        "</b></span>" +
                                        "<div class='small text-gray-500'></div><span>Inspection Date: <b>" +
                                        item.date_inspection +
                                        "</b></span>" +
                                        "<div class='small text-gray-500'></div><span>Days overdue: <b>" +
                                        item.overdueDays +
                                        "</b></span>" +
                                        "<div class='small text-gray-500'></div><span>Facility Name: <b>" +
                                        item.facility_name +
                                        "</b></span>" +
                                        "<div class='small text-gray-500'></div><span>Facility Address: <b>" +
                                        item.address +
                                        "</b></span>" +
                                        "<div class='small text-gray-500'></div><span>Facility Owner: <b>" +
                                        item.owner +
                                        "</b></span>" +
                                        "<div class='small text-gray-500'></div><span>Client: <b>" +
                                        item.client +
                                        "</b></span>"
                                );
                            }
                            if (item.overdueDays >= 20) {
                                $("#overdue-20").show();
                                $badgeCount =
                                    Number(
                                        $(
                                            ".badge.badge-danger.badge-counter"
                                        ).text()
                                    ) + 1;
                                $(".badge.badge-danger.badge-counter").html(
                                    "" + $badgeCount + ""
                                );
                                $("#overdue-20").append(
                                    "<hr/>" +
                                        "<div class='small text-gray-500'></div><span>Inspection ID: <b>" +
                                        item.inspection_id +
                                        "</b></span>" +
                                        "<div class='small text-gray-500'></div><span>Inspection Date: <b>" +
                                        item.date_inspection +
                                        "</b></span>" +
                                        "<div class='small text-gray-500'></div><span>Days overdue: <b>" +
                                        item.overdueDays +
                                        "</b></span>" +
                                        "<div class='small text-gray-500'></div><span>Facility Name: <b>" +
                                        item.facility_name +
                                        "</b></span>" +
                                        "<div class='small text-gray-500'></div><span>Facility Address: <b>" +
                                        item.address +
                                        "</b></span>" +
                                        "<div class='small text-gray-500'></div><span>Facility Owner: <b>" +
                                        item.owner +
                                        "</b></span>" +
                                        "<div class='small text-gray-500'></div><span>Client: <b>" +
                                        item.client +
                                        "</b></span>"
                                );
                            }
                        });
                    }
                },
            });
        </script>

        <!-- Bootstrap core JavaScript-->
        <script src="sbadmin/vendor/jquery/jquery.min.js"></script>
        <script src="sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="sbadmin/js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        {{--
        <script src="sbadmin/vendor/chart.js/Chart.min.js"></script>
        --}}

        <!-- Page level custom scripts -->
        {{--
        <script src="sbadmin/js/demo/chart-area-demo.js"></script>
        --}} {{--
        <script src="sbadmin/js/demo/chart-pie-demo.js"></script>
        --}}

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"
        ></script>

        <script src="//cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>

        <!-- JQuery plugin for validation -->
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>

        {{--
        <script>
            let table = new DataTable("#initappTable");
        </script>
        --}}
    </body>
</html>
