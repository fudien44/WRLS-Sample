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
        <h6 class="h3 mb-2 text-gray-800">Operational Transaction List</h6>
    </div>
          <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr align="center" >
                            <th style="vertical-align: middle;">Facility Name</th>
                            <th style="vertical-align: middle;">Owner</th>
                            <th style="vertical-align: middle;">Operational Permit No.</th>
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
                        @forelse($dataoper as $item)
                        <tr>
                            <td>{{ $item->fac_name }}</td>
                            <td>{{ $item->owner_name }}</td>
                            <td>{{ $item->operateApplication->operatectrl_no ?? 'Not Yet' }}</td>
                            <td>{{ $item->fac_address }}</td>
                            <td>{{ isset($waterSourceTypes[$item->water_source_type]) ? $waterSourceTypes[$item->water_source_type] : 'Unknown' }}</td>
                            <td>{{ $item->telephone_number }}</td>
                            <td align="center">{{ $item->area_to_serve }}</td>
                            <td>
                                {{ $item->operateApplication ? \Carbon\Carbon::parse($item->operateApplication->submission_date)->format('F j, Y') : 'N/A' }}
                            </td>
                            <td align="center">
                                @if($item->operateApplication->application_status === 'In Process') 
                                <div class="alert-primary" role="alert" style="border: 1px solid #cce5ff; border-radius: 5px; padding: 10px 15px; margin-bottom: 10px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                    <i class="fas fa-spinner" style="margin-right: 10px; font-size: 1.2em;"></i>
                                    {{$item->operateApplication->application_status ?? 'N/A'}}
                                </div>
                                @elseif($item->operateApplication->application_status === 'For Reattachment')
                                    <div class="alert-danger" role="alert" style="border: 1px solid #f5c6cb; border-radius: 5px; padding: 10px 15px; margin-bottom: 10px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                        <i class="fas fa-exclamation-circle" style="margin-right: 10px; font-size: 1.2em;"></i>
                                        {{$item->operateApplication->application_status ?? 'N/A'}}
                                    </div>
                                @elseif($item->operateApplication->application_status === 'For Payment')
                                    <div class="alert-warning" role="alert" style="border: 1px solid #ffeeba; border-radius: 5px; padding: 10px 15px; margin-bottom: 10px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                        <i class="fas fa-dollar-sign" style="margin-right: 10px; font-size: 1.2em;"></i>
                                        {{$item->operateApplication->application_status ?? 'N/A'}}
                                    </div>
                                @elseif($item->operateApplication->application_status === 'In Process of Payment')
                                    <div class="alert-info" role="alert" style="border: 1px solid #bee5eb; border-radius: 5px; padding: 10px 15px; margin-bottom: 10px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                        <i class="fas fa-credit-card" style="margin-right: 10px; font-size: 1.2em;"></i>
                                        {{$item->operateApplication->application_status ?? 'N/A'}}
                                    </div>
                                @elseif($item->operateApplication->application_status === 'For Scheduling')
                                    <div class="alert-secondary" role="alert" style="border: 1px solid #d6d8db; border-radius: 5px; padding: 10px 15px; margin-bottom: 10px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                        <i class="fas fa-calendar-alt" style="margin-right: 10px; font-size: 1.2em;"></i>
                                        {{$item->operateApplication->application_status ?? 'N/A'}}
                                    </div>
                                @elseif($item->operateApplication->application_status === 'For visitation')
                                    <div class="alert-warning" role="alert" style="border: 1px solid #d6d8db; border-radius: 5px; padding: 10px 15px; margin-bottom: 10px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                        <i class="fas fa-eye" style="margin-right: 10px; font-size: 1.2em;"></i>
                                        {{$item->operateApplication->application_status ?? 'N/A'}}
                                    </div>
                                    @elseif($item->operateApplication->application_status === 'Rejected')
                                    <div class="alert-danger" role="alert" style="border: 1px solid #d6d8db; border-radius: 5px; padding: 10px 15px; margin-bottom: 10px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                        <i class="fas fa-times-circle" style="margin-right: 10px; font-size: 1.2em;"></i>
                                        {{$item->operateApplication->application_status ?? 'N/A'}}
                                    </div>
                                    @elseif($item->operateApplication->application_status === 'Awaiting issuance of operational permit')
                                    <div class="alert-primary" role="alert" style="border: 1px solid #d6d8db; border-radius: 5px; padding: 10px 15px; margin-bottom: 10px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                        <i class="fas fa-file-alt" style="margin-right: 10px; font-size: 1.2em;"></i>
                                        {{$item->operateApplication->application_status ?? 'N/A'}}
                                    </div>
                                    @elseif($item->operateApplication->application_status === 'Failed Inspection')
                                    <div class="alert-danger" role="alert" style="border: 1px solid #d6d8db; border-radius: 5px; padding: 10px 15px; margin-bottom: 10px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                        <i class="fas fa-exclamation-circle" style="margin-right: 10px; font-size: 1.2em;"></i>
                                        {{$item->operateApplication->application_status ?? 'N/A'}}
                                    </div>
                                    @elseif($item->operateApplication->application_status === 'For Reinspection')
                                    <div class="alert-warning" role="alert" style="border: 1px solid #d6d8db; border-radius: 5px; padding: 10px 15px; margin-bottom: 10px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                        <i class="fas fa-redo" style="margin-right: 10px; font-size: 1.2em;"></i>
                                        {{$item->operateApplication->application_status ?? 'N/A'}}
                                    </div>
                                @elseif($item->operateApplication->application_status === 'For Issuance')
                                    <div class="alert-info" role="alert" style="border: 1px solid #bee5eb; border-radius: 5px; padding: 10px 15px; margin-bottom: 10px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                        <i class="fas fa-file-alt" style="margin-right: 10px; font-size: 1.2em;"></i>
                                        {{$item->operateApplication->application_status ?? 'N/A'}}
                                    </div>
                                @elseif($item->operateApplication->application_status === 'Operational Permit Available')
                                    <div class="alert-success" role="alert" style="border: 1px solid #c3e6cb; border-radius: 5px; padding: 10px 15px; margin-bottom: 10px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                        <i class="fas fa-check-circle" style="margin-right: 10px; font-size: 1.2em;"></i>
                                        {{$item->operateApplication->application_status ?? 'N/A'}}
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
                                <button type="button" class="dropdown-item" data-toggle="modal" data-target="#modalOperaAttach{{$item->fac_id}}" onmouseover="this.style.backgroundColor='#e0e0e0';" 
                                    onmouseout="this.style.backgroundColor='';">
                                     View
                                </button>
                                <form action="{{ route('operationalform.upload') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="operateapp_id" value="{{ $item->operateApplication->operateapp_id }}">
                                    <label class="dropdown-item" for="application_form{{$item->operateApplication->operateapp_id}}" 
                                        onmouseover="this.style.backgroundColor='#e0e0e0';" 
                                        onmouseout="this.style.backgroundColor='';" style="cursor: pointer; margin-bottom: 1px;">
                                     Upload Application Form
                                 </label>
                                 <input type="file" id="application_form{{$item->operateApplication->operateapp_id}}" name="application_form" style="display: none;" accept="application/pdf" onchange="this.form.submit();">
                                </form>
                             @if((auth()->user()->role_id === 4 || auth()->user()->role_id === 2)  
                              || ($item->operateApplication->application_status === 'For Reattachment'))
                                <button type="button" class="dropdown-item text-danger" data-toggle="modal" data-target="#modalReAttach{{$item->fac_id}}">
                                   <i class="fas fa-upload"></i> Reattach
                                </button>
                                    </div>
                                </div>
                             @endif
                                </td>
                            <td align="center">
                                {{-- Download Button --}}
                                <div class="dropdown mb-2">
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fas fa-download"></i> Download
                                    </button>
                                    <div class="dropdown-menu animated--fade-in"
                                        aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{ route('operationalform', ['fac_id' => $item->fac_id]) }}"><i class="fas fa-fw fa-file-pdf"></i> Application Form.pdf</a>
                                        
                                    </div>
                                </div>
                                {{-- Edit Button --}}
                            @if(auth()->user()->role_id === 4 || auth()->user()->role_id === 2)


                                <div class="dropdown mb-2">
                                    <button class="btn btn-warning dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <div class="dropdown-menu animated--fade-in"
                                        aria-labelledby="dropdownMenuButton">
                                        <button class="dropdown-item" type="button"  onmouseover="this.style.backgroundColor='#e0e0e0';" 
                                            onmouseout="this.style.backgroundColor='';">Edit</button>
                                        <form id="delete-form-{{ $item->fac_id }}" action="{{ route('operapp.delete', $item->fac_id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item text-danger" type="button" onclick="confirmDelete({{ $item->fac_id }})">Delete</button>
                                        </form>
                                    </div>
                                </div>
                                {{-- Update Application Status --}}
                                <div class="dropdown mb-2">
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fas fa-file-alt"></i> Update Application Status
                                    </button>
                                    <div class="dropdown-menu animated--fade-in"
                                        aria-labelledby="dropdownMenuButton">
                                        <form action="{{ route('email.operinspection') }}" method="POST" style="display: inline;">
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
                                        <form action="{{ route('email.operational') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="fac_id" value="{{ $item->fac_id }}">
                                            <button type="submit" class="dropdown-item" onmouseover="this.style.backgroundColor='#e0e0e0';" 
                                            onmouseout="this.style.backgroundColor='';">Operational Permit Available</button>
                                        </form>
                                    </div>
                                    </div>
                            @endif


                            {{-- Generate Operational Permit --}}
                            @if(auth()->user()->role_id === 4)

                            <div class="dropdown mb-2">
                                <button class="btn btn-success dropdown-toggle position-relative" type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fas fa-check"></i> Operational Permit
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
          

 
 {{-- Modal for view attachment --}}
 @foreach($dataoper as $item)
 <div class="modal fade" id="modalOperaAttach{{$item->fac_id}}" tabindex="-1" role="dialog" aria-labelledby="modalOperAttachLabel{{$item->fac_id}}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalOperAttachLabel{{$item->fac_id}}">Uploaded Attachments</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                @php
                $allApproved = true;
            @endphp

            @foreach($operaAttachment as $attach)
                @if($attach->operateapp_id == $item->operateApplication->operateapp_id)
                  
                    @if(!$attach->is_application_form_validated || !$attach->is_letter_intent_validated || !$attach->is_cert_completion_validated || !$attach->is_cert_pot_validated || !$attach->is_cert_training_validated || !$attach->is_xerox_init_permit_validated)
                        @php
                            $allApproved = false;
                        @endphp
                    @endif
                @endif
            @endforeach
            @if($allApproved)
            <div class="alert alert-success" role="alert">
                    All attachments have already been approved. 
                    @if($item->operateApplication->application_status === 'In Process' && $item->operateApplication->application_status === 'For Reattachment')
                    Ready to proceed for payment.
                    @endif
            </div>
            @endif
                {{-- @foreach($operaAttachment as $attach)
                    @if($attach->operateapp_id == $item->operateApplication->operateapp_id) --}}
                    <ul class="list-group">
                        @foreach($operaAttachment as $attach)
                        @if($attach->operateapp_id == $item->operateApplication->operateapp_id)
                        {{-- application form --}}
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
                                    <button class="btn btn-lg btn-success btn-approve" data-attachment-id="{{ $attach->operattach_id }}" data-field="application_form" type="button"><i class="fas fa-check"></i></button>
                                    <button class="btn btn-lg btn-danger btn-reject" data-attachment-id="{{ $attach->operattach_id }}" data-field="application_form" type="button"><i class="fas fa-times"></i></button>
                                    @endif
                                @endif
                            @endif
                            </div>
                            </div>
                            
                        </li>
                        <!-- Letter of Intent -->
                        <li class="list-group-item mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-info btn-modal-custom dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseLOI{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseLOI{{$item->fac_id}}">
                                    Letter of Intent
                                </button>
                                @if($attach->is_letter_intent_validated === 1)
                                <!-- Display status and no buttons if already approved -->
                                <span class="text-success font-weight-bold">Approved</span>
                                 @elseif($attach->is_letter_intent_validated === 0)
                                <!-- Display status and no buttons if already rejected -->
                                <span class="text-danger font-weight-bold">Rejected</span>
                                @endif
                            </div>
                            <div class="collapse mt-2" id="collapseLOI{{$item->fac_id}}">
                                    <iframe src="{{ asset('storage/' . $attach->letter_intent) }}" width="100%" height="700px"></iframe>
                                    <div class="btn-container">
                                        @if(auth()->user()->role_id === 4 || auth()->user()->role_id === 2)
                                        @if(is_null($attach->is_letter_intent_validated))
                                               <!-- Display buttons if not yet approved or rejected -->
                                               <button class="btn btn-lg btn-success btn-approve" data-attachment-id="{{ $attach->operattach_id }}" data-field="letter_intent" type="button"><i class="fas fa-check"></i></button>
                                               <button class="btn btn-lg btn-danger btn-reject" data-attachment-id="{{ $attach->operattach_id }}" data-field="letter_intent" type="button"><i class="fas fa-times"></i></button>
                                    @endif
                                    @endif
                                    </div>
                            </div>
                        </li>

                        <!-- Certificate of completion -->
                        <li class="list-group-item mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-info dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseCOC{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseCOC{{$item->fac_id}}">
                                Certificate of Completion
                            </button>
                          @if($attach->is_cert_completion_validated === 1)
                                    <!-- Display status and no buttons if already approved -->
                              <span class="text-success font-weight-bold">Approved</span>
                          @elseif($attach->is_cert_completion_validated === 0)
                                    <!-- Display status and no buttons if already rejected -->
                              <span class="text-danger font-weight-bold">Rejected</span>
                          @endif
                            </div>
                            <div class="collapse mt-2" id="collapseCOC{{$item->fac_id}}">
                                <iframe src="{{ asset('storage/' . $attach->cert_completion) }}" width="100%" height="700px"></iframe>
                                <div class="btn-container">
                                    @if(auth()->user()->role_id === 4 || auth()->user()->role_id === 2)
                                     @if(is_null($attach->is_cert_completion_validated))
                                        <!-- Display buttons if not yet approved or rejected -->
                                        <button class="btn btn-lg btn-success btn-approve" data-attachment-id="{{ $attach->operattach_id }}" data-field="cert_completion" type="button"><i class="fas fa-check"></i></button>
                                        <button class="btn btn-lg btn-danger btn-reject" data-attachment-id="{{ $attach->operattach_id }}" data-field="cert_completion" type="button"><i class="fas fa-times"></i></button>
                                    @endif
                                    @endif
                                </div>
                            </div>
                        </li>

                        <!-- Certificate of Endorsement -->
                        <li class="list-group-item mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-info dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseCOP{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseCOP{{$item->fac_id}}">
                                Certificate of Endorsement/Certificate of Potability
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
                                    @if(auth()->user()->role_id === 4 || auth()->user()->role_id === 2)
                                     @if(is_null($attach->is_cert_pot_validated))
                                        <!-- Display buttons if not yet approved or rejected -->
                                        <button class="btn btn-lg btn-success btn-approve" data-attachment-id="{{ $attach->operattach_id }}" data-field="cert_pot" type="button"><i class="fas fa-check"></i></button>
                                        <button class="btn btn-lg btn-danger btn-reject" data-attachment-id="{{ $attach->operattach_id }}" data-field="cert_pot" type="button"><i class="fas fa-times"></i></button>
                                    @endif
                                    @endif
                                </div>
                            </div>
                        </li>


                        <!-- training -->
                        <li class="list-group-item mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-info dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseCert{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseCert{{$item->fac_id}}">
                                Certificate on Water Safety Plan Development
                            </button>
                          @if($attach->is_cert_training_validated === 1)
                                    <!-- Display status and no buttons if already approved -->
                              <span class="text-success font-weight-bold">Approved</span>
                          @elseif($attach->is_cert_training_validated === 0)
                                    <!-- Display status and no buttons if already rejected -->
                              <span class="text-danger font-weight-bold">Rejected</span>
                          @endif
                            </div>
                            <div class="collapse mt-2" id="collapseCert{{$item->fac_id}}">
                                <iframe src="{{ asset('storage/' . $attach->cert_training) }}" width="100%" height="700px"></iframe>
                                <div class="btn-container">
                                    @if(auth()->user()->role_id === 4 || auth()->user()->role_id === 2)
                                     @if(is_null($attach->is_cert_training_validated))
                                        <!-- Display buttons if not yet approved or rejected -->
                                        <button class="btn btn-lg btn-success btn-approve" data-attachment-id="{{ $attach->operattach_id }}" data-field="cert_training" type="button"><i class="fas fa-check"></i></button>
                                        <button class="btn btn-lg btn-danger btn-reject" data-attachment-id="{{ $attach->operattach_id }}" data-field="cert_training" type="button"><i class="fas fa-times"></i></button>
                                    @endif
                                    @endif
                                </div>
                            </div>
                        </li>



                        <!-- Xerox copy -->
                        <li class="list-group-item mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-info dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseXerox{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseXerox{{$item->fac_id}}">
                                Xerox Copy of Initial Permit of Water Refilling station
                            </button>
                          @if($attach->is_xerox_init_permit_validated === 1)
                                    <!-- Display status and no buttons if already approved -->
                              <span class="text-success font-weight-bold">Approved</span>
                          @elseif($attach->is_xerox_init_permit_validated === 0)
                                    <!-- Display status and no buttons if already rejected -->
                              <span class="text-danger font-weight-bold">Rejected</span>
                          @endif
                            </div>
                            <div class="collapse mt-2" id="collapseXerox{{$item->fac_id}}">
                                <iframe src="{{ asset('storage/' . $attach->xerox_init_permit) }}" width="100%" height="700px"></iframe>
                                <div class="btn-container">
                                    @if(auth()->user()->role_id === 4 || auth()->user()->role_id === 2)
                                     @if(is_null($attach->is_xerox_init_permit_validated))
                                        <!-- Display buttons if not yet approved or rejected -->
                                        <button class="btn btn-lg btn-success btn-approve" data-attachment-id="{{ $attach->operattach_id }}" data-field="xerox_init_permit" type="button"><i class="fas fa-check"></i></button>
                                        <button class="btn btn-lg btn-danger btn-reject" data-attachment-id="{{ $attach->operattach_id }}" data-field="xerox_init_permit" type="button"><i class="fas fa-times"></i></button>
                                    @endif
                                    @endif
                                </div>
                            </div>
                        </li>

                    </ul>
                    @endif
                @endforeach
            </div>
            <div class="modal-footer">
                @if((auth()->user()->role_id === 4 || auth()->user()->role_id === 2) 
                    && ($item->operateApplication->application_status === 'In Process' || $item->operateApplication->application_status === 'For Reattachment'))
                <form action="{{ route('email.operinspection') }}" method="POST" >
                    @csrf
                    <input type="hidden" name="fac_id" value="{{ $item->fac_id }}"> 
                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Ready for Scheduling</button>
                </form>
                <form action="{{ route('email.opereattach') }}" method="POST" >
                    @csrf
                    <input type="hidden" name="fac_id" value="{{ $item->fac_id }}"> 
                    <button type="submit" class="btn btn-danger">
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
@foreach($dataoper as $item)
<div class="modal fade" id="modalReAttach{{$item->fac_id}}" tabindex="-1" role="dialog" aria-labelledby="modalReAttachLabel{{$item->fac_id}}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('operational.reupload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalReAttachLabel{{$item->fac_id}}">Re-Upload Attachments</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="operateapp_id" value="{{ $item->operateApplication->operateapp_id }}">
                    @foreach($operaAttachment as $attach)
                        @if($attach->operateapp_id == $item->operateApplication->operateapp_id)
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


                            @if($attach->is_letter_intent_validated === 0)
                            <!--  Letter of Intent -->
                            <li class="list-group-item">
                                <button class="btn btn-danger dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseCOP{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseCOP{{$item->fac_id}}">
                                    Letter of Intent</button>
                                </button>
                                <div class="collapse" id="collapseCOP{{$item->fac_id}}">
                                    <div class="card card-body">
                                        @if($attach->letter_intent)
                                            <p>Current File: <a href="{{ asset('storage/' . $attach->letter_intent) }}" target="_blank">View</a></p>
                                        @endif
                                        <input type="file" class="form-control-file" id="letter_intent" name="letter_intent" onchange="validateFileType(this)">
                                    </div>
                                </div>
                            </li>
                            @endif

                            @if($attach->is_cert_completion_validated === 0)
                            <!-- Certificate of completion  -->
                            <li class="list-group-item">
                                <button class="btn btn-danger dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseSanitary{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseSanitary{{$item->fac_id}}">
                                    Certificate of Completion
                                </button>
                                <div class="collapse" id="collapseSanitary{{$item->fac_id}}">
                                    <div class="card card-body">
                                        @if($attach->cert_completion)
                                            <p>Current File: <a href="{{ asset('storage/' . $attach->cert_completion) }}" target="_blank">View</a></p>
                                        @endif
                                        <input type="file" class="form-control-file" id="cert_completion" name="cert_completion" onchange="validateFileType(this)">
                                    </div>
                                </div>
                            </li>
                            @endif

                            <!--  Certificate of Endorsement if water district – water source / Certificate of Potability if Deep Well Source -->
                            @if($attach->is_cert_pot_validated === 0)
                            <li class="list-group-item">
                                <button class="btn btn-danger dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseSite{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseSite{{$item->fac_id}}">
                                    Certificate of Endorsement/Certificate of Potability
                                </button>
                                <div class="collapse" id="collapseSite{{$item->fac_id}}">
                                    <div class="card card-body">
                                        @if($attach->cert_pot)
                                            <p>Current File: <a href="{{ asset('storage/' . $attach->cert_pot) }}" target="_blank">View</a></p>
                                        @endif
                                        <input type="file" class="form-control-file" id="cert_pot" name="cert_pot" onchange="validateFileType(this)">
                                    </div>
                                </div>
                            </li>
                            @endif

                            <!--   40 hours training -->
                            @if($attach->is_cert_training_validated === 0)
                            <li class="list-group-item">
                                <button class="btn btn-danger dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseEngineer{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseEngineer{{$item->fac_id}}">
                                    Certificate on Water Safety Plan Development
                                </button>
                                <div class="collapse" id="collapseEngineer{{$item->fac_id}}">
                                    <div class="card card-body">
                                        @if($attach->cert_training)
                                            <p>Current File: <a href="{{ asset('storage/' . $attach->cert_training) }}" target="_blank">View</a></p>
                                        @endif
                                        <input type="file" class="form-control-file" id="cert_training" name="cert_training" onchange="validateFileType(this)">
                                    </div>
                                </div>
                            </li>
                            @endif

                            <!-- Xerox copy  -->
                            @if($attach->is_xerox_init_permit_validated === 0)
                            <li class="list-group-item">
                                <button class="btn btn-danger dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapsePlan{{$item->fac_id}}" aria-expanded="false" aria-controls="collapsePlan{{$item->fac_id}}">
                                    Xerox copy of Initial Permit of Water Refilling station
                                </button>
                                <div class="collapse" id="collapsePlan{{$item->fac_id}}">
                                    <div class="card card-body">
                                        @if($attach->xerox_init_permit)
                                            <p>Current File: <a href="{{ asset('storage/' . $attach->xerox_init_permit) }}" target="_blank">View</a></p>
                                        @endif
                                        <input type="file" class="form-control-file" id="xerox_init_permit" name="xerox_init_permit" onchange="validateFileType(this)">
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
                    <button type="submit" class="btn btn-primary">Re-Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
 {{-- Modal for rejection remarks-------------------------------------------------------------------------- --}}
 @foreach($dataoper as $item)
