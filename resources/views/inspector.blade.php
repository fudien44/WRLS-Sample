@extends('layouts.app') @section('alerts')
<!-- Link for bootstrap-datepicker -->
<link
    rel="stylesheet"
    href="bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker.min.css"
/>

<!-- Limit alerts to be viewed by three -->
<a
    id="notification-icon"
    class="dropdown-item d-flex align-items-center"
    href="#"
>
    <span id="notification-list" style="text-align: center; width: 100%">
        <!-- <center>
            <div>
                <div class="icon-circle bg-primary">
                    <i
                        class="bi bi-building"
                        style="color: white; font-size: x-large"
                    ></i>
                </div>
            </div>
        </center>
        <div id="countdown-list">
            <b>Facilities pending for inspection:</b>
        </div> -->
        <!-- <br />
        <center>
            <div>
                <div class="icon-circle badge-danger">
                    <i
                        class="bi bi-building-fill-exclamation"
                        style="font-size: x-large"
                    ></i>
                </div>
            </div>
        </center>
        <div id="overdue-list">
            <b>Facilities overdue for inspection:</b>
        </div> -->
    </span>
    <!-- <div class="mr-3">
        <div class="icon-circle bg-primary">
            <i class="fas fa-file-alt text-white"></i>
        </div>
    </div> -->
    <!-- <div>
        <div class="small text-gray-500">December 12, 2019</div>
        <span class="font-weight-bold"
            >A new monthly report is ready to download!</span
        >
    </div> -->
</a>
<a class="dropdown-item text-center small text-gray-500" href="#"
    >Show All Alerts</a
>
@endsection @section('content')

<div class="div-content">
    <div class="alert alert-success alert-facility" id="success_message"></div>
    <div
        class="alert alert-danger alert-facility"
        id="updateform_ErrList"
    ></div>

    <!-- Acceptance Confirmation Modal -->
    <div
        class="modal fade"
        id="modalScheduleConfirmation"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        Confirmation
                    </h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you wish to schedule this application?
                    <br /><br />

                    <div class="inspection_type_label">
                        Select the date for inspection:
                    </div>
                    <div
                        class="input-group date"
                        id="scheduledate"
                        data-provide="datepicker"
                    >
                        <input type="text" class="form-control" /><span
                            class="input-group-addon"
                        ></span>
                    </div>

                    <h10
                        >Note: You must include a date for scheduling before you
                        can proceed</h10
                    >

                    <br /><br />
                    <div id="late-submission"><br /></div>
                    <textarea id="reason-late" style="width: 100%"></textarea>
                </div>
                <input type="hidden" id="accept_fac_id" />
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn-cancel btn btn-secondary"
                        data-dismiss="modal"
                        style="width: 25%; height: 50%; margin-top: 10px"
                    >
                        Close
                    </button>
                    <button
                        type="button"
                        type="submit"
                        class="btn-accept btn btn-primary"
                        data-dismiss="modal"
                        style="width: 25%; height: 50%"
                    >
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Rejection Confirmation Modal -->
    <div
        class="modal fade"
        id="modalRejectConfirmation"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        Confirmation
                    </h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you wish to reject this application?
                </div>
                <input type="hidden" id="reject_fac_id" />
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn-cancel btn btn-secondary"
                        data-dismiss="modal"
                        style="width: 25%; height: 50%; margin-top: 10px"
                    >
                        Close
                    </button>
                    <button
                        type="button"
                        type="submit"
                        class="btn-reject btn btn-primary"
                        data-dismiss="modal"
                        style="width: 25%; height: 50%"
                    >
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- View attachment modal -->
    <div
        class="modal fade"
        id="modalViewInitialAttachments"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        Initial Application Attachments:
                    </h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="attach-body modal-body"></div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn-cancel btn btn-secondary"
                        data-dismiss="modal"
                        style="width: 25%; height: 50%; margin-top: 10px"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="table-card">
        <span>
            <h5 class="table-title">List of Facilities to be inspected:</h5>
            <br />

            <div>
                <label>Choose type of transaction:</label>
                <select type="submit" name="apptype" id="apptype">
                    <option value="initapp">Initial Application</option>
                    <option value="opapp">Operational Application</option>
                </select>
            </div>
            <br />
        </span>

        <button
            type="button"
            class="refresh_btn btn btn-primary"
            style="width: fit-content; margin-bottom: 10px"
        >
            Refresh list
        </button>
        {{-- @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif --}}

        <table id="initappTable" class="cell-border stripe" style="width: 100%">
            <thead>
                <tr>
                    <th></th>
                    <th style="text-align: center">Name of Applicant</th>
                    <th style="text-align: center">
                        Name of Retail Water System Or Refiling Station
                    </th>
                    <th style="text-align: center">
                        Date Initial Checking Passed:
                    </th>
                    <th style="text-align: center">Application Status:</th>
                    <th style="text-align: center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <table id="opappTable" class="cell-border stripe" style="width: 100%">
            <thead>
                <tr>
                    <th></th>
                    <th style="text-align: center">Applicant Name</th>
                    <th style="text-align: center">Facility Name</th>
                    <th style="text-align: center">Facility License No:</th>
                    <th style="text-align: center">
                        Date Initial Checking Passed:
                    </th>
                    <th style="text-align: center">Application Status:</th>
                    <th style="text-align: center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script
    src="bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.min.js"
    charset="utf-8"
