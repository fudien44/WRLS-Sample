@extends('layouts.auth')
@section('content')
@if (session('success'))
<script>
    $(document).ready(function() {
        toastr.success('{{ session('success') }}', 'Success', {
            closeButton: true,
            progressBar: true,
            timeOut: 5000,
        });
    });
</script>
@endif

@if ($errors->any())
<script>
    $(document).ready(function() {
        toastr.error('{{ session('error') }}', 'Something went wrong. Contact your IT Administrator.', {
            closeButton: true,
            progressBar: true,
            timeOut: 5000,
        });
    });
</script>
@endif

<!-- Error Message -->
@if (session('error'))
    <script>
        $(document).ready(function() {
            toastr.error('{{ session('error') }}', 'Error', {
                closeButton: true,
                progressBar: true,
                timeOut: 5000,
            });
        });
    </script>
@endif
 <!-- Page Heading -->

 <style>
     .invalid-field, .invalid-file {
    border: 2px solid red !important;
    outline: none;
}

input[type="file"].invalid-file::file-selector-button {
    border: 2px solid red !important;
}

    .validation-message {
    font-size: 1rem;
    color: #d9534f; /* Red color for the message */
    font-weight: bold;
    display: none; /* Initially hidden */
}
    .dropdown-item.text-danger {
        color: #dc3545; /* Bootstrap danger color */
    }

    .dropdown-item.text-danger:hover {
        background-color: #f8d7da; /* Light red background on hover */
        color: #721c24; /* Dark red text color on hover */
    }

   

    .dropdown-item.text-info:hover {
        background-color: #9ae2e7; 
    }
