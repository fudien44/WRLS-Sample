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

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">List of all Facilities</h1>
</div>
<div class="div-content">
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

<script
    src="bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.min.js"
    charset="utf-8"
></script>
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
                        row.fname +
                        " " +
                        (row.mname != "" && row.mname != null
                            ? row.mname[0]
                            : "") +
                        ". " +
                        row.lname +
                        "</div>"
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
                    var date = (row.reinspection_date != "" && row.reinspection_date != null) ? row.reinspection_date : row.inspection_date;

                    var dateSplit = date.split("-");
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
                    );
                },
            },
            {
                data: "date_successful",
                render: function (data, type, row) {
                    return "<div>" + data + "</div>";
                },
            },
            {
                data: "application_status",
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
                    $id = "";

                    if (row.application_type == "Initial Application") {
                        $id = row.initapp_id;
                    } else {
                        $id = row.operateapp_id;
                    }

                    return (
                        '<div style="display:flex; justify-content:space-evenly">' +
                        "<button value=" +
                        $id +
                        ' name="viewattachments" class="view_attach-btn btn" style="background-color:#0D6EFD; color:white; margin-right:1px;" type="button" class="btn" data-toggle="modal" data-target="#modalViewAttachments"><i class="fas fa-fw fa-file-alt"></i>View Attachments</button>'
                        // +
                        // "<button value=" +
                        // $ids +
                        // ' name="print" class="print-btn btn" style="background-color:#0D6EFD; color:white; margin-right:1px;" type="button" class="btn"><i class="fas fa-fw fa-print"></i><span>Print</span></button>'
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

        var id = $(this).attr("value");

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
            console.log("Operational Application");
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