></script>

<script>
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $countdowns = [];
    $overdues = [];

    setInterval(function () {
        $(".Timer").text((new Date() - start) / 1000 + " Seconds");
    }, 1000);

    $.ajax({
        type: "GET",
        dataType: "json",
        url: "/get-alerts",
        success: function (responses) {
            if (responses.countdowns.length == 0) {
                $("#notification-list").append(
                    "<center><div><div class='icon-circle bg-primary'><i class='bi bi-building' style='color: white; font-size: x-large'></i></div></div></center>" +
                        "<div id='countdown-list'><b>No facilities pending for inspection:</b></div>"
                );
            } else {
                $("#notification-list").append(
                    "<center><div><div class='icon-circle bg-primary'><i class='bi bi-building' style='color: white; font-size: x-large'></i></div></div></center>" +
                        "<div id='countdown-list'><b>Facilities pending for inspection:</b></div>"
                );
            }

            if (responses.overdues.length == 0) {
                $("#notification-list").append(
                    "<br/><center><div><div class='icon-circle badge-danger'><i class='bi bi-building-fill-exclamation' style='font-size: x-large'></i></div></div></center>" +
                        "<div id='overdue-list'><b>No facilities overdue for inspection:</b></div>"
                );
            } else {
                $("#notification-list").append(
                    "<br/><center><div><div class='icon-circle badge-danger'><i class='bi bi-building-fill-exclamation' style='font-size: x-large'></i></div></div></center>" +
                        "<div id='overdue-list'><b>Facilities overdue for inspection:</b></div>" +
                        "<div id='overdue-10'><b>Overdue for 10 or more days:</b></div><br/>" +
                        "<div id='overdue-15'><b>Overdue for 15 or more days:</b></div><br/>" +
                        "<div id='overdue-17'><b>Overdue for 17 or more days:</b></div><br/>" +
                        "<div id='overdue-20'><b>Overdue for 20 or more days:</b></div>"
                );
            }

            $badgeCount =
                Number($(".badge.badge-danger.badge-counter").text()) +
                responses.countdowns.length;

            start = new Date();

            if ($countdowns.length != responses.countdowns.length) {
                $countdowns = responses.countdowns;
                jQuery.each($countdowns, (index, item) => {
                    $(".badge.badge-danger.badge-counter").html(
                        "" + $badgeCount + ""
                    );
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
                $("#overdue-10").hide();
                $("#overdue-15").hide();
                $("#overdue-17").hide();
                $("#overdue-20").hide();
                jQuery.each($overdues, (index, item) => {
                    if (item.overdueDays >= 10 && item.overdueDays < 15) {
                        $("#overdue-10").show();
                        $badgeCount =
                            Number(
                                $(".badge.badge-danger.badge-counter").text()
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
                    if (item.overdueDays >= 15 && item.overdueDays < 17) {
                        $("#overdue-15").show();
                        $badgeCount =
                            Number(
                                $(".badge.badge-danger.badge-counter").text()
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
                    if (item.overdueDays >= 17 && item.overdueDays < 20) {
                        $("#overdue-17").show();
                        $badgeCount =
                            Number(
                                $(".badge.badge-danger.badge-counter").text()
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
                                $(".badge.badge-danger.badge-counter").text()
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
<script>
    $(".input-group.date").datepicker({
        autoclose: true,
        todayBtn: "linked",
        clearBtn: true,
        orientation: "bottom auto",
        //To only allow scheduling of date during business days
        daysOfWeekDisabled: "0,6",
        //To disable dates before the current date
        beforeShowDay: function (date) {
            if (date.getMonth() == new Date().getMonth()) {
                if (date.getDate() <= new Date().getDate()) {
                    return false;
                }
            } else if (
                date.getMonth() < new Date().getMonth() ||
                date.getFullYear() < new Date().getFullYear()
            ) {
                return false;
            }
        },
    });

    if ($(".input-group.date").val() == "") {
        $(".input-group.date")
            .datepicker()
            .on("changeDate", function (e) {
                $(".input-group.date").val(e.date);
                if ($(".input-group.date").val() == "") {
                    $(".btn-accept").prop("disabled", true);
                } else {
                    $(".btn-accept").prop("disabled", false);
                }
            });
    } else {
        $(".btn-accept").prop("disabled", false);
    }
</script>
<script>
    $(function () {
        $("#opappTable").hide();
        $("#opappTable_wrapper").hide();

        $("#apptype").on("change", function () {
            if ($(this).val() == "initapp") {
                $("#initappTable").show();
                $("#initappTable_wrapper").show();
                $("#opappTable").hide();
                $("#opappTable_wrapper").hide();
            } else {
                $("#initappTable").hide();
                $("#initappTable_wrapper").hide();
                $("#opappTable").show();
                $("#opappTable_wrapper").show();
            }
        });
    });
</script>
<script src="//cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
<script>
    //For javascript
    // new DataTable('#myTable')

    // For jquery
    // $('#myTable').DataTable();

    function format(d) {
        // `d` is the original data object for the row

        return (
            "<dl>" +
            "<dt>Name Of Owner/Operator:</dt>" +
            "<dd>" +
            d.owner_name +
            "</dd>" +
            "<dt>Applicant Address:</dt>" +
            "<dd>" +
            d.owner_address +
            "</dd>" +
            "<dt>Applicant Email Address:</dt>" +
            "<dd>" +
            d.email +
            "</dd>" +
            "<dt>Facility Telephone Number:</dt>" +
            "<dd>" +
            d.fac_telphone_no +
            "</dd>" +
            "<dt>Location of Water Refilling Station(No., Street, City/Municipality, Province):</dt>" +
            "<dd>" +
            d.fac_address +
            "</dd>" +
            "<dt>Latitude:</dt>" +
            "<dd>" +
            d.latitude +
            "</dd>" +
            "<dt>Longitude:</dt>" +
            "<dd>" +
            d.longitude +
            "</dd>" +
            "<dt>Area to be Served:</dt>" +
            "<dd>" +
            d.area_to_serve +
            "</dd>" +
            "<dt>Type of Water Source:</dt>" +
            "<dd>" +
            d.water_source_type +
            "</dd>" +
            "<dt>Facility Telephone Number:</dt>" +
            "<dd>" +
            d.telephone_number +
            "</dd>" +
            "<dt>Phone Number:</dt>" +
            "<dd>" +
            d.phone_number +
            "</dd>" +
            "</dl>"
        );
    }

    let initappTable = new DataTable("#initappTable", {
        ajax: "/initapps",
        columnDefs: [
            {
                targets: 1,
                className: "text-center",
            },
            {
                targets: 2,
                className: "text-center",
            },
            {
                targets: 3,
                className: "text-center",
            },
            {
                targets: 4,
                className: "text-center",
            },
            {
                targets: 5,
                className: "text-center",
            },
        ],
        layout: {
            topEnd: {
                search: {
                    text: "Search (using Applicant Name, Facility Name, or Date Initial Checking Passed):",
                },
            },
        },
        columns: [
            {
                className: "dt-control",
                orderable: true,
                data: null,
                defaultContent: "",
            },
            {
                data: "null",
                render: function (data, type, row, meta) {
                    return (
                        '<div id="txtname' +
                        row.initapp_id +
                        '">' +
                        row.firstname +
                        " " +
                        row.mi[0] +
                        ". " +
                        row.lastname +
                        "</div>" +
                        '<p hidden id="txtemail' +
                        row.initapp_id +
                        '">' +
                        row.email +
                        "</p>" +
                        '<p hidden id="txtlateremarks' +
                        row.initapp_id +
                        '">' +
                        "" +
                        row.late_remarks +
                        "</p>"
                    );
                },
            },
            { data: "fac_name" },
            {
                data: "acceptance_date",
                render: function (data, type, row) {
                    var dateSplit = data.split("-");
                    var formattedDate =
                        type === "display" || type === "filter"
                            ? dateSplit[1] +
                              "/" +
                              dateSplit[2] +
                              "/" +
                              dateSplit[0]
                            : data;

                    //Current day of the month
                    const currentDate = new Date($.now());

                    function getBusinessDaysCount(startDate, endDate) {
                        var workingDays = 0;
                        for (
                            var current_Date = startDate;
                            current_Date <= endDate;
                            current_Date.setDate(current_Date.getDate() + 1)
                        ) {
                            var day = current_Date.getDay();

                            if (day !== 0 && day !== 6) {
                                // Exclude Sundays (0) and Saturdays (6)
                                workingDays++;

                                // Optional: Check for holidays (replace with your logic)
                                // if (isHoliday(current_Date)) {
                                //   workingDays--;
                                // }
                            }
                        }
                        return workingDays;
                    }

                    var newCurrentDate = new Date(formattedDate).setDate(
                        new Date(formattedDate).getDate() + 1
                    );
                    var businessDays = getBusinessDaysCount(
                        new Date(newCurrentDate),
                        currentDate
                    );

                    var remainingDays = businessDays;

                    // If the days for action has exceeded 10 days
                    if (remainingDays >= 10) {
                        return (
                            "<span>" +
                            formattedDate +
                            "</span><br/><br/><div value=" +
                            remainingDays +
                            ' id="late-date' +
                            row.initapp_id +
                            '" style="background-color:red;color:white;width:100%;padding:2px">Days overdue: ' +
                            remainingDays +
                            "</div>"
                        );
                    }
                    // If the days for action is still within 10 days
                    else {
                        var newRemainingDays = 10 - remainingDays;
                        return (
                            "<span>" +
                            formattedDate +
                            "</span><br/><br/><div value=" +
                            newRemainingDays +
                            ' id="not-late-date' +
                            row.initapp_id +
                            '" style="background-color:green;color:white;width:100%;padding:2px">Days remaining for action: ' +
                            newRemainingDays +
                            "</div>"
                        );
                    }
                },
            },
            {
                data: "application_status",
                searchable: false,
                render: function (data, type, row, meta) {
                    return (
                        '<div id="txtapp_status' +
                        row.initapp_id +
                        '">' +
                        data +
                        "</div>"
                    );
                },
            },
            {
                data: "null",
                width: "20%",
                searchable: false,
                sortable: false,
                render: function (data, type, row, meta) {
                    if (row.remarks === "NULL") {
                        row.remarks = "";
                    }
                    $(function () {
                        $("button[name=showremarks]")
                            .unbind()
                            .click(function () {
                                var id = $(this).attr("id");
                                var textremarks = $("#txtremarks" + id);
                                textremarks.toggle();
                                if (textremarks.is(":visible")) {
                                    textremarks.focus();
                                    // row.remarks = textremarks.val();
                                    // console.log(row.remarks);
                                } else {
                                    textremarks.blur();
                                }
                            });
                    });

                    return (
                        "<button  value=" +
                        row.initapp_id +
                        " id=" +
                        row.initapp_id +
                        ' name="viewattachments" class="view_attach-btn btn btn-primary" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalViewInitialAttachments">View Attachments</button>' +
                        "<button id=" +
                        row.initapp_id +
                        ' name="showremarks" class="inspector-btn btn btn-primary">Remarks</button>' +
                        '<br /><textarea id="txtremarks' +
                        row.initapp_id +
                        '" class="inspectorRmrks">' +
                        row.remarks +
                        "</textarea>" +
                        "<button  value=" +
                        row.initapp_id +
                        " id=" +
                        row.initapp_id +
                        ' name="schedule" class="inspector_schedule-btn btn btn-primary" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalScheduleConfirmation">Schedule</button>' +
                        "<button  value=" +
                        row.initapp_id +
                        " id=" +
                        row.initapp_id +
                        ' name="reject" class="inspector_reject-btn btn btn-primary" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalRejectConfirmation">Reject</button>'
                    );
                },
            },
        ],
        order: [[1, "asc"]],
    });

    //Button for viewing all submitted attachments
    //First retrieves the attachments related to the applicant using their initapp_id (which stands for Initial Application ID)
    //Appends an href tag to the div-body for every attachment filepath retrieved from the database
    //Then opens the file through a new tab
    $(document).on("click", ".view_attach-btn", function (e) {
        e.preventDefault();

        var initapp_id = $(this).attr("id");

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $(".attach-body").html("");

        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/get-init-attachment/" + initapp_id,
            success: function (response) {
                if (
                    response.message ==
                    "Error with retrieving the attachments from the database"
                ) {
                    $(".attach-body").append(
                        "<div>There's currently no attachments sent by this individual</div>"
                    );
                }
                if (response.message.cert_pot) {
                    var attachment = response.message.cert_pot;

                    $(".attach-body").append(
                        `<a href='{{url('${attachment}')}}' target="_blank" class='btn-view-certPot btn btn-primary'>Letter to the Director</a>`
                    );
                }
                if (response.message.sanitary_survey) {
                    var attachment = response.message.sanitary_survey;

                    $(".attach-body").append(
                        `<a href='{{url('${attachment}')}}' target="_blank" class='btn-view-sanSurvey btn btn-primary'>Letter to the Director</a>`
                    );
                }
                if (response.message.watersite_clearance) {
                    var attachment = response.message.watersite_clearance;

                    $(".attach-body").append(
                        `<a href='{{url('${attachment}')}}' target="_blank" class='btn-view-watClear btn btn-primary'>Letter to the Director</a>`
                    );
                }
                if (response.message.engineers_report) {
                    var attachment = response.message.engineers_report;

                    $(".attach-body").append(
                        `<a href='{{url('${attachment}')}}' target="_blank" class='btn-view-engRep btn btn-primary'>Letter to the Director</a>`
                    );
                }
                if (response.message.plans_specs) {
                    var attachment = response.message.plans_specs;

                    $(".attach-body").append(
                        `<a href='{{url('${attachment}')}}' target="_blank" class='btn-view-plansSpecs btn btn-primary'>Letter to the Director</a>`
                    );
                }
                if (response.message.application_form) {
                    var attachment = response.message.application_form;

                    $(".attach-body").append(
                        `<a href='{{url('${attachment}')}}' target="_blank" class='btn-view-appform btn btn-primary'>Letter to the Director</a>`
                    );
                }
                if (response.message.letter) {
                    var attachment = response.message.letter;

                    $(".attach-body").append(
                        `<a href='{{url('${attachment}')}}' target="_blank" class='btn-view-letter btn btn-primary'>Letter to the Director</a>`
                    );
                }
            },
        });
    });

    //Shows the confirmation modal for approving the application
    //passes the id currently possess by the inspector_schedule-btn to the hidden input tag in the modal
    //this id will then be used in order to find the corresponding application record
    //A hidden textarea tag will appear if the application has been overdue for processing
    $(document).on("click", ".inspector_schedule-btn", function (e) {
        e.preventDefault();

        var initapp_id = $(this).val();

        var fac_id = $("#accept_fac_id");
        fac_id.val(initapp_id);

        var if_late = $("#late-date" + fac_id.val());
        var if_not_late = $("#not-late-date" + fac_id.val());

        var date_late;

        var lateremarks;

        if ($("#txtlateremarks" + fac_id.val()).text() === "null") {
            lateremarks = "";
        } else {
            lateremarks = $("#txtlateremarks" + fac_id.val()).text();
        }

        if (lateremarks.length > 0) {
            $("#reason-late").val(lateremarks);
            $("#reason-late").css("border-color", "black");
        } else {
            $("#reason-late").val("");
            $("#reason-late").css("border-color", "red");
        }

        if ($("#txtapp_status" + initapp_id).text() == "Failed") {
            $(".inspection_type_label").text("Select a date for reinspection:");
        }

        if (if_late.length > 0) {
            date_late = if_late.text().replace(/[^0-9]/g, "");

            $("#late-submission").show();
            $("#late-submission").html(
                "Action for this application has been overdue for: " +
                    date_late +
                    " days. " +
                    "<br/>" +
                    "You must give a reason for being late:"
            );
            $("#reason-late").show();

            if (lateremarks.length <= 0) {
                $(".btn-accept").prop("disabled", true);
            } else {
                $(".btn-accept").prop("disabled", false);
            }

            $("#reason-late").on("input", function (e) {
                if ($("#reason-late").val().length <= 0) {
                    $(".btn-accept").prop("disabled", true);
                    $("#reason-late").css("border-color", "red");
                } else {
                    $(".btn-accept").prop("disabled", false);
                    $("#reason-late").css("border-color", "black");
                }
            });
        } else {
            $("#late-submission").hide();
            $("#reason-late").hide();

            if ($(".input-group.date").val() == "") {
                $(".btn-accept").prop("disabled", true);
            }

            // console.log($(".input-group.date").val());
        }
    });

    //Shows the confirmation modal for rejecting the facility
    //passes the id currently possess by the inspector_schedule-btn to the hidden input tag in the modal
    //this id will then be used in order to find the corresponding facility record
    $(document).on("click", ".inspector_reject-btn", function (e) {
        e.preventDefault();

        var initapp_id = $(this).val();

        var fac_id = $("#reject_fac_id");
        fac_id.val(initapp_id);
    });

    //Button for refreshing the list of facilities in the datatable
    $(document).on("click", ".refresh_btn", function (e) {
        initappTable.ajax.reload();
    });

    //Button for actually updating the facility record by accepting it.
    //It uses the id passed
    //onto the hidden input in order to search for the facility and the update it
    $(document).on("click", ".btn-accept", function (e) {
        e.preventDefault();

        //For getting the id of the application
        var initapp_id = $("#accept_fac_id").val();

        //For getting the applicant's name
        var applicant_name = $("#txtname" + initapp_id).text();

        //For getting the current date
        var newDate = $("#reason-late").val() == "" ? "" : new Date();

        //For getting the date from the datepicker
        var inspection_date = $(".input-group.date").val();

        //This is the default application status. It's always set to default
        var defaultAppStatus = "Accepted";

        //For getting the month value in two digits. If it's less than 10,
        //it'll give the month with a zero in front as the format
        if (newDate != "") {
            var newMonth =
                newDate.getMonth() < 10
                    ? "0" + (newDate.getMonth() + 1)
                    : newDate.getMonth() + 1;
        }
        var inspectionMonth =
            inspection_date.getMonth() < 10
                ? "0" + (inspection_date.getMonth() + 1)
                : inspection_date.getMonth() + 1;

        //Checks whether the initial inspection failed
        //If yes, sets the default application status to 'for reinspection'
        if ($("#txtapp_status" + initapp_id).text() == "Failed") {
            defaultAppStatus = "For reinspection";
        }

        //This is the data sent for updating the application status
        var data = {
            remarks: $("#txtremarks" + initapp_id).val(),
            application_status: defaultAppStatus,
            late_remarks: $("#reason-late").val(),
            late_date:
                newDate != ""
                    ? "" +
                      newDate.getFullYear() +
                      "-" +
                      newMonth +
                      "-" +
                      newDate.getDate() +
                      " " +
                      newDate.getHours() +
                      ":" +
                      newDate.getMinutes() +
                      ":" +
                      newDate.getSeconds() +
                      ""
                    : "",
            inspection_date:
                "" +
                inspection_date.getFullYear() +
                "-" +
                inspectionMonth +
                "-" +
                inspection_date.getDate(),
            inspector_name: "Mr. John Doe",
            reinspection_date:
                "" +
                inspection_date.getFullYear() +
                "-" +
                inspectionMonth +
                "-" +
                inspection_date.getDate(),
        };

        var monthToString;

        function inspectMonthToString() {
            switch (inspectionMonth) {
                case "01":
                    monthToString = "January";
                    break;
                case "02":
                    monthToString = "February";
                    break;
                case "03":
                    monthToString = "March";
                    break;
                case "04":
                    monthToString = "April";
                    break;
                case "05":
                    monthToString = "May";
                    break;
                case "06":
                    monthToString = "June";
                    break;
                case "07":
                    monthToString = "July";
                    break;
                case "08":
                    monthToString = "August";
                    break;
                case "09":
                    monthToString = "September";
                    break;
                case "10":
                    monthToString = "October";
                    break;
                case "11":
                    monthToString = "November";
                    break;
                case "12":
                    monthToString = "December";
                    break;
            }
        }

        inspectMonthToString();

        //This is the data used when formatting the email notification after updating
        //the application status
        var emailData = {
            name: applicant_name,
            email: $("#txtemail" + initapp_id).text(),
            application_status: data.application_status,
            remarks: data.remarks,
            inspection_date:
                "" +
                monthToString +
                " " +
                inspection_date.getDate() +
                ", " +
                inspection_date.getFullYear(),
            applicant_name: applicant_name,
        };

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $("#reason-late").val("");

        var emailResponse;

        // Sending of email confirmation of acceptance of initial application
        $.ajax({
            type: "POST",
            url: "/send-email",
            data: emailData,
            dataType: "json",
            success: function (email) {
                emailResponse = email.message;
            },
        });

        // Actual updating of application status
        $.ajax({
            type: "PUT",
            url: "/set-initapp-inspection/" + initapp_id,
            data: data,
            dataType: "json",
            success: function (response) {
                initappTable.ajax.reload();

                if (response.status == 404) {
                    $("#updateform_ErrList").toggle();
                    $("#updateform_ErrList").fadeIn(400, function () {
                        $("#updateform_ErrList").html(
                            "" + response.message + ""
                        );
                    });
                    $("#updateform_ErrList")
                        .fadeTo(5000, 500)
                        .slideUp(500, function () {
                            $("#updateform_ErrList").slideUp(500);
                        });
                } else {
                    $("#success_message").toggle();
                    $("#success_message").fadeIn(400, function () {
                        $("#success_message").html(
                            "" +
                                response.message +
                                "! <br/>" +
                                "" +
                                emailResponse +
                                ""
                        );
                    });
                    $("#success_message")
                        .fadeTo(5000, 500)
                        .slideUp(500, function () {
                            $("#success_message").slideUp(500);
                        });
                }
            },
        });
    });

    //Button for actually updating the facility record by rejecting it.
    //It uses the id passed
    //onto the hidden input in order to search for the facility and the update it
    $(document).on("click", ".btn-reject", function (e) {
        e.preventDefault();
        var initapp_id = $("#reject_fac_id").val();

        var data = {
            remarks: $("#txtremarks" + initapp_id).val(),
            application_status: "Rejected",
        };

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            type: "PUT",
            url: "/set-initapp-inspection/" + initapp_id,
            data: data,
            dataType: "json",
            success: function (response) {
                initappTable.ajax.reload();

                if (response.status == 400) {
                } else if (response.status == 404) {
                } else {
                }
            },
        });
    });

    // Add event listener for opening and closing details for the initappTable childrow
    initappTable.on("click", "td.dt-control", function (e) {
        let tr = e.target.closest("tr");
        let row = initappTable.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
        } else {
            // Open this row
            row.child(format(row.data())).show();
            // row.child(format(tr.data('child-name'), tr.data('child-value'))).show();
        }
    });

    // let oppappTable = new DataTable('#opappappTable',{
    //     ajax: '/opapps',
    //     columnDefs: [
    //         {
    //             targets: 1,
    //             className: 'text-center',
    //         },
    //         {
    //             targets: 2,
    //             className: 'text-center',
    //         },
    //         {
    //             targets: 3,
    //             className: 'text-center',
    //         },
    //         {
    //             targets: 4,
    //             className: 'text-center',
    //         },
    //         {
    //             targets: 5,
    //             className: 'text-center',
    //         },
    //         {
    //             targets: 6,
    //             className: 'text-center',
    //         },
    // ],
    // layout: {
    //     topEnd: {
    //         search: {
    //             text: 'Search (using Applicant Name, Facility Name, License Number, or Submission Date):'
    //         }
    //     },
    //     // bottomStart: 'pageLength',
    // },
    // columns: [
    //     {
    //         className: 'dt-control',
    //         orderable: true,
    //         data: null,
    //         defaultContent: ''
    //     },
    //     { data: 'null', render: function(data, type, dataToSet){
    //         return dataToSet.client.firstname+' '+dataToSet.client.mi+'. '+dataToSet.client.lastname;
    //     }},
    //     { data: 'fac_name' },
    //     { data: 'fac_licenseno', render: function(data, type, dataToset){
    //         if(data === null){
    //             return 'None'
    //         }else{
    //             return data
    //         }
    //     }},
    //     // {data: 'submission_date'},
    //     { data: 'submission_date', render:
    //         function(data, type, row){
    //             var dateSplit = data.split('-');
    //             var formattedDate = type === "display" || type === "filter" ?
    //             dateSplit[1] +'/'+ dateSplit[2] +'/'+ dateSplit[0] : data;

    //             var currentDate = new Date($.now());
    //             var application_Date = new Date(data);
    //             var subtractedDate = currentDate.getTime() - application_Date.getTime();
    //             let Difference_In_Days = Math.round(subtractedDate / (1000 * 3600 * 24));

    //             if(Difference_In_Days>10){
    //                 return '<span>'+formattedDate+'</span><br/><br/><span style="background-color:red;color:white;width:100%;padding:2px">Days overdue: '+Difference_In_Days+'</span>'
    //             }else{
    //                 var currentDate = new Date($.now());
    //                 var application_Date = new Date(data);
    //                 var subtractedDate = application_Date.getTime() - currentDate.getTime();
    //                 let Difference_In_Days = Math.round(subtractedDate / (1000 * 3600 * 24));
    //                 return '<span>'+formattedDate+'</span><br/><br/><span style="background-color:green;color:white;width:100%;padding:2px">Days remaining for action: '+Difference_In_Days+'</span>'
    //             }
    //         }
    //     },
    //     { data: 'application_status'},
    //     { data: 'null', width: "20%", searchable: false, sortable: false, render:
    //         function(data, type, row, meta){
    //             if(row.remarks === "NULL"){
    //                 row.remarks = "";
    //             }
    //             $(function(){
    //                 $('button[name=showremarks]').unbind().click(function(){
    //                     var id= $(this).attr("id");
    //                     var textremarks = $("#txtremarks"+id);
    //                     textremarks.toggle();
    //                     if(textremarks.is(":hidden")){
    //                         row.remarks = textremarks.val();
    //                         console.log(row.remarks)
    //                     }
    //                 });
    //             });

    //             // $(function(e){
    //             //     $('button[name=accept]').unbind().click(function(e){
    //             //     e.preventDefault();
    //             //         var id= $(this).attr("id");
    //             //         var textremarks = $("#txtremarks"+id);
    //             //         console.log('Accepted');
    //             //         console.log("Sent remarks: "+textremarks.val());
    //             //     })
    //             // })

    //             // $(function(e){
    //             //     $('button[name=reject]').unbind().click(function(e){
    //             //     e.preventDefault();
    //             //         var id= $(this).attr("id");
    //             //         var textremarks = $("#txtremarks"+id);
    //             //         console.log('Rejected');
    //             //         console.log("Sent remarks: "+textremarks.val());
    //             //     })
    //             // })

    //             return '<button id='+row.initapp_id+' name="showremarks" class="inspector-btn btn btn-primary">Remarks</button>'
    //                 +'<br /><textarea id="txtremarks'+row.initapp_id+'" class="inspectorRmrks">'+row.remarks+'</textarea>'+
    //                 // '<button value='+row.initapp_id+' id='+row.initapp_id+' name="accept" class="inspector_schedule-btn btn btn-primary" type="submit">Accept</button>'+
    //                 // '<button value='+row.initapp_id+' id='+row.initapp_id+' name="reject" class="inspector_reject-btn btn btn-primary" type="submit">Reject</button>'+
    //                 '<button  value='+row.initapp_id+' id='+row.initapp_id+' name="accept" class="inspector_schedule-btn btn btn-primary" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAcceptConfirmation">Accept</button>'+
    //                 '<button  value='+row.initapp_id+' id='+row.initapp_id+' name="reject" class="inspector_reject-btn btn btn-primary" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalRejectConfirmation">Reject</button>'
    //                 // '</form>'
    //         }}
    //     ],
    //     order: [[1, 'asc']]
    // });

    //     // Add event listener for opening and closing details
    //     oppappTable.on('click', 'td.dt-control', function (e) {
    //     let tr = e.target.closest('tr');
    //     let row = opappTable.row(tr);

    //     if (row.child.isShown()) {
    //         // This row is already open - close it
    //         row.child.hide();
    //     }
    //     else {
    //         // Open this row
    //         row.child(format(row.data())).show();
    //         // row.child(format(tr.data('child-name'), tr.data('child-value'))).show();
    //     }

    // });
</script>
@endsection