<div class="modal fade" id="modalRejectAttach{{$item->fac_id}}" tabindex="-1" role="dialog" aria-labelledby="modalRejectAttachLabel{{$item->fac_id}}" aria-hidden="true">
    <div class="modal-dialog model-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('email.opereattach') }}" method="POST" enctype="multipart/form-data">
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
                        <textarea class="form-control" id="rejectionRemarks{{$item->fac_id}}" name="reject_remarks" rows="7" aria-label="With textarea" placeholder="Enter your remarks here..."></textarea>
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
{{-- Modal for generating permit-------------------------------------------------------------------------- --}}
@foreach($dataoper as $item)
<div class="modal fade" id="modalPermit{{$item->fac_id}}" tabindex="-1" role="dialog" aria-labelledby="modalPermitLabel{{$item->fac_id}}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="permitForm{{$item->fac_id}}" data-fac-id="{{$item->fac_id}}" action="{{ route('operationalpermit', ['fac_id' => $item->fac_id]) }}" method="GET" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalPermitLabel{{$item->fac_id}}">Generate Permit</h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="population{{$item->fac_id}}" class="lg-text">No. of Population to be served:</label>
                        <textarea class="form-control" id="population{{$item->fac_id}}" name="population" rows="3" aria-label="With textarea" placeholder="Enter the number of population to be served..."></textarea>
                        <label for="lots{{$item->fac_id}}" class="lg-text">No. of lots/housing units:</label>
                        <textarea class="form-control" id="lots{{$item->fac_id}}" name="lots" rows="3" aria-label="With textarea" placeholder="Enter the number of lots/housing units..."></textarea>
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
@foreach($dataoper as $item)
<div class="modal fade" id="modalAttachPermit{{$item->fac_id}}" tabindex="-1" role="dialog" aria-labelledby="modalAttachPermitLabel{{$item->fac_id}}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('operationalpermit.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAttachPermitLabel{{$item->fac_id}}">View/Attach Operational Permit</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="operateapp_id" value="{{ $item->operateApplication->operateapp_id }}">
                    
                    <ul class="list-group">
                        <!-- Initial permit-->
                        <li class="list-group-item">
                            <button class="btn btn-info dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseOperPermit{{$item->fac_id}}" aria-expanded="false" aria-controls="collapseOperPermit{{$item->fac_id}}">
                                Operational Permit
                            </button>
                            <div class="collapse show" id="collapseOperPermit{{$item->fac_id}}">
                                <div class="card card-body">
                                    <input type="file" class="form-control-file" id="operate_permit" name="operate_permit" accept="application/pdf" onchange="validateFileType(this)">
                                </div>
                            </div>
                        </li>
                    </ul>
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