</style>

 <!-- DataTales Example -->
 <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="h3 mb-2 text-gray-800">Initial Transaction List</h6>
    </div>
          <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr align="center" >
                            <th style="vertical-align: middle;">Facility Name</th>
                            <th style="vertical-align: middle;">Owner</th>
                            <th style="vertical-align: middle;">Location</th>
                            <th style="vertical-align: middle;">Water Source</th>
                            <th style="vertical-align: middle;">Contact No.</th>
                            <th style="vertical-align: middle;">Area to be Served</th>
                            <th style="vertical-align: middle;">Date Submitted</th>
                            <th style="vertical-align: middle;">Application Status</th>
                            <th style="vertical-align: middle;">Attachments</th> 
                            <th style="vertical-align: middle;">Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                       @forelse($datainitial as $item)
                       <tr>
                           <td>{{ $item->fac_name }}</td>
                           <td>{{ $item->owner_name }}</td>
                           <td>{{ $item->fac_address }}</td>
                           <td>{{ isset($waterSourceTypes[$item->water_source_type]) ? $waterSourceTypes[$item->water_source_type] : 'Unknown' }}</td>
                           <td>{{ $item->telephone_number ?? 'N/A' }}</td>
                           <td align="center">{{ $item->area_to_serve }}</td>
                           <td>
                            {{ $item->initialApplication ? \Carbon\Carbon::parse($item->initialApplication->submission_date)->format('F j, Y') : 'N/A' }}
                           </td>
                            <td align="center">
                                @if($item->initialApplication->application_status === 'In Process') 
                                <div class="alert-primary" role="alert" style="border: 1px solid #cce5ff; border-radius: 5px; padding: 10px 15px; margin-bottom: 10px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                    <i class="fas fa-spinner" style="margin-right: 10px; font-size: 1.2em;"></i>
                                    {{$item->initialApplication->application_status ?? 'N/A'}}
                                </div>
                                @elseif($item->initialApplication->application_status === 'For Reattachment')
                                    <div class="alert-danger" role="alert" style="border: 1px solid #f5c6cb; border-radius: 5px; padding: 10px 15px; margin-bottom: 10px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                        <i class="fas fa-exclamation-circle" style="margin-right: 10px; font-size: 1.2em;"></i>
                                        {{$item->initialApplication->application_status ?? 'N/A'}}
                                    </div>
                                @elseif($item->initialApplication->application_status === 'For Payment')
                                    <div class="alert-warning" role="alert" style="border: 1px solid #ffeeba; border-radius: 5px; padding: 10px 15px; margin-bottom: 10px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                        <i class="fas fa-dollar-sign" style="margin-right: 10px; font-size: 1.2em;"></i>
                                        {{$item->initialApplication->application_status ?? 'N/A'}}
                                    </div>
                                @elseif($item->initialApplication->application_status === 'In Process of Payment')
                                    <div class="alert-info" role="alert" style="border: 1px solid #bee5eb; border-radius: 5px; padding: 10px 15px; margin-bottom: 10px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                        <i class="fas fa-credit-card" style="margin-right: 10px; font-size: 1.2em;"></i>
                                        {{$item->initialApplication->application_status ?? 'N/A'}}
                                    </div>
                                @elseif($item->initialApplication->application_status === 'For Scheduling')
                                    <div class="alert-secondary" role="alert" style="border: 1px solid #d6d8db; border-radius: 5px; padding: 10px 15px; margin-bottom: 10px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                        <i class="fas fa-calendar-alt" style="margin-right: 10px; font-size: 1.2em;"></i>
                                        {{$item->initialApplication->application_status ?? 'N/A'}}
                                    </div>
                                    @elseif($item->initialApplication->application_status === 'For visitation')
                                    <div class="alert-warning" role="alert" style="border: 1px solid #d6d8db; border-radius: 5px; padding: 10px 15px; margin-bottom: 10px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                        <i class="fas fa-eye" style="margin-right: 10px; font-size: 1.2em;"></i>
                                        {{$item->initialApplication->application_status ?? 'N/A'}}
                                    </div>
                                    @elseif($item->initialApplication->application_status === 'Rejected')
                                    <div class="alert-danger" role="alert" style="border: 1px solid #d6d8db; border-radius: 5px; padding: 10px 15px; margin-bottom: 10px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                        <i class="fas fa-times-circle" style="margin-right: 10px; font-size: 1.2em;"></i>
                                        {{$item->initialApplication->application_status ?? 'N/A'}}
                                    </div>
                                    @elseif($item->initialApplication->application_status === 'Awaiting issuance of initial permit')
                                    <div class="alert-primary" role="alert" style="border: 1px solid #d6d8db; border-radius: 5px; padding: 10px 15px; margin-bottom: 10px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                        <i class="fas fa-file-alt" style="margin-right: 10px; font-size: 1.2em;"></i>
                                        {{$item->initialApplication->application_status ?? 'N/A'}}
                                    </div>
                                    @elseif($item->initialApplication->application_status === 'Failed Inspection')
                                    <div class="alert-danger" role="alert" style="border: 1px solid #d6d8db; border-radius: 5px; padding: 10px 15px; margin-bottom: 10px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                        <i class="fas fa-exclamation-circle" style="margin-right: 10px; font-size: 1.2em;"></i>
                                        {{$item->initialApplication->application_status ?? 'N/A'}}
                                    </div>
                                    @elseif($item->initialApplication->application_status === 'For Reinspection')
                                    <div class="alert-warning" role="alert" style="border: 1px solid #d6d8db; border-radius: 5px; padding: 10px 15px; margin-bottom: 10px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                        <i class="fas fa-redo" style="margin-right: 10px; font-size: 1.2em;"></i>
                                        {{$item->initialApplication->application_status ?? 'N/A'}}
                                    </div>
                                @elseif($item->initialApplication->application_status === 'For Issuance')
                                    <div class="alert-info" role="alert" style="border: 1px solid #bee5eb; border-radius: 5px; padding: 10px 15px; margin-bottom: 10px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                        <i class="fas fa-file-alt" style="margin-right: 10px; font-size: 1.2em;"></i>
                                        {{$item->initialApplication->application_status ?? 'N/A'}}
                                    </div>
                                @elseif($item->initialApplication->application_status === 'Initial Permit Available')
                                    <div class="alert-success" role="alert" style="border: 1px solid #c3e6cb; border-radius: 5px; padding: 10px 15px; margin-bottom: 10px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                        <i class="fas fa-check-circle" style="margin-right: 10px; font-size: 1.2em;"></i>
                                        {{$item->initialApplication->application_status ?? 'N/A'}}
                                    </div>
                                @endif
                            </td>
                           <td align="center">

                            <div class="dropdown mb-2">
                                <button class="btn btn-primary dropdown-toggle position-relative" type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fas fa-paperclip"></i> 
                                </button>
                                <div class="dropdown-menu animated--fade-in"
                                        aria-labelledby="dropdownMenuButton">
                            <!-- Button to trigger modal -->
                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#modalAttach{{$item->fac_id}}"   onmouseover="this.style.backgroundColor='#e0e0e0';" 
                                onmouseout="this.style.backgroundColor='';">
                                View
                            </button>
                            {{-- application form upload --}}
                            {{-- @foreach($dataAttachment as $attach) --}}
                            {{-- @if(is_null($attach->application_form)) --}}
                            <form action="{{ route('initialform.upload') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="initapp_id" value="{{ $item->initialApplication->initapp_id }}">
                                <label class="dropdown-item" for="application_form{{$item->initialApplication->initapp_id}}" 
                                    onmouseover="this.style.backgroundColor='#e0e0e0';" 
                                    onmouseout="this.style.backgroundColor='';" style="cursor: pointer; margin-bottom: 1px;">
                                 Upload Application Form
                             </label>
                             <input type="file" id="application_form{{$item->initialApplication->initapp_id}}" name="application_form" style="display: none;" accept="application/pdf" onchange="this.form.submit();">
                            </form>
                            {{-- @endif --}}
                            {{-- @endforeach --}}
                            {{-- reattach button --}}
                            @if(auth()->user()->role_id === 4 || $item->initialApplication->application_status === 'For Reattachment')
                                <button type="button" class="dropdown-item text-danger" data-toggle="modal" data-target="#modalReAttach{{$item->fac_id}}">
                                    Reattach
                                </button>
                            @endif
                            @if(auth()->user()->role_id === 4 || $item->initialApplication->application_status === 'For Payment')
                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#modalPayment{{$item->fac_id}}" onmouseover="this.style.backgroundColor='#e0e0e0';" 
                                onmouseout="this.style.backgroundColor='';">
                                 Order of Payment
                            </button>
                            @endif
                                </div>
                            </div>

                            </td>
                            <td align="center">
                                {{-- Download Button --}}
                                <div class="dropdown mb-2">
                                    <button class="btn btn-primary dropdown-toggle position-relative" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fas fa-download"></i> Download
                                    </button>
                                    <div class="dropdown-menu animated--fade-in"
                                        aria-labelledby="dropdownMenuButton">
                                        @if($item->initialApplication->application_status === 'For Payment' || auth()->user()->role_id === 4)
                                        <a class="dropdown-item" href="{{ route('orderpayment.wrs', ['fac_id' => $item->fac_id]) }}" onmouseover="this.style.backgroundColor='#e0e0e0';" 
                                            onmouseout="this.style.backgroundColor='';"><i class="fas fa-fw fa-file-pdf"></i> Order of Payment.pdf
                                        </a>
                                        @endif
                                        <a class="dropdown-item" href="{{ route('initialform', ['fac_id' => $item->fac_id]) }}" onmouseover="this.style.backgroundColor='#e0e0e0';" 
                                            onmouseout="this.style.backgroundColor='';"><i class="fas fa-fw fa-file-pdf"></i> Application Form.pdf</a>
                                        
                                    </div>
                                </div>
                                {{-- Edit Button --}}
                                @if(auth()->user()->role_id === 4 || auth()->user()->role_id === 2)
                                <div class="dropdown mb-2">
                                    <button class="btn btn-warning dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false    ">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <div class="dropdown-menu animated--fade-in"
                                        aria-labelledby="dropdownMenuButton">
                                        <button class="dropdown-item" type="button"  onmouseover="this.style.backgroundColor='#e0e0e0';" 
                                            onmouseout="this.style.backgroundColor='';">Edit</button>
                                        <form id="delete-form-{{ $item->fac_id }}" action="{{ route('facility.delete', $item->fac_id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item text-danger" type="button" onclick="confirmDelete({{ $item->fac_id }})" >Delete</button>
                                        </form>
                                    </div>
                                </div>
                               
                                {{-- Update Application Status --}}
                                <div class="dropdown mb-2">
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fas fa-sync"></i> Update Application Status
                                    </button>
                                    <div class="dropdown-menu animated--fade-in"
                                        aria-labelledby="dropdownMenuButton">
                                        <form action="{{ route('email.orderpayment') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="fac_id" value="{{ $item->fac_id }}"> 
                                            <button type="submit" class="dropdown-item" onmouseover="this.style.backgroundColor='#e0e0e0';" 
                                            onmouseout="this.style.backgroundColor='';">For Order of Payment</button>
                                        </form>
                                        <form action="{{ route('email.inspection') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="fac_id" value="{{ $item->fac_id }}"> 
                                            <button type="submit" class="dropdown-item" onmouseover="this.style.backgroundColor='#e0e0e0';" 
                                            onmouseout="this.style.backgroundColor='';">For Scheduling of Inspection</button>
                                        </form>
                                        <form action="{{ route('email.issuance') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="fac_id" value="{{ $item->fac_id }}"> 
                                            <button type="submit" class="dropdown-item" onmouseover="this.style.backgroundColor='#e0e0e0';" 
                                            onmouseout="this.style.backgroundColor='';">Ongoing Issuance of Permit</button>
                                        </form>
                                        <form action="{{ route('email.initial') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="fac_id" value="{{ $item->fac_id }}">
                                            <button type="submit" class="dropdown-item" onmouseover="this.style.backgroundColor='#e0e0e0';" 
                                            onmouseout="this.style.backgroundColor='';">Initial Permit Available</button>
                                        </form>
                                    </div>
                                </div>
                                @endif

                                {{-- Generate Initial Permit --}}
                                @if(auth()->user()->role_id === 4)

                                <div class="dropdown mb-2">
                                    <button class="btn btn-success dropdown-toggle position-relative" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fas fa-check"></i> Initial Permit
                                    </button>
                                    <div class="dropdown-menu animated--fade-in"
                                        aria-labelledby="dropdownMenuButton">
                                        <button class="dropdown-item " type="button" data-toggle="modal" data-target="#modalViewPermit{{$item->fac_id}}"  onmouseover="this.style.backgroundColor='#e0e0e0';" 
                                            onmouseout="this.style.backgroundColor='';">View</button>

                                            <button class="dropdown-item " type="button" data-toggle="modal" data-target="#modalAttachPermit{{$item->fac_id}}"  onmouseover="this.style.backgroundColor='#e0e0e0';" 
                                                onmouseout="this.style.backgroundColor='';">Upload</button>
                                        
                                            <button class="dropdown-item " type="button" data-toggle="modal" data-target="#modalPermit{{$item->fac_id}}"  onmouseover="this.style.backgroundColor='#e0e0e0';" 
                                                onmouseout="this.style.backgroundColor='';">Generate</button>
                                        
                                    </div>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">No data to display</td>
                        </tr>
                    @endforelse
                  
                   
                    </tbody>
                     
                </table>
                
            </div>
           
        </div>
 </div>
         
 <!-- Modal for view attachment-------------------------------------------------------------------------------------->
 @foreach($datainitial as $item)
