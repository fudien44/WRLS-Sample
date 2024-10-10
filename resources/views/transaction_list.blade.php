@extends('layouts.auth')
@section('content')


 <!-- Page Heading -->
 <h1 class="h3 mb-2 text-gray-800">Transaction List</h1>
 

 <!-- DataTales Example -->
 <div class="accordion" id="accordionExample">
    {{-- Initial Transactions --}}
    <div class="card shadow mb-4">
        <div class="card-header border-left-primary shadow h-100 py-2" id="headingOne">
            <h2 class="mb-0">
              <button class="btn  btn-block text-left " type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Initial Application
              </button>
            </h2>
          </div>
          <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
          <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr align="center" >
                            {{-- <th style="vertical-align: middle;">Owner Name</th> --}}
                            <th style="vertical-align: middle;">Facility Name</th>
                            <th style="vertical-align: middle;">Location</th>
                            <th style="vertical-align: middle;">Water Source</th>
                            <th style="vertical-align: middle;">Contact No.</th>
                            <th style="vertical-align: middle;">Area to be Served</th>
                            <th style="vertical-align: middle;">Date Submitted</th>
                            <th style="vertical-align: middle;">Application Status</th>
                            <th style="vertical-align: middle;">Attachments</th>
                            {{-- <th style="vertical-align: middle;">Initial Application Form</th>
                            <th style="vertical-align: middle;">Order of Payment</th> --}}
                            <th style="vertical-align: middle;">Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                       @foreach($datainitial as $item)
                       <tr>
                           {{-- <td>{{ $item->owner_name }}</td> --}}
                           <td>{{ $item->fac_name }}</td>
                           <td>{{ $item->fac_address }}</td>
                           <td>{{ isset($waterSourceTypes[$item->water_source_type]) ? $waterSourceTypes[$item->water_source_type] : 'Unknown' }}</td>
                           <td>{{ $item->telephone_number ?? 'N/A' }}</td>
                           <td align="center">{{ $item->area_to_serve }}</td>
                           <td>{{ $item->initialApplication->submission_date ?? 'N/A' }}</td>
                           <td align="center">{{$item->initialApplication->application_status ?? 'N/A'}}</td>
                           
                           <td align="center">
                            <!-- Button to trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAttach{{$item->fac_id}}">
                                View
                            </button>
                            </td>
                            {{-- <td align="center">
                                <a href="{{ route('generate.pdf', ['fac_id' => $item->fac_id]) }}" class="btn btn-success">Download</a>
                            </td>
                            <td align="center">
                                <a href="{{ route('orderpayment.wrs', ['fac_id' => $item->fac_id]) }}" class="btn btn-success">Download</a>
                            </td> --}}
                            <td align="center">
                                <div class="dropdown mb-2">
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fas fa-fw fa-file-pdf"></i>Download
                                    </button>
                                    <div class="dropdown-menu animated--fade-in"
                                        aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{ route('orderpayment.wrs', ['fac_id' => $item->fac_id]) }}">Order of Payment</a>
                                        <a class="dropdown-item" href="{{ route('initialform', ['fac_id' => $item->fac_id]) }}">Application Form</a>
                                        
                                    </div>
                                </div>
                                <div class="dropdown mb-4">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu animated--fade-in"
                                        aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="/">Ready for Operational</a>
                                        <a class="dropdown-item" href="">Application Form</a>
                                        <form action="{{ route('send.email') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Send Email to Client</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>

                       
                   @endforeach
                   
                    </tbody>
                     
                </table>
                
            </div>
            <!-- Pagination Links -->
            {{ $datainitial->links() }}
        </div>
          </div>
    </div>

    {{-- Operational Transactions --}}
    <div class="card shadow mb-4">
        <div class="card-header border-left-success shadow h-100 py-2" id="headingTwo">
            <h2 class="mb-0">
              <button class="btn  btn-block text-left " type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                Operational Application
              </button>
            </h2>
          </div>
          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
          <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr align="center" >
                            <th style="vertical-align: middle;">Operational Control No.</th>
                            <th style="vertical-align: middle;">Facility Name</th>
                            <th style="vertical-align: middle;">Location</th>
                            <th style="vertical-align: middle;">Water Source</th>
                            <th style="vertical-align: middle;">Contact No.</th>
                            <th style="vertical-align: middle;">Area to be Served</th>
                            <th style="vertical-align: middle;">Date Submitted</th>
                            <th style="vertical-align: middle;">Application Status</th>
                            <th style="vertical-align: middle;">Attachments</th>
                            <th style="vertical-align: middle;">Operational Application Form</th>
                            
                            {{-- <th style="vertical-align: middle;">Order of Payment</th> --}}
                        </tr>
                    </thead>
                    
                    <tbody>
                       @foreach($dataopera as $opera)
                       <tr>
                           
                           <td>{{ $opera->fac_name }}</td>
                           <td>{{ $opera->fac_address }}</td>
                           <td>{{ isset($waterSourceTypes[$opera->water_source_type]) ? $waterSourceTypes[$opera->water_source_type] : 'Unknown' }}</td>
                           <td>{{ $opera->telephone_number }}</td>
                           <td align="center">{{ $opera->area_to_serve }}</td>
                           <td>{{ $opera->initialApplication->submission_date ?? 'N/A' }}</td>
                           <td align="center">{{$opera->operateApplication->application_status ?? 'N/A'}}</td>
                           <td align="center">
                            <!-- Button to trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalOperaAttach{{$opera->fac_id}}">
                                View
                            </button>
                            </td>
                            <td align="center">
                                <a href="{{ route('operationalform', ['fac_id' => $opera->fac_id]) }}" class="btn btn-success">Download</a>
                            </td>
                           
                           
                         
                           <!-- Add more columns as needed -->
                       </tr>
                   @endforeach
                   
                    </tbody>
                </table>
            </div>
            {{ $dataopera->links() }}
        </div>
          </div>
    </div>
 </div>

 <!-- Modal for initial-->
 @foreach($datainitial as $item)
 <div class="modal fade" id="modalAttach{{$item->fac_id}}" tabindex="-1" role="dialog" aria-labelledby="modalAttachLabel{{$item->fac_id}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAttachLabel{{$item->fac_id}}">Uploaded Attachments</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                @foreach($dataAttachment as $attach)
                    @if($attach->initapp_id == $item->initialApplication->initapp_id)
                    <ul class="list-group">
                        <!-- Certificate of Potability -->
                        <li class="list-group-item">
                            <button class="btn btn-info dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseCOP{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseCOP{{$item->fac_id}}">Certificate of Potability</button>
                            <div class="collapse" id="collapseCOP{{$item->fac_id}}">
                                <div class="card card-body">
                                    {{-- <iframe src="{{  asset('storage/attachments/' . $item->fac_name . '/' . $attach->cert_pot . '.pdf') }}" width="100%" height="500px"></iframe> --}}
                                    
                                    <iframe src="{{ asset('storage/' . $attach->cert_pot) }}" width="100%" height="500px"></iframe>
                
                                   
                                </div>
                            </div>
                        </li>

                        <!-- Sanitary Survey of Water -->
                        <li class="list-group-item">
                            <button class="btn btn-info dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseSanitary{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseSanitary{{$item->fac_id}}">
                                Sanitary Survey of Water Source
                            </button>
                            <div class="collapse" id="collapseSanitary{{$item->fac_id}}">
                                <div class="card card-body">
                                   
                                    <iframe src="{{ asset('storage/' . $attach->sanitary_survey) }}" width="100%" height="500px"></iframe>
                                    
                                    {{-- <iframe src="storage/attachments/{{$item->fac_name}}/{{$attach->sanitary_survey}}.pdf" width="100%" height="500px"></iframe> --}}
                                </div>
                            </div>
                        </li>

                        <!-- Drinking Water Site Clearance -->
                        <li class="list-group-item">
                            <button class="btn btn-info dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseSite{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseSite{{$item->fac_id}}">
                                Drinking Water Site Clearance
                            </button>
                            <div class="collapse" id="collapseSite{{$item->fac_id}}">
                                <div class="card card-body">
                                    
                                    <iframe src="{{ asset('storage/' . $attach->watersite_clearance) }}" width="100%" height="500px"></iframe>
                                    {{-- <iframe src="{{ asset('storage/' . $attach->site_clearance) }}" width="100%" height="500px"></iframe> --}}
                                    {{-- <iframe src="storage/attachments/{{$item->fac_name}}/{{$attach->site_clearance}}.pdf" width="100%" height="500px"></iframe> --}}
                                </div>
                            </div>
                        </li>

                        <!-- Engineer’s Report -->
                        <li class="list-group-item">
                            <button class="btn btn-info dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseEngineer{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseEngineer{{$item->fac_id}}">
                                Engineer’s Report
                            </button>
                            <div class="collapse" id="collapseEngineer{{$item->fac_id}}">
                                <div class="card card-body">
                                    <iframe src="{{ asset('storage/' . $attach->engineers_report) }}" width="100%" height="500px"></iframe>
                                    {{-- <iframe src="storage/attachments/{{$item->fac_name}}/{{$attach->engineer_report}}.pdf" width="100%" height="500px"></iframe> --}}
                                </div>
                            </div>
                        </li>

                        <!-- Plans and Specifications -->
                        <li class="list-group-item">
                            <button class="btn btn-info dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapsePlan{{$item->fac_id}}" aria-expanded="false" aria-controls="collapsePlan{{$item->fac_id}}">
                                Plans and Specifications
                            </button>
                            <div class="collapse" id="collapsePlan{{$item->fac_id}}">
                                <div class="card card-body">
                                    <iframe src="{{ asset('storage/' . $attach->plans_specs) }}" width="100%" height="500px"></iframe>
                                    {{-- <iframe src="storage/attachments/{{$item->fac_name}}/{{$attach->plans_specifications}}.pdf" width="100%" height="500px"></iframe> --}}
                                </div>
                            </div>
                        </li>
                    </ul>
                    @endif
                @endforeach
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
 
 @endforeach

 {{-- Modal for Operational --}}
 @foreach($dataopera as $opera)
 <div class="modal fade" id="modalOperaAttach{{$opera->fac_id}}" tabindex="-1" role="dialog" aria-labelledby="modalOperAttachLabel{{$opera->fac_id}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalOperAttachLabel{{$opera->fac_id}}">Uploaded Attachments</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                @foreach($operaAttachment as $attach)
                    @if($attach->operateapp_id == $opera->operateApplication->operateapp_id)
                    <ul class="list-group">
                        <!-- Certificate of Potability -->
                        <li class="list-group-item">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseLOI{{$opera->fac_id}}" aria-expanded="false" aria-controls="collapseLOI{{$opera->fac_id}}">
                                Letter of Intent to be Address to ARISTIDES CONCEPCION TAN, MD, MPH, CESO III</button>
                            <div class="collapse" id="collapseLOI{{$opera->fac_id}}">
                                <div class="card card-body">
                                    {{-- <iframe src="{{  asset('storage/attachments/' . $item->fac_name . '/' . $attach->cert_pot . '.pdf') }}" width="100%" height="500px"></iframe> --}}
                                    
                                    <iframe src="{{ asset('storage/' . $attach->letter_intent) }}" width="100%" height="500px"></iframe>
                
                                   
                                </div>
                            </div>
                        </li>

                        <!-- Sanitary Survey of Water -->
                        <li class="list-group-item">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseCOC{{$opera->fac_id}}" aria-expanded="false" aria-controls="collapseCOC{{$opera->fac_id}}">
                                Certificate of completion (given by private sanitary engineer)
                            </button>
                            <div class="collapse" id="collapseCOC{{$opera->fac_id}}">
                                <div class="card card-body">
                                   
                                    <iframe src="{{ asset('storage/' . $attach->cert_completion) }}" width="100%" height="500px"></iframe>
                                    
                                    {{-- <iframe src="storage/attachments/{{$item->fac_name}}/{{$attach->sanitary_survey}}.pdf" width="100%" height="500px"></iframe> --}}
                                </div>
                            </div>
                        </li>

                        <!-- Drinking Water Site Clearance -->
                        <li class="list-group-item">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseCOP{{$opera->fac_id}}" aria-expanded="false" aria-controls="collapseCOP{{$opera->fac_id}}">
                                Certificate of Endorsement if water district – water source / Certificate of Potability if Deep Well Source
                            </button>
                            <div class="collapse" id="collapseCOP{{$opera->fac_id}}">
                                <div class="card card-body">
                                    
                                    <iframe src="{{ asset('storage/' . $attach->cert_pot) }}" width="100%" height="500px"></iframe>
                                    {{-- <iframe src="{{ asset('storage/' . $attach->site_clearance) }}" width="100%" height="500px"></iframe> --}}
                                    {{-- <iframe src="storage/attachments/{{$item->fac_name}}/{{$attach->site_clearance}}.pdf" width="100%" height="500px"></iframe> --}}
                                </div>
                            </div>
                        </li>

                        <!-- Engineer’s Report -->
                        <li class="list-group-item">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseCert{{$opera->fac_id}}" aria-expanded="false" aria-controls="collapseCert{{$opera->fac_id}}">
                                40 hours training (certification course for water refilling station and plant operators and workshop on water safety plan development)
                            </button>
                            <div class="collapse" id="collapseCert{{$opera->fac_id}}">
                                <div class="card card-body">
                                    <iframe src="{{ asset('storage/' . $attach->cert_training) }}" width="100%" height="500px"></iframe>
                                    {{-- <iframe src="storage/attachments/{{$item->fac_name}}/{{$attach->engineer_report}}.pdf" width="100%" height="500px"></iframe> --}}
                                </div>
                            </div>
                        </li>

                        <!-- Plans and Specifications -->
                        <li class="list-group-item">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseXerox{{$opera->fac_id}}" aria-expanded="false" aria-controls="collapseXerox{{$opera->fac_id}}">
                                Xerox copy of Initial Permit of Water Refilling station
                            </button>
                            <div class="collapse" id="collapseXerox{{$opera->fac_id}}">
                                <div class="card card-body">
                                    <iframe src="{{ asset('storage/' . $attach->xerox_init_permit) }}" width="100%" height="500px"></iframe>
                                    {{-- <iframe src="storage/attachments/{{$item->fac_name}}/{{$attach->plans_specifications}}.pdf" width="100%" height="500px"></iframe> --}}
                                </div>
                            </div>
                        </li>
                    </ul>
                    @endif
                @endforeach
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
 
 @endforeach


 
@endsection
<script>
document.addEventListener('DOMContentLoaded', function() {
    const accordion = document.querySelectorAll('#accordionExample .collapse');

    // Restore the state of the accordion
    accordion.forEach((collapse) => {
        const collapseId = collapse.id;
        const isCollapsed = localStorage.getItem(collapseId) === 'true';
        
        if (isCollapsed) {
            $(collapse).collapse('hide');
        } else {
            $(collapse).collapse('show');
        }
    });

    // Save the state of the accordion when it's toggled
    $('#accordionExample').on('show.bs.collapse hide.bs.collapse', function (e) {
        const collapseId = e.target.id;
        localStorage.setItem(collapseId, e.type === 'hide');
    });
});
</script>