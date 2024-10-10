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
<link href="{{ asset('css/default.css') }}" rel="stylesheet" />
@if($errors->any())
<div id="alert-message" class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif @if(session('success'))
<div id="alert-success" class="alert alert-success">
    {{ session("success") }}
</div>
@elseif(session('fail'))
<div id="alert-warning" class="alert alert-warning">
    {{ session("fail") }}
</div>
@endif

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">List of Facilities to be Inspected</h1>
</div>
<div class="div-content">
    <!-- Passed modal -->
    <div
        class="modal fade"
        id="modalPass"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passFailTitle">
                        Passed Inspection Form
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
                <div class="schedule-body modal-body">
                    <p hidden id="passed-application_id"></p>
                    <form
                        id="passInspect"
                        method="post"
                        action="update-inspection/{facid}"
                        enctype="multipart/form-data"
                    >
                        {{ csrf_field() }}
                        <input
                            type="text"
                            id="passtype"
                            name="inspectResult"
                            value="Passed"
                            hidden
                        />
                        <div class="mb-3" style="vertical-align: center">
                            Date when inspection completed:
                            <div
                                class="input-group date"
                                id="scheduledate"
                                data-provide="datepicker"
                            >
                                <input
                                    type="text"
                                    class="form-control"
                                    name="inspectionDate"
                                    required
                                /><span class="input-group-addon"></span>
                            </div>
                        </div>

                        <!-- <div style="vertical-align: center">
                            Remarks/Discrepancies:
                        </div>
                        <textarea id="txtremarks" type="text" name="inspectionRemarks"
                            class="inspectionRmrks"></textarea> -->
                        <div class="mb-3 mt-3">
                            <label for="formFile" class="form-label"
                                >Upload inspector checklist:</label
                            >
                            <input
                                class="form-control"
                                name="checklist"
                                type="file"
                                id="formFile"
                                required
                            />
                        </div>
                        <div id="schedule-late-submission"><br /></div>
                        <textarea
                            id="schedule-reason-late"
                            style="width: 100%"
                            required
                        ></textarea>
                        <input
                            type="submit"
                            id="btn-pass"
                            class="btn btn-primary"
                        />
                    </form>
                </div>
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

    <!-- Failed modal -->
    <div
        class="modal fade"
        id="modalFail"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passFailTitle">
                        Failed Inspection Form
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
                <div class="schedule-body modal-body">
                    <p hidden id="failed-application_id"></p>
                    <form
                        id="failInspect"
                        method="post"
                        action="update-inspection/{facid}"
                        enctype="multipart/form-data"
                    >
                        {{ csrf_field() }}
                        <input
                            type="text"
                            id="failtype"
                            name="inspectResult"
                            value="Failed"
                            hidden
                        />
                        <div class="mb-3" style="vertical-align: center">
                            Date when inspection completed:
                            <div
                                class="input-group date"
                                id="scheduledate"
                                data-provide="datepicker"
                            >
                                <input
                                    type="text"
                                    class="form-control"
                                    name="inspectionDate"
                                    required
                                /><span class="input-group-addon"></span>
                            </div>
                        </div>

                        <div style="vertical-align: center">
                            Remarks/Discrepancies:
                        </div>
                        <textarea
                            id="failtxtRemarks"
                            type="text"
                            name="inspectionRemarks"
                            class="inspectionRmrks"
                            required
                        ></textarea>
                        <div class="mb-3 mt-3">
                            <label for="formFile" class="form-label"
                                >Upload inspector checklist:</label
                            >
                            <input
                                class="form-control"
                                name="checklist"
                                type="file"
                                id="failformFile"
                                required
                            />
                        </div>
                        <div id="failed-late-submission"><br /></div>
                        <textarea
                            id="failed-reason-late"
                            style="width: 100%"
                            required
                        ></textarea>
                        <input type="submit" id="btn-fail" class="btn btn-primary" />
                    </form>
                </div>
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

    <!-- View attachment modal -->
    <div
        class="modal fade"
        id="modalViewAttachments"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        Application Attachments:
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
        <button
            type="button"
            class="refresh_btn btn btn-primary"
            style="width: fit-content; margin-bottom: 10px"
        >
            Refresh list
        </button>

        <table id="overdue" class="cell-border stripe" style="width: 100%">
            <thead>
                <tr>
                    <th></th>
                    <th style="text-align: center">Name of Applicant</th>
                    <th style="text-align: center">
                        Name of Retail Water System Or Refiling Station:
                    </th>
                    <th style="text-align: center">
                        Date when scheduling was done:
                    </th>
                    <th style="text-align: center">Date of Inspection:</th>
                    <th style="text-align: center">Application Status:</th>
                    <th style="text-align: center">Application Type:</th>
                    <th style="text-align: center">Actions:</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <!-- <table id="test" class="cell-border stripe" style="width: 100%">
            <thead>
                <tr>
                    <th style="text-align: center">Test</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table> -->
    </div>