<div class="modal fade" id="modalAttach{{$item->fac_id}}" tabindex="-1" role="dialog" aria-labelledby="modalAttachLabel{{$item->fac_id}}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAttachLabel{{$item->fac_id}}">Uploaded Attachments</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                   <!-- Summary Section -->
                   @php
                   $allApproved = true;
               @endphp

               @foreach($dataAttachment as $attach)
                   @if($attach->initapp_id == $item->initialApplication->initapp_id)
                     
                       @if(!$attach->is_application_form_validated || !$attach->is_cert_pot_validated || !$attach->is_sanitary_survey_validated || !$attach->is_watersite_clearance_validated || !$attach->is_engineers_report_validated || !$attach->is_plans_specs_validated)
                           @php
                               $allApproved = false;
                           @endphp
                       @endif
                   @endif
               @endforeach
               @if($allApproved)
               <div class="alert alert-success" role="alert">
                       All attachments have already been approved. 
                       @if($item->initialApplication->application_status === 'In Process' && $item->initialApplication->application_status === 'For Reattachment')
                       Ready to proceed for payment.
                       @endif
               </div>
               @endif
                <ul class="list-group">
                    @foreach($dataAttachment as $attach)
                    @if($attach->initapp_id == $item->initialApplication->initapp_id)
                    
                    <!-- Application Form -->
                    
                    <li class="list-group-item mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-info dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseSAF{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseSAF{{$item->fac_id}}">
                               Signed Application Form
                            </button>
                            @if($attach->is_application_form_validated === 1)
                            <!-- Display status and no buttons if already approved -->
                            <span class="text-success font-weight-bold">Approved</span>
                        @elseif($attach->is_application_form_validated === 0)
                            <!-- Display status and no buttons if already rejected -->
                            <span class="text-danger font-weight-bold">Rejected</span>
                            @endif
                        </div>
                        <div class="collapse mt-2" id="collapseSAF{{$item->fac_id}}">
                            @if($attach->application_form)
                            <!-- Display iframe if file is present -->
                            <iframe src="{{ asset('storage/' . $attach->application_form) }}" width="100%" height="700px"></iframe>
                            @else
                            <div class="alert alert-warning d-flex align-items-center" role="alert">
                                <i class="fas fa-exclamation-circle mr-2"></i> <!-- FontAwesome icon for a warning -->
                                <span class="font-weight">File not uploaded yet. Please upload the application form.</span>
                            </div>
                            @endif
                           <div class="btn-container">
                        @if(auth()->user()->role_id === 4 || auth()->user()->role_id === 2)
                            @if(is_null($attach->is_application_form_validated))
                                @if($attach->application_form)
                                <!-- Display buttons if not yet approved or rejected -->
                                <button class="btn btn-lg btn-success btn-approve" data-attachment-id="{{ $attach->initattach_id }}" data-field="application_form" type="button"><i class="fas fa-check"></i></button>
                                <button class="btn btn-lg btn-danger btn-reject" data-attachment-id="{{ $attach->initattach_id }}" data-field="application_form" type="button"><i class="fas fa-times"></i></button>
                                @endif
                            @endif
                        @endif
                        </div>
                        </div>
                        
                    </li>
                    
                    <!-- Certificate of Potability -->
                    <li class="list-group-item mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-info dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseCOP{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseCOP{{$item->fac_id}}">
                                Certificate of Potability
                            </button>
                            @if($attach->is_cert_pot_validated === 1)
                            <!-- Display status and no buttons if already approved -->
                            <span class="text-success font-weight-bold">Approved</span>
                             @elseif($attach->is_cert_pot_validated === 0)
                            <!-- Display status and no buttons if already rejected -->
                            <span class="text-danger font-weight-bold">Rejected</span>
                            @endif
                        </div>
                        <div class="collapse mt-2" id="collapseCOP{{$item->fac_id}}">
                            <iframe src="{{ asset('storage/' . $attach->cert_pot) }}" width="100%" height="700px"></iframe>
                            <div class="btn-container">
                             @if(is_null($attach->is_cert_pot_validated))
                                    <!-- Display buttons if not yet approved or rejected -->
                                    <button class="btn btn-lg btn-success btn-approve" data-attachment-id="{{ $attach->initattach_id }}" data-field="cert_pot" type="button"><i class="fas fa-check"></i></button>
                                    <button class="btn btn-lg btn-danger btn-reject" data-attachment-id="{{ $attach->initattach_id }}" data-field="cert_pot" type="button"><i class="fas fa-times"></i></button>
                                @endif
                            </div>
                        </div>
                       
                    </li>

                    <!-- Sanitary Survey of Water -->
                    <li class="list-group-item mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseSanitary{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseSanitary{{$item->fac_id}}">
                            Sanitary Survey of Water Source
                        </button>
                      @if($attach->is_sanitary_survey_validated === 1)
                                <!-- Display status and no buttons if already approved -->
                          <span class="text-success font-weight-bold">Approved</span>
                      @elseif($attach->is_sanitary_survey_validated === 0)
                                <!-- Display status and no buttons if already rejected -->
                          <span class="text-danger font-weight-bold">Rejected</span>
                      @endif
                        </div>
                        <div class="collapse mt-2" id="collapseSanitary{{$item->fac_id}}">
                            <iframe src="{{ asset('storage/' . $attach->sanitary_survey) }}" width="100%" height="700px"></iframe>
                            <div class="btn-container">
                                
                                 @if(is_null($attach->is_sanitary_survey_validated))
                                    <!-- Display buttons if not yet approved or rejected -->
                                    <button class="btn btn-lg btn-success btn-approve" data-attachment-id="{{ $attach->initattach_id }}" data-field="sanitary_survey" type="button"><i class="fas fa-check"></i></button>
                                    <button class="btn btn-lg btn-danger btn-reject" data-attachment-id="{{ $attach->initattach_id }}" data-field="sanitary_survey" type="button"><i class="fas fa-times"></i></button>
                                @endif
                            </div>
                        </div>
                    </li>

                    <!-- Drinking Water Site Clearance -->
                    <li class="list-group-item mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseSite{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseSite{{$item->fac_id}}">
                            Drinking Water Site Clearance
                        </button>
                        @if($attach->is_watersite_clearance_validated === 1)
                        <!-- Display status and no buttons if already approved -->
                        <span class="text-success font-weight-bold">Approved</span>
                         @elseif($attach->is_watersite_clearance_validated === 0)
                        <!-- Display status and no buttons if already rejected -->
                        <span class="text-danger font-weight-bold">Rejected</span>
                        @endif
                        </div>
                        <div class="collapse mt-2" id="collapseSite{{$item->fac_id}}">
                            <iframe src="{{ asset('storage/' . $attach->watersite_clearance) }}" width="100%" height="700px"></iframe>
                            <div class="btn-container">
                               
                                 @if(is_null($attach->is_watersite_clearance_validated))
                                    <!-- Display buttons if not yet approved or rejected -->
                                    <button class="btn btn-lg btn-success btn-approve" data-attachment-id="{{ $attach->initattach_id }}" data-field="watersite_clearance" type="button"><i class="fas fa-check"></i></button>
                                    <button class="btn btn-lg btn-danger btn-reject" data-attachment-id="{{ $attach->initattach_id }}" data-field="watersite_clearance" type="button"><i class="fas fa-times"></i></button>
                                @endif
                            </div>
                        </div>
                    </li>

                    <!-- Engineer’s Report -->
                    <li class="list-group-item mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-info dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseEngineer{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseEngineer{{$item->fac_id}}">
                            Engineer’s Report
                        </button>
                        @if($attach->is_engineers_report_validated === 1)
                        <!-- Display status and no buttons if already approved -->
                        <span class="text-success font-weight-bold">Approved</span>
                         @elseif($attach->is_engineers_report_validated === 0)
                        <!-- Display status and no buttons if already rejected -->
                        <span class="text-danger font-weight-bold">Rejected</span>
                        @endif
                        </div>
                        <div class="collapse mt-2" id="collapseEngineer{{$item->fac_id}}">
                            <iframe src="{{ asset('storage/' . $attach->engineers_report) }}" width="100%" height="700px"></iframe>
                            <div class="btn-container">
                               
                                 @if(is_null($attach->is_engineers_report_validated))
                                    <!-- Display buttons if not yet approved or rejected -->
                                    <button class="btn btn-lg btn-success btn-approve" data-attachment-id="{{ $attach->initattach_id }}" data-field="engineers_report" type="button"><i class="fas fa-check"></i></button>
                                    <button class="btn btn-lg btn-danger btn-reject" data-attachment-id="{{ $attach->initattach_id }}" data-field="engineers_report" type="button"><i class="fas fa-times"></i></button>
                                @endif
                            </div>
                        </div>
                    </li>

                    <!-- Plans and Specifications -->
                    <li class="list-group-item mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapsePlan{{$item->fac_id}}" aria-expanded="false" aria-controls="collapsePlan{{$item->fac_id}}">
                            Plans and Specifications
                        </button>
                        @if($attach->is_plans_specs_validated === 1)
                                <!-- Display status and no buttons if already approved -->
                                <span class="text-success font-weight-bold">Approved</span>
                                 @elseif($attach->is_plans_specs_validated === 0)
                                <!-- Display status and no buttons if already rejected -->
                                <span class="text-danger font-weight-bold">Rejected</span>
                                @endif
                     </div>
                        <div class="collapse mt-2" id="collapsePlan{{$item->fac_id}}">
                            <iframe src="{{ asset('storage/' . $attach->plans_specs) }}" width="100%" height="700px"></iframe>
                            <div class="btn-container">
                                
                                 @if(is_null($attach->is_plans_specs_validated))
                                    <!-- Display buttons if not yet approved or rejected -->
                                    <button class="btn btn-lg btn-success btn-approve" data-attachment-id="{{ $attach->initattach_id }}" data-field="plans_specs" type="button"><i class="fas fa-check"></i></button>
                                    <button class="btn btn-lg btn-danger btn-reject" data-attachment-id="{{ $attach->initattach_id }}" data-field="plans_specs" type="button"><i class="fas fa-times"></i></button>
                                @endif
                            </div>
                        </div>
                    </li>

                    {{-- <!-- Order of Payment -->
                    <li class="list-group-item mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapsepayment{{$item->fac_id}}" aria-expanded="false" aria-controls="collapsepayment{{$item->fac_id}}">
                            Signed Order of Payment
                        </button>
                        </div>
                        <div class="collapse mt-2" id="collapsepayment{{$item->fac_id}}">
                            <iframe src="{{ asset('storage/' . $attach->order_payment) }}" width="100%" height="700px"></iframe>
                            <button class="btn btn-lg btn-success btn-approve" data-attachment-id="{{ $attach->initattach_id }}" data-field="order_payment" type="button"><i class="fas fa-check"></i></button>
                           <button class="btn btn-lg btn-danger btn-reject" data-attachment-id="{{ $attach->initattach_id }}" data-field="order_payment" type="button"><i class="fas fa-times"></i></button>
                        </div>
                    </li>

                    <!-- Official Receipt -->
                    <li class="list-group-item mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-info dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseOR{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseOR{{$item->fac_id}}">
                            Official Receipt
                        </button>
                        </div>
                        <div class="collapse mt-2" id="collapseOR{{$item->fac_id}}">
                            <iframe src="{{ asset('storage/' . $attach->attach_OR) }}" width="100%" height="700px"></iframe>
                            <button class="btn btn-lg btn-success btn-approve" data-attachment-id="{{ $attach->initattach_id }}" data-field="attach_OR" type="button"><i class="fas fa-check"></i></button>
                           <button class="btn btn-lg btn-danger btn-reject" data-attachment-id="{{ $attach->initattach_id }}" data-field="attach_OR" type="button"><i class="fas fa-times"></i></button>
                        </div>
                    </li> --}}
                    @endif
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                @if((auth()->user()->role_id === 4 || auth()->user()->role_id === 2) 
                    && ($item->initialApplication->application_status === 'In Process' || $item->initialApplication->application_status === 'For Reattachment'))
                    <form action="{{ route('email.orderpayment') }}" method="POST">
                        @csrf
                        <input type="hidden" name="fac_id" value="{{ $item->fac_id }}">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Proceed for Payment</button>
                    </form>
                    <form action="{{ route('email.reattach') }}" method="POST">
                        @csrf
                        <input type="hidden" name="fac_id" value="{{ $item->fac_id }}">
                    <button type="submit" class="btn btn-danger" >
                        <i class="fas fa-times"></i> Reject
                    </button>
                </form>
                @endif
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
{{-- Modal for ReUpload-------------------------------------------------------------------------- --}}
@foreach($datainitial as $item)
<div class="modal fade" id="modalReAttach{{$item->fac_id}}" tabindex="-1" role="dialog" aria-labelledby="modalReAttachLabel{{$item->fac_id}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('attachments.reupload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalReAttachLabel{{$item->fac_id}}">Re-Upload Attachments</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="initapp_id" value="{{ $item->initialApplication->initapp_id }}">
                    @foreach($dataAttachment as $attach)
                        @if($attach->initapp_id == $item->initialApplication->initapp_id)
                        <ul class="list-group">
                            @if($attach->is_application_form_validated === 0)
                            <!-- Signed Application Form -->
                            <li class="list-group-item">
                                <button class="btn btn-danger dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseSAF{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseSAF{{$item->fac_id}}">
                                    Signed Application Form
                                </button>
                                <div class="collapse" id="collapseSAF{{$item->fac_id}}">
                                    <div class="card card-body">
                                        @if($attach->application_form)
                                            <p>Current File: <a href="{{ asset('storage/' . $attach->application_form) }}" target="_blank">View</a></p>
                                        @endif
                                        <input type="file" class="form-control-file" id="application_form" name="application_form" accept="application/pdf" onchange="validateFileType(this)">
                                    </div>
                                </div>
                            </li>
                            @endif
                            @if($attach->is_cert_pot_validated === 0)
                            <!-- Certificate of Potability -->
                            <li class="list-group-item">
                                <button class="btn btn-danger dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseCOP{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseCOP{{$item->fac_id}}">
                                    Certificate of Potability
                                </button>
                                <div class="collapse" id="collapseCOP{{$item->fac_id}}">
                                    <div class="card card-body">
                                        @if($attach->cert_pot)
                                            <p>Current File: <a href="{{ asset('storage/' . $attach->cert_pot) }}" target="_blank">View</a></p>
                                        @endif
                                        <input type="file" class="form-control-file" id="cert_pot" name="cert_pot" accept="application/pdf" onchange="validateFileType(this)">
                                    </div>
                                </div>
                            </li>
                            @endif
                            @if($attach->is_sanitary_survey_validated === 0)
                            <!-- Sanitary Survey of Water -->
                            <li class="list-group-item">
                                <button class="btn btn-danger dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseSanitary{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseSanitary{{$item->fac_id}}">
                                    Sanitary Survey of Water Source
                                </button>
                                <div class="collapse" id="collapseSanitary{{$item->fac_id}}">
                                    <div class="card card-body">
                                        @if($attach->sanitary_survey)
                                            <p>Current File: <a href="{{ asset('storage/' . $attach->sanitary_survey) }}" target="_blank">View</a></p>
                                        @endif
                                        <input type="file" class="form-control-file" id="sanitary_survey" name="sanitary_survey" accept="application/pdf" onchange="validateFileType(this)">
                                    </div>
                                </div>
                            </li>
                            @endif
                            @if($attach->is_watersite_clearance_validated === 0)
                            <!-- Drinking Water Site Clearance -->
                            <li class="list-group-item">
                                <button class="btn btn-danger dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseSite{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseSite{{$item->fac_id}}">
                                    Drinking Water Site Clearance
                                </button>
                                <div class="collapse" id="collapseSite{{$item->fac_id}}">
                                    <div class="card card-body">
                                        @if($attach->watersite_clearance)
                                            <p>Current File: <a href="{{ asset('storage/' . $attach->watersite_clearance) }}" target="_blank">View</a></p>
                                        @endif
                                        <input type="file" class="form-control-file" id="watersite_clearance" name="watersite_clearance" accept="application/pdf" onchange="validateFileType(this)">
                                    </div>
                                </div>
                            </li>
                            @endif
                            @if($attach->is_engineers_report_validated === 0)
                            <!-- Engineer’s Report -->
                            <li class="list-group-item">
                                <button class="btn btn-danger dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseEngineer{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseEngineer{{$item->fac_id}}">
                                    Engineer’s Report
                                </button>
                                <div class="collapse" id="collapseEngineer{{$item->fac_id}}">
                                    <div class="card card-body">
                                        @if($attach->engineers_report)
                                            <p>Current File: <a href="{{ asset('storage/' . $attach->engineers_report) }}" target="_blank">View</a></p>
                                        @endif
                                        <input type="file" class="form-control-file" id="engineers_report" name="engineers_report" accept="application/pdf" onchange="validateFileType(this)">
                                    </div>
                                </div>
                            </li>
                            @endif
                            @if($attach->is_plans_specs_validated === 0)
                            <!-- Plans and Specifications -->
                            <li class="list-group-item">
                                <button class="btn btn-danger dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapsePlan{{$item->fac_id}}" aria-expanded="false" aria-controls="collapsePlan{{$item->fac_id}}">
                                    Plans and Specifications
                                </button>
                                <div class="collapse" id="collapsePlan{{$item->fac_id}}">
                                    <div class="card card-body">
                                        @if($attach->plans_specs)
                                            <p>Current File: <a href="{{ asset('storage/' . $attach->plans_specs) }}" target="_blank">View</a></p>
                                        @endif
                                        <input type="file" class="form-control-file" id="plans_specs" name="plans_specs" accept="application/pdf" onchange="validateFileType(this)">
                                    </div>
                                </div>
                            </li>
                        </ul>
                        @endif
                        @endif
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Done</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
{{-- Modal for remarks Reject attachments-------------------------------------------------------------------------- --}}
@foreach($datainitial as $item)
<div class="modal fade" id="modalRejectAttach{{$item->fac_id}}" tabindex="-1" role="dialog" aria-labelledby="modalRejectAttachLabel{{$item->fac_id}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('email.reattach') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="fac_id" value="{{ $item->fac_id }}">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="modalReAttachLabel{{$item->fac_id}}">Rejection Remarks</h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rejectionRemarks{{$item->fac_id}}" class="lg-text">Remarks for rejection:</label>
                        <textarea class="form-control" id="rejectionRemarks{{$item->fac_id}}" name="reject_remarks" rows="7" aria-label="With textarea" placeholder="Enter your remarks here...">
                            {{-- @if($item->initialApplication->initAttach->is_application_form_validated === 0)
                            Application Form
                            @endif
                            @if($item->initialApplication->initAttach->is_cert_pot_validated === 0)
                            Certificate of Potability
                            @endif
                            @if($item->initialApplication->initAttach->is_sanitary_survey_validated === 0)
                            Sanitary Survey of Water Source
                            @endif
                            @if($item->initialApplication->initAttach->is_watersite_clearance_validated === 0)
                            Drinking Water Site Clearance
                            @endif
                            @if($item->initialApplication->initAttach->is_engineers_report_validated === 0)
                            Engineer's Report
                            @endif
                            @if($item->initialApplication->initAttach->is_plans_specs_validated === 0)
                            Plans and Specifications
                            @endif --}}
                        </textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Done</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
{{-- Modal for Upload Order of Payment and OR-------------------------------------------------------------------------- --}}
@foreach($datainitial as $item)
<div class="modal fade" id="modalPayment{{$item->fac_id}}" tabindex="-1" role="dialog" aria-labelledby="modalPaymentLabel{{$item->fac_id}}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('orderpaymentupload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="fac_id" value="{{ $item->fac_id }}">
                <input type="hidden" name="initapp_id" value="{{ $item->initialApplication->initapp_id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPaymentLabel{{$item->fac_id}}">Order of Payment</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @php
                    $attachments = $orderPaymentattach->where('initapp_id', $item->initialApplication->initapp_id);
                @endphp
                @foreach($attachments as $attach)
                        {{-- @if($attach->initapp_id == $item->initialApplication->initapp_id) --}}
                        <ul class="list-group">
                            <!-- Order of Payment -->
                            <li class="list-group-item">
                               

                                <button class="btn btn-info dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseOrderPayment{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseOrderPayment{{$item->fac_id}}">
                                    Signed Order of Payment
                                </button>
                                <div class="collapse" id="collapseOrderPayment{{$item->fac_id}}">
                                    <div class="card card-body">
                                        @if($attach->order_payment)
                                        <!-- Display iframe if file is present -->
                                        <iframe src="{{ asset('storage/' . $attach->order_payment) }}" width="100%" height="700px"></iframe>
                                        @else
                                        <div class="alert alert-warning d-flex align-items-center" role="alert">
                                            <i class="fas fa-exclamation-circle mr-2"></i> <!-- FontAwesome icon for a warning -->
                                            <span class="font-weight">File not uploaded yet. Please upload the Signed Order of Payment.</span>
                                        </div>
                                        @endif
                                        <input type="file" class="form-control-file" id="order_payment" name="order_payment" accept="application/pdf" onchange="validateFileType(this)">
                                    </div>
                                </div>
                            </li>

                            <!-- Official Receipt -->
                            <li class="list-group-item">
                                
                                <button class="btn btn-info dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseOR{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseOR{{$item->fac_id}}">
                                    Official Receipt
                                </button>
                                <div class="collapse" id="collapseOR{{$item->fac_id}}">
                                    <div class="card card-body">
                                        @if($attach->attach_OR)
                                        <!-- Display iframe if file is present -->
                                        <iframe src="{{ asset('storage/' . $attach->attach_OR) }}" width="100%" height="700px"></iframe>
                                        @else
                                        <div class="alert alert-warning d-flex align-items-center" role="alert">
                                            <i class="fas fa-exclamation-circle mr-2"></i> <!-- FontAwesome icon for a warning -->
                                            <span class="font-weight">File not uploaded yet. Please upload the Official Receipt.</span>
                                        </div>
                                        @endif
                                        <input type="file" class="form-control-file" id="attach_OR" name="attach_OR" accept="application/pdf" onchange="validateFileType(this)">
                                    </div>
                                </div>
                            </li>
                        </ul>

                        {{-- @endif --}}
                    @endforeach

                      <!-- If no existing attachment, provide option to upload new -->
                    @if($attachments->isEmpty())
                    <div class="alert alert-info" role="alert">
                       You can upload your "Order of Payment" and "Official Receipt" below.
                    </div>
                    <div class="form-group">
                        <label for="order_payment">Upload Signed Order of Payment:</label>
                        <input type="file" class="form-control-file" name="order_payment" accept="application/pdf" onchange="validateFileType(this)">
                    </div>
                    <div class="form-group">
                        <label for="attach_OR">Upload Official Receipt:</label>
                        <input type="file" class="form-control-file" name="attach_OR" accept="application/pdf" onchange="validateFileType(this)">
                    </div>
                @endif
                </div>  
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
{{-- Modal for generating permit-------------------------------------------------------------------------- --}}
@foreach($datainitial as $item)
<div class="modal fade" id="modalPermit{{$item->fac_id}}" tabindex="-1" role="dialog" aria-labelledby="modalPermitLabel{{$item->fac_id}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="permitForm{{$item->fac_id}}" data-fac-id="{{$item->fac_id}}" action="{{ route('initialpermit', ['fac_id' => $item->fac_id]) }}" method="GET" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalPermitLabel{{$item->fac_id}}">Generate Permit</h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="scope{{$item->fac_id}}" class="lg-text">Scope of Work:</label>
                        <textarea class="form-control" id="scope{{$item->fac_id}}" name="scope" rows="3" aria-label="With textarea" placeholder="Enter the scope of work here..."></textarea>
                    </div>
                    <div id="loading{{$item->fac_id}}" style="display: none; text-align: center; margin-top: 20px;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p>Loading...</p>
                    </div>
                    <iframe id="pdfIframe{{$item->fac_id}}" style="width: 100%; height: 400px; display: none;" frameborder="0"></iframe>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
{{-- Modal for attach permit-------------------------------------------------------------------------- --}}
@foreach($datainitial as $item)
<div class="modal fade" id="modalAttachPermit{{$item->fac_id}}" tabindex="-1" role="dialog" aria-labelledby="modalAttachPermitLabel{{$item->fac_id}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('initialpermit.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAttachPermitLabel{{$item->fac_id}}">View/Attach Initial Permit</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="initapp_id" value="{{ $item->initialApplication->initapp_id }}">
                    
                    <ul class="list-group">
                        <!-- Initial permit-->
                        <li class="list-group-item">
                            <button class="btn btn-info dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseInitPermit{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseInitPermit{{$item->fac_id}}">
                                Initial Permit
                            </button>
                            <div class="collapse show" id="collapseInitPermit{{$item->fac_id}}">
                                <div class="card card-body">
                                    <input type="file" class="form-control-file" id="initial_permit" name="initial_permit" accept="application/pdf" onchange="validateFileType(this)">
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Done</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

