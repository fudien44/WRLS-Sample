@extends('layouts.auth')
<!-- Link for bootstrap-datepicker -->
<link
    rel="stylesheet"
    href="bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker.min.css"
/>
<link
    rel="stylesheet"
    href="//cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css"
/>
@section('content')
<!-- <style>
    .alert{
    text-align: center;
    position:fixed;
    top: 0px;
    left: 25%;
    width: 50%;
    z-index:9999;
    border-radius:0px;
}

.alert-facility{
    text-align: center;
    position:fixed;
    top: 0px;
    left: 25%;
    width: 50%;
    z-index:9999;
    border-radius:0px;
    display: none;
}
</style> -->
<link href="{{ asset('css/default.css') }}" rel="stylesheet" />
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Inspector Dashboard</h1>
</div>
<div class="div-content">
    <div class="alert alert-success alert-facility" id="success_message"></div>
    <div
        class="alert alert-danger alert-facility"
        id="updateform_ErrList"
    ></div>

    <!-- Initial Application Acceptance Confirmation Modal -->
    <div
        class="modal fade"
        id="modalScheduleConfirmation"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
                    <div id="schedule-late-submission"><br /></div>
                    <textarea
                        id="schedule-reason-late"
                        style="width: 100%"
                    ></textarea>
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

    <!-- Initial Application Rejection Confirmation Modal -->
    <div
        class="modal fade"
        id="modalRejectConfirmation"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
                    <br /><br />

                    <div id="reject-late-submission"><br /></div>
                    <textarea
                        id="reject-reason-late"
                        style="width: 100%"
                    ></textarea>
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

    <!-- Operational Application Acceptance Confirmation Modal -->
    <div
        class="modal fade"
        id="modalOperationalScheduleConfirmation"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
                    <div id="schedule-operational-late-submission"><br /></div>
                    <textarea
                        id="schedule-operational-reason-late"
                        style="width: 100%"
                    ></textarea>
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
                        class="btn-operational-accept btn btn-primary"
                        data-dismiss="modal"
                        style="width: 25%; height: 50%"
                    >
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Operational Application Rejection Confirmation Modal -->
    <div
        class="modal fade"
        id="modalOperationalRejectConfirmation"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
                    <br /><br />

                    <div id="reject-operational-late-submission"><br /></div>
                    <textarea
                        id="reject-operational-reason-late"
                        style="width: 100%"
                    ></textarea>
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
                        class="btn-operational-reject btn btn-primary"
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
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
            <h5 class="table-title">
                List of facilities pending for scheduling:
            </h5>
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
    </div>
</div>

<script
    src="bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.min.js"
    charset="utf-8"
