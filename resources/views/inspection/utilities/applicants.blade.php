@extends('layouts.auth')
<!-- Link for bootstrap-datepicker -->
<link rel="stylesheet" href="bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker.min.css" />
@section('content') @if($errors->any())
    <div id="alert-message" class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif @if (session('message'))
    <div id="alert-success" class="alert alert-success">
        {{ session("message") }}
    </div>
@endif

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">List of all Facilities</h1>
</div>
<div class="div-content">
    <!-- Passed modal -->
    <div class="modal fade" id="modalPass" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passFailTitle">
                        Passed Inspection Form
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="schedule-body modal-body">
                    <form id="passInspect" method="post" action="update-inspection/{facid}"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="text" id="passtype" name="inspectResult" value="Passed" hidden />
                        <div class="mb-3" style="vertical-align: center">
                            Date when inspection completed:
                            <input type="date" id="passdateInspect" name="inspectionDate" required />
                        </div>

                        <div style="vertical-align: center">
                            Remarks/Discrepancies:
                        </div>
                        <textarea id="txtremarks" type="text" name="inspectionRemarks"
                            class="inspectionRmrks"></textarea>
                        <div class="mb-3 mt-3">
                            <label for="formFile" class="form-label">Upload inspector checklist:</label>
                            <input class="form-control" name="checklist" type="file" id="formFile" required />
                        </div>
                        <input type="submit" class="btn btn-primary" />
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel btn btn-secondary" data-dismiss="modal"
                        style="width: 25%; height: 50%; margin-top: 10px">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Failed modal -->
    <div class="modal fade" id="modalFail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passFailTitle">
                        Failed Inspection Form
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="schedule-body modal-body">
                    <form id="failInspect" method="post" action="update-inspection/{facid}"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="text" id="failtype" name="inspectResult" value="Failed" hidden />
                        <div class="mb-3" style="vertical-align: center">
                            Date when inspection completed:
                            <input type="date" id="faildateInspect" name="inspectionDate" required />
                        </div>

                        <div style="vertical-align: center">
                            Remarks/Discrepancies:
                        </div>
                        <textarea id="failtxtRemarks" type="text" name="inspectionRemarks" class="inspectionRmrks"
                            required></textarea>
                        <div class="mb-3 mt-3">
                            <label for="formFile" class="form-label">Upload inspector checklist:</label>
                            <input class="form-control" name="checklist" type="file" id="failformFile" required />
                        </div>
                        <input type="submit" class="btn btn-primary" />
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel btn btn-secondary" data-dismiss="modal"
                        style="width: 25%; height: 50%; margin-top: 10px">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- View attachment modal -->
    <div class="modal fade" id="modalViewAttachments" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        Application Attachments:
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="attach-body modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel btn btn-secondary" data-dismiss="modal"
                        style="width: 25%; height: 50%; margin-top: 10px">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="table-card">
        <button type="button" class="refresh_btn btn btn-primary" style="width: fit-content; margin-bottom: 10px">
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
                    <th style="text-align: center">Date of Visit:</th>
                    <th style="text-align: center">Application Status:</th>
                    <th style="text-align: center">Application Type:</th>
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