{{-- Modal for view permit-------------------------------------------------------------------------- --}}
@foreach($datainitial as $item)
<div class="modal fade" id="modalViewPermit{{$item->fac_id}}" tabindex="-1" role="dialog" aria-labelledby="modalViewPermitLabel{{$item->fac_id}}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            
                <div class="modal-header">
                    <h5 class="modal-title" id="modalViewPermitLabel{{$item->fac_id}}">View Initial Permit</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="initapp_id" value="{{ $item->initialApplication->initapp_id }}">
                    
                    <ul class="list-group">
                        <!-- Initial permit-->
                        <li class="list-group-item">
                            
                                <div class="card-body">
                                    @php
                                        $permitAttached = false;
                                    @endphp

                                    @foreach($dataInitialPermit as $attach)
                                        @if($attach->initapp_id == $item->initialApplication->initapp_id)
                                            @if($attach->permit_id)
                                            <iframe src="{{ asset('storage/' .$attach->initial_permit) }}" width="100%" height="500px"></iframe>
                                                @php
                                                    $permitAttached = true;
                                                @endphp
                                            @endif
                                        @endif
                                    @endforeach

                                    @if(!$permitAttached)
                                        <p>No file attached yet.</p>
                                    @endif

                                </div>
                           
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            
        </div>
    </div>