></script>

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

    $(".btn-accept").prop("disabled", true);

    if ($(".input-group.date").val() == "") {
        $(".input-group.date")
            .datepicker()
            .on("changeDate", function (e) {
                $(".input-group.date").val(e.date);
                if (
                    $(".input-group.date").val() == "" ||
                    $("#reason-late").val() == ""
                ) {
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
            "<dl style='text-align:left'>" +
            "<dt>Name Of Owner/Operator:</dt>" +
            "<dd style='text-transform:capitalize'>" +
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
                orderable: false,
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
                        row.fname +
                        " " +
                        (row.mname != "" && row.mname != null
                            ? row.mname[0]
                            : "") +
                        ". " +
                        row.lname +
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
                    if (row.reject_remarks === "null") {
                        row.reject_remarks = "";
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
                                    // row.reject_remarks = textremarks.val();
                                    // console.log(row.reject_remarks);
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
                        row.reject_remarks +
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
                if (response.message.letter) {
                    var attachment = response.message.letter;

                    $(".attach-body").append(
                        `<a href='{{url('storage/${attachment}')}}' target="_blank" class='btn-view-letter btn btn-primary'>Letter to the Director</a>`
                    );
                }
                if (response.message.cert_pot) {
                    var attachment = response.message.cert_pot;
                    $(".attach-body").append(
                        `<a href='{{url('storage/${attachment}')}}' target="_blank" class='btn-view-certPot btn btn-primary'>Certificate of Potability (Laboratory Result of Water Sample)</a>`
                    );
                }
                if (response.message.sanitary_survey) {
                    var attachment = response.message.sanitary_survey;

                    $(".attach-body").append(
                        `<a href='{{url('storage/${attachment}')}}' target="_blank" class='btn-view-sanSurvey btn btn-primary'>Sanitary survey of water source</a>`
                    );
                }
                if (response.message.watersite_clearance) {
                    var attachment = response.message.watersite_clearance;

                    $(".attach-body").append(
                        `<a href='{{url('storage/${attachment}')}}' target="_blank" class='btn-view-watClear btn btn-primary'>Drinking water site clearance</a>`
                    );
                }
                if (response.message.engineers_report) {
                    var attachment = response.message.engineers_report;

                    $(".attach-body").append(
                        `<a href='{{url('storage/${attachment}')}}' target="_blank" class='btn-view-engRep btn btn-primary'>Engineer's Report</a>`
                    );
                }
                if (response.message.plans_specs) {
                    var attachment = response.message.plans_specs;

                    $(".attach-body").append(
                        `<a href='{{url('storage/${attachment}')}}' target="_blank" class='btn-view-plansSpecs btn btn-primary'>Plans and Specifications for the complete multi-stage water purification design of the plant prepared, signed and sealed by a privately practicing licensed Sanitary Engineer</a>`
                    );
                }
                if (response.message.application_form) {
                    var attachment = response.message.application_form;

                    $(".attach-body").append(
                        `<a href='{{url('storage/${attachment}')}}' target="_blank" class='btn-view-appform btn btn-primary'>Initial Application Form</a>`
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
            $("#schedule-reason-late").val(lateremarks);
            $("#schedule-reason-late").css("border-color", "black");
        } else {
            $("#schedule-reason-late").val("");
            $("#schedule-reason-late").css("border-color", "red");
        }

        if ($("#txtapp_status" + initapp_id).text() == "Failed") {
            $(".inspection_type_label").text("Select a date for reinspection:");
        }

        if (if_late.length > 0) {
            date_late = if_late.text().replace(/[^0-9]/g, "");

            $("#schedule-late-submission").show();
            $("#schedule-late-submission").html(
                "Action for this application has been overdue for: " +
                    date_late +
                    " days. " +
                    "<br/>" +
                    "You must give a reason for being late:"
            );
            $("#schedule-reason-late").show();

            if (lateremarks.length <= 0) {
                $(".btn-accept").prop("disabled", true);
            } else {
                $(".btn-accept").prop("disabled", false);
            }

            if (
                $("#schedule-reason-late").val().length > 0 &&
                $(".input-group.date").val().length == 0
            ) {
                $(".btn-accept").prop("disabled", true);
            }

            $("#schedule-reason-late").on("input", function (e) {
                if (
                    $("#schedule-reason-late").val().length <= 0 ||
                    $(".input-group.date").val().length == 0
                ) {
                    $(".btn-accept").prop("disabled", true);
                    $("#schedule-reason-late").css("border-color", "red");
                } else {
                    $(".btn-accept").prop("disabled", false);
                    $("#schedule-reason-late").css("border-color", "black");
                }
            });
        } else {
            $("#schedule-late-submission").hide();
            $("#schedule-reason-late").hide();

            console.log($(".input-group.date").val());
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
            $("#reject-reason-late").val(lateremarks);
            $("#reject-reason-late").css("border-color", "black");
        } else {
            $("#reject-reason-late").val("");
            $("#reject-reason-late").css("border-color", "red");
        }

        if ($("#txtapp_status" + initapp_id).text() == "Failed") {
            $(".inspection_type_label").text("Select a date for reinspection:");
        }

        if (if_late.length > 0) {
            date_late = if_late.text().replace(/[^0-9]/g, "");

            $("#reject-late-submission").show();
            $("#reject-late-submission").html(
                "Action for this application has been overdue for: " +
                    date_late +
                    " days. " +
                    "<br/>" +
                    "You must give a reason for being late:"
            );
            $("#reject-reason-late").show();

            if (lateremarks.length <= 0) {
                $(".btn-reject").prop("disabled", true);
            } else {
                $(".btn-reject").prop("disabled", false);
            }

            $("#reject-reason-late").on("input", function (e) {
                if (
                    $("#reject-reason-late").val().length <= 0 &&
                    $(".input-group.date").val().length <= 0
                ) {
                    $(".btn-reject").prop("disabled", true);
                    $("#reject-reason-late").css("border-color", "red");
                } else {
                    $(".btn-reject").prop("disabled", false);
                    $("#reject-reason-late").css("border-color", "black");
                }
            });
        } else {
            $("#reject-late-submission").hide();
            $("#reject-reason-late").hide();

            // console.log($(".input-group.date").val());
        }
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
        var newDate = $("#schedule-reason-late").val() == "" ? "" : new Date();

        //For getting the date from the datepicker
        var inspection_date = $(".input-group.date").val();

        //This is the default application status. It's always set to default
        var defaultAppStatus = "For visitation";

        //For getting the month value in two digits. If it's less than 10,
        //it'll give the month with a zero in front as the format
        if (newDate != "") {
            var newMonth =
                newDate.getMonth() < 10
                    ? "0" + (newDate.getMonth() + 1)
                    : newDate.getMonth() + 1;
        }
        var inspectionMonth =
            inspection_date.getMonth() + 1 < 10
                ? "0" + (inspection_date.getMonth() + 1)
                : inspection_date.getMonth() + 1;

        //Checks whether the initial inspection failed
        //If yes, sets the default application status to 'for reinspection'
        if ($("#txtapp_status" + initapp_id).text() == "Failed") {
            defaultAppStatus = "For reinspection";
        }

        //This is the data sent for updating the application status
        var data = {
            reject_remarks: $("#txtremarks" + initapp_id).val(),
            application_status: defaultAppStatus,
            late_remarks: $("#schedule-reason-late").val(),
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
            application_type: "initial application",
            reject_remarks: data.reject_remarks,
            inspection_date:
                "" +
                monthToString +
                " " +
                inspection_date.getDate() +
                ", " +
                inspection_date.getFullYear(),
        };

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $("#schedule-reason-late").val("");

        var emailResponse;
        // Sending of email confirmation of acceptance of initial application
        $.ajax({
            type: "POST",
            url: "/send-email",
            data: emailData,
            dataType: "json",
            success: function (email) {
                emailResponse = email.message;

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
            },
        });
    });

    //Button for actually updating the facility record by rejecting it.
    //It uses the id passed
    //onto the hidden input in order to search for the facility and the update it
    $(document).on("click", ".btn-reject", function (e) {
        e.preventDefault();

        //For getting the id of the application
        var initapp_id = $("#reject_fac_id").val();

        //For getting the applicant's name
        var applicant_name = $("#txtname" + initapp_id).text();

        //For getting the current date
        var newDate = $("#reject-reason-late").val() == "" ? "" : new Date();

        //This is the default application status. It's always set to default
        var defaultAppStatus = "Rejected";

        var newMonth =
            new Date().getMonth() < 10
                ? "0" + (new Date().getMonth() + 1)
                : new Date().getMonth() + 1;

        var rejectionMonth =
            new Date().getMonth() < 10
                ? "0" + (new Date().getMonth() + 1)
                : new Date().getMonth() + 1;

        //This is the data sent for updating the application status
        var data = {
            reject_remarks: $("#txtremarks" + initapp_id).val(),
            application_status: defaultAppStatus,
            late_remarks: $("#reject-reason-late").val(),
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
        };

        var monthToString;

        function inspectMonthToString() {
            switch (rejectionMonth) {
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
            application_type: "initial application",
            reject_remarks: data.reject_remarks,
            inspector_date_rejected:
                "" +
                monthToString +
                " " +
                new Date().getDate() +
                ", " +
                new Date().getFullYear(),
        };

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $("#schedule-reason-late").val("");

        var emailResponse;
        // Sending of email confirmation of acceptance of initial application
        $.ajax({
            type: "POST",
            url: "/send-email",
            data: emailData,
            dataType: "json",
            success: function (email) {
                emailResponse = email.message;

                $.ajax({
                    type: "PUT",
                    url: "/reject-initapp-inspection/" + initapp_id,
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
                            $("#success_message").attr(
                                "class",
                                "alert alert-warning"
                            );
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

    // $.ajaxSetup({
    //     headers: {
    //         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    //     },
    // });
    // $.ajax({
    //     type: "GET",
    //     url: "/opapps",
    //     dataType: "json",
    //     success: function (response) {
    //         console.log(response);
    //     },
    // });

    //Operational Application Table
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

    let opappTable = new DataTable("#opappTable", {
        ajax: "/opapps",
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
                        row.operateapp_id +
                        '">' +
                        row.fname +
                        " " +
                        (row.mname != "" && row.mname != null
                            ? row.mname[0]
                            : "") +
                        ". " +
                        row.lname +
                        "</div>" +
                        '<p hidden id="txtemail' +
                        row.operateapp_id +
                        '">' +
                        row.email +
                        "</p>" +
                        '<p hidden id="txtlateremarks' +
                        row.operateapp_id +
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
                            row.operateapp_id +
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
                            row.operateapp_id +
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
                        row.operateapp_id +
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
                    if (row.reject_remarks === "null") {
                        row.reject_remarks = "";
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
                                    // row.reject_remarks = textremarks.val();
                                    // console.log(row.reject_remarks);
                                } else {
                                    textremarks.blur();
                                }
                            });
                    });

                    return (
                        "<button  value=" +
                        row.operateapp_id +
                        " id=" +
                        row.operateapp_id +
                        ' name="viewattachments" class="view_attach-op-btn btn btn-primary" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalViewInitialAttachments">View Attachments</button>' +
                        "<button id=" +
                        row.operateapp_id +
                        ' name="showremarks" class="inspector-btn btn btn-primary">Remarks</button>' +
                        '<br /><textarea id="txtremarks' +
                        row.operateapp_id +
                        '" class="inspectorRmrks">' +
                        row.reject_remarks +
                        "</textarea>" +
                        "<button  value=" +
                        row.operateapp_id +
                        " id=" +
                        row.operateapp_id +
                        ' name="schedule" class="inspector_schedule-btn btn btn-primary" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalOperationalScheduleConfirmation">Schedule</button>' +
                        "<button  value=" +
                        row.operateapp_id +
                        " id=" +
                        row.operateapp_id +
                        ' name="reject" class="inspector_reject-btn btn btn-primary" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalOperationalRejectConfirmation">Reject</button>'
                    );
                },
            },
        ],
        order: [[1, "asc"]],
    });

    //Button for viewing all submitted attachments
    //First retrieves the attachments related to the applicant using their operateapp_id (which stands for Initial Application ID)
    //Appends an href tag to the div-body for every attachment filepath retrieved from the database
    //Then opens the file through a new tab
    $(document).on("click", ".view_attach-op-btn", function (e) {
        e.preventDefault();

        var operateapp_id = $(this).attr("id");

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $(".attach-body").html("");

        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/get-op-attachment/" + operateapp_id,
            success: function (response) {
                if (
                    response.message ==
                    "Error with retrieving the attachments from the database"
                ) {
                    $(".attach-body").append(
                        "<div>There's currently no attachments sent by this individual</div>"
                    );
                }
                if (response.message.letter_intent) {
                    var attachment = response.message.letter_intent;

                    $(".attach-body").append(
                        `<a href='{{url('storage/${attachment}')}}' target="_blank" class='btn-view-certPot btn btn-primary'>Letter of intent</a>`
                    );
                }
                if (response.message.cert_completion) {
                    var attachment = response.message.cert_completion;

                    $(".attach-body").append(
                        `<a href='{{url('storage/${attachment}')}}' target="_blank" class='btn-view-sanSurvey btn btn-primary'>Certificate of completion</a>`
                    );
                }
                if (response.message.cert_pot) {
                    var attachment = response.message.cert_pot;

                    $(".attach-body").append(
                        `<a href='{{url('storage/${attachment}')}}' target="_blank" class='btn-view-watClear btn btn-primary'>Certificate of potability</a>`
                    );
                }
                if (response.message.cert_training) {
                    var attachment = response.message.cert_training;

                    $(".attach-body").append(
                        `<a href='{{url('storage/${attachment}')}}' target="_blank" class='btn-view-engRep btn btn-primary'>Certificate of 40 hours training</a>`
                    );
                }
                if (response.message.plans_specs) {
                    var attachment = response.message.xerox_init_permit;

                    $(".attach-body").append(
                        `<a href='{{url('storage/${attachment}')}}' target="_blank" class='btn-view-plansSpecs btn btn-primary'>Photocopy of initial permit issued by DOH CHD SOCCSKSARGEN region</a>`
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
        var operateapp_id = $(this).val();

        var fac_id = $("#accept_fac_id");
        fac_id.val(operateapp_id);

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
            $("#schedule-operational-reason-late").val(lateremarks);
            $("#schedule-operational-reason-late").css("border-color", "black");
        } else {
            $("#schedule-operational-reason-late").val("");
            $("#schedule-operational-reason-late").css("border-color", "red");
        }

        if ($("#txtapp_status" + operateapp_id).text() == "Failed") {
            $(".inspection_type_label").text("Select a date for reinspection:");
        }

        if (if_late.length > 0) {
            date_late = if_late.text().replace(/[^0-9]/g, "");

            $("#schedule-operational-late-submission").show();
            $("#schedule-operational-late-submission").html(
                "Action for this application has been overdue for: " +
                    date_late +
                    " days. " +
                    "<br/>" +
                    "You must give a reason for being late:"
            );
            $("#schedule-operational-reason-late").show();

            if (lateremarks.length <= 0) {
                $(".btn-accept").prop("disabled", true);
            } else {
                $(".btn-accept").prop("disabled", false);
            }

            if (
                $("#schedule-operational-reason-late").val().length > 0 &&
                $(".input-group.date").val().length == 0
            ) {
                $(".btn-accept").prop("disabled", true);
            }

            $("#schedule-operational-reason-late").on("input", function (e) {
                if (
                    $("#schedule-operational-reason-late").val().length <= 0 ||
                    $(".input-group.date").val().length == 0
                ) {
                    $(".btn-accept").prop("disabled", true);
                    $("#schedule-operational-reason-late").css(
                        "border-color",
                        "red"
                    );
                } else {
                    $(".btn-accept").prop("disabled", false);
                    $("#schedule-operational-reason-late").css(
                        "border-color",
                        "black"
                    );
                }
            });
        } else {
            $("#schedule-operational-late-submission").hide();
            $("#schedule-operational-reason-late").hide();

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
        var operateapp_id = $(this).val();

        var fac_id = $("#reject_fac_id");
        fac_id.val(operateapp_id);

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
            $("#reject-operational-reason-late").val(lateremarks);
            $("#reject-operational-reason-late").css("border-color", "black");
        } else {
            $("#reject-operational-reason-late").val("");
            $("#reject-operational-reason-late").css("border-color", "red");
        }

        if ($("#txtapp_status" + operateapp_id).text() == "Failed") {
            $(".inspection_type_label").text("Select a date for reinspection:");
        }

        if (if_late.length > 0) {
            date_late = if_late.text().replace(/[^0-9]/g, "");

            $("#reject-operational-late-submission").show();
            $("#reject-operational-late-submission").html(
                "Action for this application has been overdue for: " +
                    date_late +
                    " days. " +
                    "<br/>" +
                    "You must give a reason for being late:"
            );
            $("#reject-operational-reason-late").show();

            if (lateremarks.length <= 0) {
                $(".btn-reject").prop("disabled", true);
            } else {
                $(".btn-reject").prop("disabled", false);
            }

            $("#reject-operational-reason-late").on("input", function (e) {
                if (
                    $("#reject-operational-reason-late").val().length <= 0 &&
                    $(".input-group.date").val().length <= 0
                ) {
                    $(".btn-reject").prop("disabled", true);
                    $("#reject-operational-reason-late").css(
                        "border-color",
                        "red"
                    );
                } else {
                    $(".btn-reject").prop("disabled", false);
                    $("#reject-operational-reason-late").css(
                        "border-color",
                        "black"
                    );
                }
            });
        } else {
            $("#reject-operational-late-submission").hide();
            $("#reject-operational-reason-late").hide();

            // console.log($(".input-group.date").val());
        }
    });

    //Button for refreshing the list of facilities in the datatable
    $(document).on("click", ".refresh_btn", function (e) {
        opappTable.ajax.reload();
    });

    //Button for actually updating the facility record by accepting it.
    //It uses the id passed
    //onto the hidden input in order to search for the facility and the update it
    $(document).on("click", ".btn-operational-accept", function (e) {
        e.preventDefault();

        //For getting the id of the application
        var operateapp_id = $("#accept_fac_id").val();

        //For getting the applicant's name
        var applicant_name = $("#txtname" + operateapp_id).text();

        //For getting the current date
        var newDate = $("#schedule-reason-late").val() == "" ? "" : new Date();

        //For getting the date from the datepicker
        var inspection_date = $(".input-group.date").val();

        //This is the default application status. It's always set to default
        var defaultAppStatus = "For visitation";

        //For getting the month value in two digits. If it's less than 10,
        //it'll give the month with a zero in front as the format
        if (newDate != "") {
            var newMonth =
                newDate.getMonth() < 10
                    ? "0" + (newDate.getMonth() + 1)
                    : newDate.getMonth() + 1;
        }
        var inspectionMonth =
            inspection_date.getMonth() + 1 < 10
                ? "0" + (inspection_date.getMonth() + 1)
                : inspection_date.getMonth() + 1;

        //Checks whether the initial inspection failed
        //If yes, sets the default application status to 'for reinspection'
        if ($("#txtapp_status" + operateapp_id).text() == "Failed") {
            defaultAppStatus = "For reinspection";
        }

        //This is the data sent for updating the application status
        var data = {
            reject_remarks: $("#txtremarks" + operateapp_id).val(),
            application_status: defaultAppStatus,
            late_remarks: $("#schedule-reason-late").val(),
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

        // This is the data used when formatting the email notification after updating
        // the application status
        var emailData = {
            name: applicant_name,
            email: $("#txtemail" + operateapp_id).text(),
            application_status: data.application_status,
            application_type: "operational application",
            reject_remarks: data.reject_remarks,
            inspection_date:
                "" +
                monthToString +
                " " +
                inspection_date.getDate() +
                ", " +
                inspection_date.getFullYear(),
        };

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $("#schedule-reason-late").val("");

        var emailResponse;

        // Sending of email confirmation of acceptance of initial application
        $.ajax({
            type: "POST",
            url: "/send-email",
            data: emailData,
            dataType: "json",
            success: function (email) {
                emailResponse = email.message;

                // Actual updating of application status
                $.ajax({
                    type: "PUT",
                    url: "/set-opapp-inspection/" + operateapp_id,
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        opappTable.ajax.reload();

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
            },
        });
    });

    //Button for actually updating the facility record by rejecting it.
    //It uses the id passed
    //onto the hidden input in order to search for the facility and the update it
    $(document).on("click", ".btn-operational-reject", function (e) {
        e.preventDefault();
        var operateapp_id = $("#reject_fac_id").val();

        //For getting the id of the application
        var operateapp_id = $("#reject_fac_id").val();

        //For getting the applicant's name
        var applicant_name = $("#txtname" + operateapp_id).text();

        //For getting the current date
        var newDate =
            $("#reject-operational-reason-late").val() == "" ? "" : new Date();

        //This is the default application status. It's always set to default
        var defaultAppStatus = "Rejected";

        var newMonth =
            new Date().getMonth() < 10
                ? "0" + (new Date().getMonth() + 1)
                : new Date().getMonth() + 1;

        var rejectionMonth =
            new Date().getMonth() < 10
                ? "0" + (new Date().getMonth() + 1)
                : new Date().getMonth() + 1;

        //This is the data sent for updating the application status
        var data = {
            reject_remarks: $("#txtremarks" + operateapp_id).val(),
            application_status: defaultAppStatus,
            late_remarks: $("#reject-operational-reason-late").val(),
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
        };

        var monthToString;

        function inspectMonthToString() {
            switch (rejectionMonth) {
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

        // This is the data used when formatting the email notification after updating
        // the application status
        var emailData = {
            name: applicant_name,
            email: $("#txtemail" + operateapp_id).text(),
            application_status: data.application_status,
            application_type: "operational application",
            reject_remarks: data.reject_remarks,
            inspector_date_rejected:
                "" +
                monthToString +
                " " +
                new Date().getDate() +
                ", " +
                new Date().getFullYear(),
        };

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        var emailResponse;
        // Sending of email confirmation of acceptance of initial application
        $.ajax({
            type: "POST",
            url: "/send-email",
            data: emailData,
            dataType: "json",
            success: function (email) {
                emailResponse = email.message;

                $.ajax({
                    type: "PUT",
                    url: "/reject-opapp-inspection/" + operateapp_id,
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        opappTable.ajax.reload();

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
                            $("#success_message").attr(
                                "class",
                                "alert alert-warning"
                            );
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
            },
        });
    });

    // Add event listener for opening and closing details for the opappTable childrow
    opappTable.on("click", "td.dt-control", function (e) {
        let tr = e.target.closest("tr");
        let row = opappTable.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
        } else {
            // Open this row
            row.child(format(row.data())).show();
            // row.child(format(tr.data('child-name'), tr.data('child-value'))).show();
        }
    });
</script>
@endsection
