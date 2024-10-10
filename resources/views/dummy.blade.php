@extends('layouts.app')

@section('content')

<div class="div-content">

    <div class="table-card">
        <span>
            <h5 class="table-title">List of Facilities to be inspected:</h5><br />

            <div>
                <label>Choose type of transaction:</label> <select type="submit" name="apptype" id="apptype">
                    <option value="initapp">Initial Application</option>
                    <option value="opapp">Operational Application</option>
                </select>
            </div>
            <br />
        </span>

        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th></th>
                    <th>Applicant Name</th>
                    <th>Facility Name</th>
                    <th>Facility License No:</th>
                    <th>Actions</th>
                </tr>
            </thead>
            {{-- <tbody>
                @foreach($initapps as $key=>$initapp)
                <tr data-child-name="{{$key}}" data-child-value={{$initapp}}>
                    <td></td>
                    <td>{{$initapp['Client']->firstname}} {{$initapp['Client']->mi}} {{$initapp['Client']->lastname}}
                    </td>
                    <td>{{$initapp->fac_name}}</td>
                    <td class="common-td td-content p-4 pe-0 ps-0">{{$initapp->fac_licenseno}}</td>
                    <td class="td-content p-4 pe-0 ps-0"><button id="{{$key}}" name="showremarks"
                            class="inspector-btn btn btn-primary">Remarks</button><br />
                        <textarea id="txtremarks{{$key}}" class="inspectorRmrks"
                            type="text">{{$initapp->remarks}}</textarea>
                        <button class="inspector-btn btn btn-primary">Accept</button>
                        <button class="inspector-btn btn btn-primary">Reject</button>
                    </td>
                </tr>
                @endforeach
            </tbody> --}}
        </table>
    </div>
</div>

<script>
    $(function(){
        $("#opapp").hide();

        $("#apptype").on('change', function(){
            if($(this).val()=="initapp"){
                $("#initappTable").show();
                $("#opapp").hide();
            }
            else{
                $("#initappTable").hide();
                $("#opapp").show();
            }
        })
    });

    $(function(){
        $('button[name=showremarks]').click(function(){
        var id= $(this).attr("id");

            $("#txtremarks"+id).toggle();

            if($("#txtremarks"+id).is(":hidden")){
                var textbox = "#txtremarks"+id;
                // console.log("remarks is updated");
                // console.log(textbox);
            }
        });
    });

    $(function(){
        if($(this).val()=="initappTable"){
                console.log("You're now searching on initapp")
        }
        $("#apptype").on('change', function(){
            if($(this).val()=="initapp"){
                console.log("You're now searching on initapp")
            }
            else{
                console.log("You're now searching on optapp")
            }
        })
    });

</script>

<script>

    // var dataSet = '<?php echo json_encode($initapps) ?>';
    // var jsonParsed = JSON.parse(dataSet);
    // var formattedObject = {
    //     data: jsonParsed
    // };

    // console.log(formattedObject)
</script>
<script src="//cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
{{-- <script>
    let table = new DataTable('#example');
</script> --}}