</div>
@endforeach

 <script>
//for validate file upload
function validateFileType(input) {
    const file = input.files[0];
    const fileType = file ? file.type : '';
    
    // Check if the file type is PDF
    if (file && fileType !== 'application/pdf') {
        // Show an error message
        toastr.error('Only PDF files are allowed.', 'Error', {
            closeButton: true,
            progressBar: true,
            timeOut: 5000,
        });

        // Clear the input field
        input.value = '';
        input.classList.add('invalid-file'); // Highlight the input
    } else {
        input.classList.remove('invalid-file'); // Clear previous error highlight
    }
    
}

$(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [[6, 'desc']], 
        });
    });
    
  $(document).ready(function() {
    $('.btn-approve').on('click', function() {
        var attachmentId = $(this).data('attachment-id');
        var field = $(this).data('field');
        var $buttonsContainer = $(this).closest('.collapse').find('.btn-container'); // Adjust selector to match your HTML structure

        $.post('{{ route('attachments.validate') }}', {
            _token: '{{ csrf_token() }}',
            attachment_id: attachmentId,
            field: field
        }, function(response) {
            // Show Toastr notification for approval
            toastr.success(response.message, 'Approved', {
                closeButton: true,
                progressBar: true,
                timeOut: 3000,
            });

            // Update UI to reflect the change
            $buttonsContainer.html('<span class="text-success font-weight-bold">Approved</span>');
        }).fail(function() {
            toastr.warning('Approval failed. Please try again.', 'Error', {
                closeButton: true,
                progressBar: true,
                timeOut: 3000,
            });
        });
    });

    $('.btn-reject').on('click', function() {
        var attachmentId = $(this).data('attachment-id');
        var field = $(this).data('field');
        var $buttonsContainer = $(this).closest('.collapse').find('.btn-container'); // Adjust selector to match your HTML structure

        $.post('{{ route('attachments.reject') }}', {
            _token: '{{ csrf_token() }}',
            attachment_id: attachmentId,
            field: field
        }, function(response) {
            // Show Toastr notification for rejection
            toastr.error(response.message, 'Rejected', {
                closeButton: true,
                progressBar: true,
                timeOut: 3000,
            });

            // Update UI to reflect the change
            $buttonsContainer.html('<span class="text-danger font-weight-bold">Rejected</span>');
        }).fail(function() {
            toastr.warning('Rejection failed. Please try again.', 'Error', {
                closeButton: true,
                progressBar: true,
                timeOut: 3000,
            });
        });
    });
});
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('form[data-fac-id]').forEach(function(form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                var facId = this.getAttribute('data-fac-id');
                var formData = new FormData(this);
                
                var params = new URLSearchParams();
                formData.forEach(function(value, key) {
                    params.append(key, value);
                });

                var url = "{{ route('initialpermit', ['fac_id' => ':fac_id']) }}".replace(':fac_id', facId) + '?' + params.toString();
                var iframe = document.getElementById('pdfIframe' + facId);
                var loadingIndicator = document.getElementById('loading' + facId);

                if (iframe && loadingIndicator) {
                    loadingIndicator.style.display = 'block';
                    iframe.style.display = 'none';

                    iframe.onload = function() {
                        loadingIndicator.style.display = 'none';
                        iframe.style.display = 'block';
                    };

                    iframe.src = url;
                } else {
                    console.error('iframe or loading indicator element not found.');
                }
            });
        });
    });

    function confirmDelete(fac_id) {
        if (confirm('Are you sure you want to delete this transaction? This action cannot be undone.')) {
            document.getElementById('delete-form-' + fac_id).submit();
        }
    }
    </script>
 
@endsection