</div>

<script
    src="bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.min.js"
    charset="utf-8"
></script>
<script src="//cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
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
</script>
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

    let table = new DataTable("#overdue", {
        ajax: {
            url: "/overdue",
            dataSrc: function (json) {
                var temp,
                    item,
                    data = [];
                for (var i = 0; i < json.initial_application.length; i++) {
                    temp = json.initial_application[i];
                    item = {
                        acceptance_date: temp.acceptance_date,
                        application_status: temp.application_status,
                        application_type: "Initial Application",
                        area_to_serve: temp.area_to_serve,
                        contact_no: temp.contact_no,
                        date_successful: temp.date_successful,
                        email: temp.email,
                        fac_address: temp.fac_address,
                        fac_id: temp.fac_id,
                        fac_licenseno: temp.fac_licenseno,
                        fac_name: temp.fac_name,
                        fac_telphone_no: temp.fac_telphone_no,
                        fname: temp.fname,
                        gender: temp.gender,
                        initapp_id: temp.initapp_id,
                        initial_permit: temp.initial_permit,
                        inspection_date: temp.inspection_date,
                        inspection_form: temp.inspection_form,
                        inspection_id: temp.inspection_id,
                        inspection_status: temp.inspection_status,
                        inspection_type: temp.inspection_type,
                        inspector_date_action: temp.inspector_date_action,
                        inspector_date_reaction: temp.inspector_date_reaction,
                        inspector_date_rejected: temp.inspector_date_rejected,
                        inspector_name: temp.inspector_name,
                        lname: temp.lname,
                        late_date: temp.late_date,
                        late_remarks: temp.late_remarks,
                        latitude: temp.latitude,
                        longitude: temp.longitude,
                        mname: temp.mname,
                        operation_permit: temp.operation_permit,
                        operation_status: temp.operation_status,
                        owner_address: temp.owner_address,
                        owner_name: temp.owner_name,
                        password: temp.password,
                        phone_number: temp.phone_number,
                        reinspection_date: temp.reinspection_date,
                        reinspection_status: temp.reinspection_status,
                        reject_remarks: temp.reject_remarks,
                        role: temp.role,
                        submission_date: temp.submission_date,
                        telephone_number: temp.telephone_number,
                        updated_at: temp.updated_at,
                        user_id: temp.user_id,
                        username: temp.username,
                        water_source_type: temp.water_source_type,
                    };
                    data.push(item);
                }
                for (var i = 0; i < json.operational_application.length; i++) {
                    temp = json.operational_application[i];
                    item = {
                        acceptance_date: temp.acceptance_date,
                        application_status: temp.application_status,
                        application_type: "Operational Application",
                        area_to_serve: temp.area_to_serve,
                        contact_no: temp.contact_no,
                        date_successful: temp.date_successful,
                        email: temp.email,
                        fac_address: temp.fac_address,
                        fac_id: temp.fac_id,
                        fac_licenseno: temp.fac_licenseno,
                        fac_name: temp.fac_name,
                        fac_telphone_no: temp.fac_telphone_no,
                        fname: temp.fname,
                        gender: temp.gender,
                        initial_permit: temp.initial_permit,
                        inspection_date: temp.inspection_date,
                        inspection_form: temp.inspection_form,
                        inspection_id: temp.inspection_id,
                        inspection_status: temp.inspection_status,
                        inspection_type: temp.inspection_type,
                        inspector_date_action: temp.inspector_date_action,
                        inspector_date_reaction: temp.inspector_date_reaction,
                        inspector_date_rejected: temp.inspector_date_rejected,
                        inspector_name: temp.inspector_name,
                        lname: temp.lname,
                        late_date: temp.late_date,
                        late_remarks: temp.late_remarks,
                        latitude: temp.latitude,
                        longitude: temp.longitude,
                        mname: temp.mname,
                        operateapp_id: temp.operateapp_id,
                        operation_permit: temp.operation_permit,
                        operation_status: temp.operation_status,
                        owner_address: temp.owner_address,
                        owner_name: temp.owner_name,
                        password: temp.password,
                        phone_number: temp.phone_number,
                        reinspection_date: temp.reinspection_date,
                        reinspection_status: temp.reinspection_status,
                        reject_remarks: temp.reject_remarks,
                        role: temp.role,
                        submission_date: temp.submission_date,
                        telephone_number: temp.telephone_number,
                        updated_at: temp.updated_at,
                        user_id: temp.user_id,
                        username: temp.username,
                        water_source_type: temp.water_source_type,
                    };
                    data.push(item);
                }
                return data;
            },
        },

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
        ],
        layout: {
            topEnd: {
                search: {
                    text: "Search (using Applicant Name, Facility Name, Date when scheduling was done, or Date of Inspection):",
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
                    $id = "";

                    if (row.application_type == "Initial Application") {
                        $id = row.initapp_id;
                        $application_type = row.application_type;
                    } else {
                        $id = row.operateapp_id;
                        $application_type = row.application_type;
                    }
                    return (
                        '<div id="txtname' +
                        $id +
                        '">' +
                        row.fname +
                        " " +
                        (row.mname != "" && row.mname != null
                            ? row.mname[0]
                            : "") +
                        ". " +
                        row.lname +
                        "</div>" +
                        '<p hidden id="facid' +
                        $id +
                        '">' +
                        row.fac_id +
                        "</p>" +
                        '<p hidden id="inspection_id' +
                        $id +
                        '">' +
                        row.inspection_id +
                        "</p>" +
                        '<p hidden id="txtemail' +
                        $id +
                        '">' +
                        row.email +
                        "</p>" +
                        '<p hidden id="application_type' +
                        $id +
                        '">' +
                        row.application_type +
                        "</p>" +
                        '<p hidden id="txtlateremarks' +
                        $id +
                        '">' +
                        "" +
                        row.late_remarks +
                        "</p>"
                    );
                },
            },
            { data: "fac_name" },
            {
                data: "inspector_date_action",
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
                    return "<div>" + formattedDate + "</div>";
                },
            },
            {
                data: null,
                render: function (data, type, row) {
                    if (
                        row.inspection_status == "Pending Inspection" &&
                        (row.reinspection_status == "" ||
                            row.reinspection_status == null)
                    ) {
                        var dateSplit = row.inspection_date.split("-");
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
                                var current_Date = endDate;
                                startDate < currentDate;
                                startDate.setDate(startDate.getDate() + 1)
                            ) {
                                var day = startDate.getDay();

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

                        var remainingDays =
                            businessDays == 0 ? "Today" : businessDays;

                        $id = "";

                        if (row.application_type == "Initial Application") {
                            $id = row.initapp_id;
                        } else {
                            $id = row.operateapp_id;
                        }

                        return (
                            "<span id='date-inspection" +
                            $id +
                            "'>" +
                            formattedDate +
                            "</span><br/><br/><div value=" +
                            remainingDays +
                            ' id="remaining-days' +
                            $id +
                            '" style="background-color:red;color:white;width:100%;padding:2px">Days overdue for inspection: ' +
                            remainingDays +
                            "</div>"
                        );
                    } else if (
                        row.inspection_status == "Failed Inspection" &&
                        row.reinspection_status == "Pending Reinspection"
                    ) {
                        var dateSplit = row.reinspection_date.split("-");
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
                                var current_Date = endDate;
                                startDate < currentDate;
                                startDate.setDate(startDate.getDate() + 1)
                            ) {
                                var day = startDate.getDay();

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

                        var remainingDays =
                            businessDays == 0 ? "Today" : businessDays;

                        $id = "";

                        if (row.application_type == "Initial Application") {
                            $id = row.initapp_id;
                        } else {
                            $id = row.operateapp_id;
                        }

                        return (
                            "<span id='date-inspection" +
                            $id +
                            "'>" +
                            formattedDate +
                            "</span><br/><br/><div value=" +
                            remainingDays +
                            ' id="remaining-days' +
                            $id +
                            '" style="background-color:red;color:white;width:100%;padding:2px">Days overdue for inspection: ' +
                            remainingDays +
                            "</div>"
                        );
                    }
                },
            },
            {
                data: null,
                searchable: false,
                render: function (data, type, row, meta) {
                    $id = "";

                    if (row.application_type == "Initial Application") {
                        $id = row.initapp_id;
                    } else {
                        $id = row.operateapp_id;
                    }

                    if (
                        row.inspection_status == "Pending Inspection" &&
                        (row.reinspection_status == "" ||
                            row.reinspection_status == null)
                    ) {
                        return (
                            '<div id="txtapp_status' +
                            $id +
                            '">' +
                            row.inspection_status +
                            "</div>"
                        );
                    }
                    if (
                        row.inspection_status == "Failed Inspection" &&
                        row.reinspection_status == "Pending Reinspection"
                    ) {
                        return (
                            '<div id="txtapp_status' +
                            $id +
                            '">' +
                            row.reinspection_status +
                            "</div>"
                        );
                    }
                },
            },
            {
                data: "application_type",
                render: function (data, type, row) {
                    $id = "";

                    if (row.application_type == "Initial Application") {
                        $id = row.initapp_id;
                    } else {
                        $id = row.operateapp_id;
                    }
                    return (
                        '<div id="txtapplication_type' +
                        $id +
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
                    var id = "";

                    if (row.application_type == "Initial Application") {
                        id = row.initapp_id;
                    } else {
                        id = row.operateapp_id;
                    }

                    $inspection_id = row.inspection_id;

                    var inspectionData = {
                        facility_name: row.fac_name,
                        facility_telephone: row.fac_telphone_no,
                        facility_address: row.fac_address,
                        owner_name: row.owner_name,
                    };

                    $(document).on(
                        "click",
                        ".view_checklist-btn",
                        function (e) {
                            e.preventDefault();

                            $id = $(this).attr("id");
                            $("#checklist_data" + $id).val(
                                JSON.stringify(inspectionData)
                            );
                            $("#checklist_form" + $id).submit();

                            // $.ajaxSetup({
                            //     headers: {
                            //         "X-CSRF-TOKEN": $(
                            //             'meta[name="csrf-token"]'
                            //         ).attr("content"),
                            //     },
                            // });

                            // $(".attach-body").html("");

                            // console.log($inspectionData);

                            // $.ajax({
                            //     type: "POST",
                            //     data: $inspectionData,
                            //     dataType: "json",
                            //     url: "/get-checklist/",
                            //     success: function (response) {
                            //         console.log(response.message)
                            //     },
                            // });
                        }
                    );

                    return (
                        '<div style="display:flex; justify-content:space-evenly">' +
                        '<form id="checklist_form' +
                        $id +
                        '" action="/get-checklist/" target="_blank" method="POST" style="margin-right:1px;">@csrf<input id="checklist_data' +
                        $id +
                        '" type="hidden" name="data"/><button type="submit" id=' +
                        id +
                        ' class="view_checklist-btn btn" class="btn" style="background-color:#0D6EFD; color:white; margin-right:1px;">View checklist form</button></form>' +
                        "<button value=" +
                        $id +
                        " id=" +
                        $id +
                        ' name="viewattachments" class="view_attach-btn btn" style="background-color:#0D6EFD; color:white; margin-right:1px;" type="button" class="btn" data-toggle="modal" data-target="#modalViewAttachments">View Attachments</button>' +
                        "<button  value=" +
                        $id +
                        " id=" +
                        $id +
                        ' name="passedInspection" class="passed_inspect-btn btn btn-success" class="btn btn-success" data-toggle="modal" data-target="#modalPass" style="margin-right:1px" type="button">Passed</button>' +
                        "<button  value=" +
                        $id +
                        " id=" +
                        $id +
                        ' name="failedInspection" class="failed_inspect-btn btn btn-danger" class="btn btn-danger" data-toggle="modal" data-target="#modalFail" type="button">Failed</button></div>'
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

        var id = $(this).attr("id");

        var application_type = $("#txtapplication_type" + id).text();

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $(".attach-body").html("");

        if (application_type == "Initial Application") {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/get-init-attachment/" + id,
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
        }

        if (application_type == "Operational Application") {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/get-op-attachment/" + id,
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
        }
    });

    $(document).ready(function () {
        $("#alert-message")
            .fadeTo(5000, 500)
            .slideUp(500, function () {
                $("#alert-message").slideUp(500);
            });

        $("#alert-success")
            .fadeTo(5000, 500)
            .slideUp(500, function () {
                $("#alert-success").slideUp(500);
            });

        $("#alert-warning")
            .fadeTo(5000, 500)
            .slideUp(500, function () {
                $("#alert-warning").slideUp(500);
            });
    });

    $(document).on("click", ".passed_inspect-btn", function (e) {
        $id = $(".passed_inspect-btn").attr("id");

        // var inspectionDate = new Date($("#date-inspection" + $id).text());
        // inspectionDate.setHours(0, 0, 0, 0);
        // inspectionDate.setUTCDate(inspectionDate.getUTCDate() + 1);

        // var formattedDate = inspectionDate.toISOString().split("T")[0];

        // $("#passdateInspect").attr("min", formattedDate);
        // $("#passdateInspect").attr("value", formattedDate);
        $inspectionID = $("#inspection_id" + $id).text();

        $("#passed-application_id").text($id);

        var date_late = $("#remaining-days" + $id).text();
        $("#schedule-late-submission").html(
            "Action for this application has been overdue for: " +
                date_late +
                " days. " +
                "<br/>" +
                "You must give a reason for being late:"
        );

        $("#passInspect").attr("action", "update-inspection/" + $inspectionID);
    });

    $(document).on("click", ".failed_inspect-btn", function (e) {
        $id = $(".failed_inspect-btn").attr("id");

        // var inspectionDate = new Date($("#date-inspection" + $id).text());
        // inspectionDate.setHours(0, 0, 0, 0);
        // inspectionDate.setUTCDate(inspectionDate.getUTCDate() + 1);

        // var formattedDate = inspectionDate.toISOString().split("T")[0];

        // $("#faildateInspect").attr("min", formattedDate);
        // $("#faildateInspect").attr("value", formattedDate);

        $inspectionID = $("#inspection_id" + $id).text();

        $("#failed-application_id").text($id);

        var date_late = $("#remaining-days" + $id).text();
        $("#failed-late-submission").html(
            "Action for this application has been overdue for: " +
                date_late +
                " days. " +
                "<br/>" +
                "You must give a reason for being late:"
        );

        $id = $("#failed-application_id").text();

        $("#failInspect").attr("action", "update-inspection/" + $inspectionID);
    });

    //Button for refreshing the list of facilities in the datatable
    $(document).on("click", ".refresh_btn", function (e) {
        table.ajax.reload();
    });

    $("#btn-pass").click(function (e) {
        $id = $("#passed-application_id").text();

        //For getting the applicant's name
        var applicant_name = $("#txtname" + $id).text();

        var emailData = {
            name: applicant_name,
            email: $("#txtemail" + $id).text(),
            application_status: "Passed",
            application_type: $("#application_type" + $id)
                .text()
                .toLowerCase(),
            reject_remarks: "",
            inspection_date: "",
            // inspection_date: $(this).closest($('input[name=scheduleDate]')).val()
        };

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
    });

    $("#btn-fail").click(function (e) {
        $id = $("#failed-application_id").text();

        //For getting the applicant's name
        var applicant_name = $("#txtname" + $id).text();

        var emailData = {
            name: applicant_name,
            email: $("#txtemail" + $id).text(),
            application_status: "Failed",
            application_type: $("#application_type" + $id)
                .text()
                .toLowerCase(),
            reject_remarks: $("#failtxtRemarks").val(),
            inspection_date: "",
            // inspection_date: $(this).closest($('input[name=scheduleDate]')).val()
        };

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
    });

    // Add event listener for opening and closing details for the table childrow
    table.on("click", "td.dt-control", function (e) {
        let tr = e.target.closest("tr");
        let row = table.row(tr);

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