<script>
    //For javascript
    // new DataTable('#myTable')

    // For jquery
    // $('#myTable').DataTable();

    // var dataSet = {{url("/getapps")}};

    // Formatting function for row details - modify as you need
    // function format(d) {
    // // `d` is the original data object for the row
    //     return (
    //         '<dl>' +
    //         '<dt>Phone Number:</dt>' +
    //         '<dd>' +
    //         d.phone_number +
    //         '</dd>' +
    //         '<dt>Water Source Type:</dt>' +
    //         '<dd>' +
    //         d.water_source_type +
    //         '</dd>' +
    //         '<dt>Application Status:</dt>' +
    //         '<dd>And any further details here (images etc)...</dd>' +
    //         '</dl>'
    //     );
    // }

    // function format(d) {
    //     // `d` is the original data object for the row
    //     return (
    //         '<dl>' +
    //         '<dt>Full name:</dt>' +
    //         '<dd>' +
    //         d.name +
    //         '</dd>' +
    //         '<dt>Extension number:</dt>' +
    //         '<dd>' +
    //         d.extn +
    //         '</dd>' +
    //         '<dt>Extra info:</dt>' +
    //         '<dd>And any further details here (images etc)...</dd>' +
    //         '</dl>'
    //     );
    // }

    // $.ajax({
    //     url: 'http://127.0.0.1:8000/getapps',
    //     type: 'GET',
    //     success: function(data){
    //         // console.log(data)
    //         $.each(data, function (indexInArray, valueOfElement) {
    //              console.log(valueOfElement[0].client.firstname)
    //         });
    //     },
    //     error: function(jqXHR, textStatus, errorThrown) {
    //         console.error("Error fetching data:", textStatus, errorThrown);
    //     }
    // });

    //data for facility:
    // facility telephone no, facility address,
    // latitude, longitude, area to server, water source type,
    // inital permit availability,
    // owner address, phone number, owner telephone number,
    // submission date, remarks, application status,

    // function format (d) {
    //     // $.each(d, function (indexInArray, valueOfElement) {
    //     //     console.log(valueOfElement)
    //     // });
    //     // console.log(value)
    //     return (
    //         '<div>Facility Telephone Number: '+d+'</div>'
    //     );
    // }

    var dataSet = '<?php echo json_encode($initapps) ?>';

    // console.log(dataSet);

    $.ajax({
        'url': "http://127.0.0.1:8000/objects.txt",
        'method': "GET",
        'contentType': 'application/json'
    }).done(function(data){
        console.log(data)
    });

    let table = new DataTable('#example', {
        columns: [
            {
                className: 'dt-control',
                orderable: true,
                aaData: dataSet,
                defaultContent: ''
            },
            { data: 'initapp_id' },
            { data: 'fac_id'},
            { data: 'fac_name'},
            { data: 'fac_address'}
            ],
            order: [[1, 'asc']]
        });

    // let table = new DataTable('#example', {
    // ajax: '/objects.txt',
    // columns: [
    //     {
    //         className: 'dt-control',
    //         orderable: false,
    //         data: null,
    //         defaultContent: ''
    //     },
    //     { data: 'name' },
    //     { data: 'position' },
    //     { data: 'office' },
    //     { data: 'salary' }
    // ],
    // order: [[1, 'asc']]
    // });

    // Add event listener for opening and closing details
    table.on('click', 'td.dt-control', function (e) {
        let tr = e.target.closest('tr');
        let row = table.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
        }
        else {
            // Open this row
            row.child(format(row.data())).show();
            // row.child(format(tr.data('child-name'), tr.data('child-value'))).show();
        }

        // console.log(row.child(format(row.data())))
    });
</script>

{{-- <script>
    //For javascript
    // new DataTable('#myTable')

    // For jquery
    // $('#myTable').DataTable();

    // var dataSet = {{url("/getapps")}};

    // Formatting function for row details - modify as you need
    function format (name, value) {
    return '<div>Name: ' + name + '<br />Value: ' + value + '</div>';
    }

    $('#example').DataTable({
    columns: [
        {
            className: 'dt-control',
            orderable: false,
            data: null,
            defaultContent: ''
        },
        { data: 'name' },
        { data: 'position' },
        { data: 'office' },
        { data: 'salary' }
        ],
        order: [[1, 'asc']]
    });

    // Add event listener for opening and closing details
    $('#example').on('click', 'td.dt-control', function (e) {
    let tr = e.target.closest('tr');
    let row = this.row(tr);

    if (row.child.isShown()) {
        // This row is already open - close it
        row.child.hide();
    }
    else {
        // Open this row
        row.child(format(tr.data('child-name'), tr.data('child-value'))).show();
    }
});
</script> --}}
@endsection