<script src="bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.min.js" charset="utf-8"></script>
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

    let table = new DataTable("#overdue", {
        ajax: {
            url: "/get-facilities",
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
                        firstname: temp.firstname,
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
                        lastname: temp.lastname,
                        late_date: temp.late_date,
                        late_remarks: temp.late_remarks,
                        latitude: temp.latitude,
                        longitude: temp.longitude,
                        mi: temp.mi,
                        operation_permit: temp.operation_permit,
                        operation_status: temp.operation_status,
                        owner_address: temp.owner_address,
                        owner_name: temp.owner_name,
                        password: temp.password,
                        phone_number: temp.phone_number,
                        reinspection_date: temp.reinspection_date,
                        reinspection_status: temp.reinspection_status,
                        remarks: temp.remarks,
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
                        firstname: temp.firstname,
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
                        lastname: temp.lastname,
                        late_date: temp.late_date,
                        late_remarks: temp.late_remarks,
                        latitude: temp.latitude,
                        longitude: temp.longitude,
                        mi: temp.mi,
                        operateapp_id: temp.operateapp_id,
                        operation_permit: temp.operation_permit,
                        operation_status: temp.operation_status,
                        owner_address: temp.owner_address,
                        owner_name: temp.owner_name,
                        password: temp.password,
                        phone_number: temp.phone_number,
                        reinspection_date: temp.reinspection_date,
                        reinspection_status: temp.reinspection_status,
                        remarks: temp.remarks,
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
                        row.firstname +
                        " " +
                        row.mi[0] +
                        ". " +
                        row.lastname +
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
                        "</p>" +
                        '<p hidden id="application_typ' +
                        $application_type +
                        '">' +
                        row.email +
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
                data: "inspection_date",
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
                        "</span>"
                        // <br/><br/><div value=" +
                        // remainingDays +
                        // ' id="remaining-days' +
                        // $id +
                        // '" style="background-color:red;color:white;width:100%;padding:2px">Days overdue for inspection: ' +
                        // remainingDays +
                        // "</div>"

                        //     //Current day of the month
                        // const currentDate = new Date($.now());

                        // function getBusinessDaysCount(startDate, endDate) {
                        //     var workingDays = 0;
                        //     for (
                        //         var current_Date = endDate;
                        //         startDate < currentDate;
                        //         startDate.setDate(startDate.getDate() + 1)
                        //     ) {
                        //         var day = startDate.getDay();

                        //         if (day !== 0 && day !== 6) {
                        //             // Exclude Sundays (0) and Saturdays (6)
                        //             workingDays++;

                        //             // Optional: Check for holidays (replace with your logic)
                        //             // if (isHoliday(current_Date)) {
                        //             //   workingDays--;
                        //             // }
                        //         }
                        //     }
                        //     return workingDays;
                        // }

                        // var newCurrentDate = new Date(formattedDate).setDate(new Date(formattedDate).getDate() + 1);
                        // var businessDays = getBusinessDaysCount(
                        //     new Date(newCurrentDate),
                        //     currentDate
                        // );

                        // var remainingDays =
                        //     businessDays == 0 ? "Today" : businessDays;
                    );
                },
            },
            {
                data: "date_successful", render: function (data, type, row) {
                    var dateSplit = data.split("-");
                    var formattedDate =
                        type === "display" || type === "filter"
                            ? dateSplit[1] +
                            "/" +
                            dateSplit[2] +
                            "/" +
                            dateSplit[0]
                            : data;
                    return ('<div>' + formattedDate + '</div>')
                }
            },
            {
                data: "application_status",
            },
            {
                data: "application_type",
            },
            {
                data: "null",
                width: "20%",
                searchable: false,
                sortable: false,
                render: function (data, type, row, meta) {

                    $ids = [row.initapp_id, row.opapp_id];

                    return (
                        '<div style="display:flex; justify-content:space-evenly">' +
                        "<button value=" +
                        $ids +
                        ' name="viewattachments" class="view_attach-btn btn" style="background-color:#0D6EFD; color:white; margin-right:1px;" type="button" class="btn" data-toggle="modal" data-target="#modalViewAttachments"><i class="fas fa-fw fa-file-alt"></i>View Attachments</button>' +
                        "<button value=" +
                        $ids +
                        ' name="print" class="print-btn btn" style="background-color:#0D6EFD; color:white; margin-right:1px;" type="button" class="btn"><i class="fas fa-fw fa-print"></i><span>Print</span></button>'
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

        var ids = $(this).attr("value").split(',');

        var initapp_id = ids[0];

        var opapp_id = ids[1];

        var data = {
            initapp_id: initapp_id,
            opapp_id: opapp_id
        };

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $(".attach-body").html("");

        $.ajax({
            type: "POST",
            dataType: "json",
            data: data,
            url: "/get-attachments",
            success: function (response) {
                console.log(response)
                if (
                    response.message ==
                    "Error with retrieving the attachments from the database"
                ) {
                    $(".attach-body").append(
                        "<div>There's currently no attachments sent by this individual</div>"
                    );
                }
                if(response.message.initchecklist != "" && response.message.initchecklist != null){
                    var attachment = response.message.initchecklist;

                        $(".attach-body").append(
                            `<a href='{{url('${attachment}')}}' target="_blank" class='btn-view-letter btn btn-primary'>Initial Application Checklist Form</a>`
                        );
                }
                else{
                    $(".attach-body").append(
                        "<div>No operational checklist form</div>"
                    );
                }
                if (response.message.initattachment != "" && response.message.initattachment != null) {

                    if (response.message.initattachment.cert_pot) {
                        var attachment = response.message.initattachment.cert_pot;

                        $(".attach-body").append(
                            `<a href='{{url('${attachment}')}}' target="_blank" class='btn-view-certPot btn btn-primary'>Letter to the Director</a>`
                        );
                    }
                    if (response.message.initattachment.sanitary_survey) {
                        var attachment = response.message.initattachment.sanitary_survey;

                        $(".attach-body").append(
                            `<a href='{{url('${attachment}')}}' target="_blank" class='btn-view-sanSurvey btn btn-primary'>Letter to the Director</a>`
                        );
                    }
                    if (response.message.initattachment.watersite_clearance) {
                        var attachment = response.message.initattachment.watersite_clearance;

                        $(".attach-body").append(
                            `<a href='{{url('${attachment}')}}' target="_blank" class='btn-view-watClear btn btn-primary'>Letter to the Director</a>`
                        );
                    }
                    if (response.message.initattachment.engineers_report) {
                        var attachment = response.message.initattachment.engineers_report;

                        $(".attach-body").append(
                            `<a href='{{url('${attachment}')}}' target="_blank" class='btn-view-engRep btn btn-primary'>Letter to the Director</a>`
                        );
                    }
                    if (response.message.initattachment.plans_specs) {
                        var attachment = response.message.initattachment.plans_specs;

                        $(".attach-body").append(
                            `<a href='{{url('${attachment}')}}' target="_blank" class='btn-view-plansSpecs btn btn-primary'>Letter to the Director</a>`
                        );
                    }
                    if (response.message.initattachment.application_form) {
                        var attachment = response.message.initattachment.application_form;

                        $(".attach-body").append(
                            `<a href='{{url('${attachment}')}}' target="_blank" class='btn-view-appform btn btn-primary'>Letter to the Director</a>`
                        );
                    }
                    if (response.message.initattachment.letter) {
                        var attachment = response.message.initattachment.letter;

                        $(".attach-body").append(
                            `<a href='{{url('${attachment}')}}' target="_blank" class='btn-view-letter btn btn-primary'>Letter to the Director</a>`
                        );
                    }
                }else{
                    $(".attach-body").append(
                        "<div>No initial application attachments</div>"
                    );
                }
                if(response.message.operchecklist != "" && response.message.operchecklist != null){
                    var attachment = response.message.operchecklist ;

                        $(".attach-body").append(
                            `<a href='{{url('${attachment}')}}' target="_blank" class='btn-view-letter btn btn-primary'>Operational Application Checklist Form</a>`
                        );
                }
                else{
                    $(".attach-body").append(
                        "<div>No operational checklist form</div>"
                    );
                }
                if(response.message.operattachment != "" && response.message.operattachment != null){
                    if (response.message.operattachment.letter_intent) {
                        var attachment = response.message.operattachment.letter_intent;

                        $(".attach-body").append(
                            `<a href='{{url('${attachment}')}}' target="_blank" class='btn-view-letter btn btn-primary'>Letter of Intent</a>`
                        );
                    }
                    if (response.message.operattachment.cert_completion) {
                        var attachment = response.message.operattachment.cert_completion;

                        $(".attach-body").append(
                            `<a href='{{url('${attachment}')}}' target="_blank" class='btn-view-letter btn btn-primary'>Certificate of Completion</a>`
                        );
                    }
                    if (response.message.operattachment.cert_pot) {
                        var attachment = response.message.operattachment.cert_pot;

                        $(".attach-body").append(
                            `<a href='{{url('${attachment}')}}' target="_blank" class='btn-view-letter btn btn-primary'>Certificate of Potability</a>`
                        );
                    }
                    if (response.message.operattachment.cert_training) {
                        var attachment = response.message.operattachment.cert_training;

                        $(".attach-body").append(
                            `<a href='{{url('${attachment}')}}' target="_blank" class='btn-view-letter btn btn-primary'>Certificate of Training</a>`
                        );
                    }
                    if (response.message.operattachment.xerox_init_permit) {
                        var attachment = response.message.operattachment.xerox_init_permit;

                        $(".attach-body").append(
                            `<a href='{{url('${attachment}')}}' target="_blank" class='btn-view-letter btn btn-primary'>Xerox of initial permit</a>`
                        );
                    }
                }else{
                    $(".attach-body").append(
                        "<div>No operational application attachments</div>"
                    );
                }
            },
        });
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
    });

    $(document).on("click", ".passed_inspect-btn", function (e) {
        $id = $(".passed_inspect-btn").attr("id");
        var inspectionDate = new Date($("#date-inspection" + $id).text());
        inspectionDate.setHours(0, 0, 0, 0);
        inspectionDate.setUTCDate(inspectionDate.getUTCDate() + 1);

        var formattedDate = inspectionDate.toISOString().split("T")[0];

        $("#passdateInspect").attr("min", formattedDate);
        $("#passdateInspect").attr("value", formattedDate);
        $inspectionID = $("#inspection_id" + $id).text();
        $("#passInspect").attr("action", "update-inspection/" + $inspectionID);
    });

    $(document).on("click", ".failed_inspect-btn", function (e) {
        $id = $(".failed_inspect-btn").attr("id");
        var inspectionDate = new Date($("#date-inspection" + $id).text());
        inspectionDate.setHours(0, 0, 0, 0);
        inspectionDate.setUTCDate(inspectionDate.getUTCDate() + 1);

        var formattedDate = inspectionDate.toISOString().split("T")[0];

        $("#faildateInspect").attr("min", formattedDate);
        $("#faildateInspect").attr("value", formattedDate);
        $inspectionID = $("#inspection_id" + $id).text();
        $("#failInspect").attr("action", "update-inspection/" + $inspectionID);
    });

    //Button for refreshing the list of facilities in the datatable
    $(document).on("click", ".refresh_btn", function (e) {
        table.ajax.reload();
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