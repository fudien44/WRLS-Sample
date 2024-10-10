<!DOCTYPE html>
<html>

<head>
    <title>Welcome to EmailerApp</title>
</head>

<body>
    <h1>Hello from Department of Health - CHD XII!</h1>
    <p>Good day {{$name}} ({{$email}}),

    <p>We would like to inform you that your {{$application_type}} for licensing of your water refilling facility/station
        @if($application_status=="For visitation")
        is {{strtolower($application_status)}}.
    <p>We hereby request that you prepare any and all important documents for inspection in your facility.
        The date of your inspection will be on {{$inspection_date}}.
    </p>
    @elseif($application_status == "Passed")
    has {{strtolower($application_status)}} the inspection for {{strtolower($application_type)}}.
    <p>We will inform you when the permit will be available to release.</p>
    @elseif($application_status == "Failed")
    has {{strtolower($application_status)}} the inspection for getting the {{strtolower($application_type)}} due to
    "{{strtolower($reject_remarks)}}".
    @else
    <p>{{$application_status}} due to "{{$reject_remarks}}" on "{{$inspector_date_rejected}}".</p>
    <br />
    <p>We hereby request that you comply the missing documents/requirements in order for us to proceed with you
        application.</p>
    @endif</p>
    </p>

    <p>We hope you have a nice day ahead!</p>
    <p>Sincerely,</p>
    <p>Department of Health - Center for Health Development</p>
    <p>SOCCSKSARGEN Region</p>
</body>

</html>