{{-- Modal for view permit-------------------------------------------------------------------------- --}}
@foreach($dataoper as $item)
<div class="modal fade" id="modalViewPermit{{$item->fac_id}}" tabindex="-1" role="dialog" aria-labelledby="modalViewPermitLabel{{$item->fac_id}}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            
                <div class="modal-header">
                    <h5 class="modal-title" id="modalViewPermitLabel{{$item->fac_id}}">View Operational Permit</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="operateapp_id" value="{{ $item->operateApplication->operateapp_id }}">
                    
                    <ul class="list-group">
                        <!-- Operational permit-->
                        <li class="list-group-item">
                            
                                <div class="card-body">
                                    @php
                                        $permitAttached = false;
                                    @endphp

                                    @foreach($dataOperationPermit as $attach)
                                        @if($attach->operateapp_id == $item->operateApplication->operateapp_id)
                                            @if($attach->permit_id)
                                            <iframe src="{{ asset('storage/' .$attach->operate_permit) }}" width="100%" height="500px"></iframe>
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


//for validation of each attachment 
$(document).ready(function() {
    $('.btn-approve').on('click', function() {
        var attachmentId = $(this).data('attachment-id');
        var field = $(this).data('field');
        var $buttonsContainer = $(this).closest('.collapse').find('.btn-container'); // Adjust selector to match your HTML structure

        $.post('{{ route('operattachments.validate') }}', {
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

        $.post('{{ route('operattachments.reject') }}', {
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

            var url = "{{ route('operationalpermit', ['fac_id' => ':fac_id']) }}".replace(':fac_id', facId) + '?' + params.toString();
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

     setTimeout(function() {
        var alert = document.getElementById('success-message');
        if (alert) {
            alert.classList.remove('show');
            alert.classList.add('fade');
        }
    }, 5000); // Adjust the time (5000 ms = 5 seconds) as needed
    
    setTimeout(function() {
        var alert = document.getElementById('error-message');
        if (alert) {
            alert.classList.remove('show');
            alert.classList.add('fade');
        }
    }, 5000);
   function confirmDelete(fac_id) {
        if (confirm('Are you sure you want to delete this transaction? This action cannot be undone.')) {
            document.getElementById('delete-form-' + fac_id).submit();
        }
    }
    </script>
 
@endsection
