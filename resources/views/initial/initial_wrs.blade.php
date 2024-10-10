@extends('layouts.auth')
@section('content')
<!-- Error Message -->
@if ($errors->any())
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

<style>
    .invalid-field, .invalid-file {
    border: 2px solid red !important;
    outline: none;
}

input[type="file"].invalid-file::file-selector-button {
    border: 2px solid red !important;
}
</style>

<div class="row justify-content-center">
  
        <div class="card animated--fade-in">
            <div class="card-header py-3">
                <h2 class="m-0 font-weight-bold text-info">Water Refilling Station (Initial) </h2>
            </div>
            <form id="msform" method="POST" action="{{ route('initial-wrs.submit') }}" enctype="multipart/form-data" >
                @csrf
                <!-- progressbar -->
                <ul id="progressbar">
                    <li class="active" id="facilityinfo"><strong>Facility Information</strong></li>
                    <li id="attachment"><strong>Attachment</strong></li>
                    <li id="review"><strong>Review</strong></li>
                
                </ul>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <br>
                <!-- fieldsets -->
                <fieldset>
                    <div class="form-card">
                        <div class="row">
                            <div class="col-7">
                                <h2 class="fs-title">Facility Information:</h2>
                            </div>
                            <div class="col-5">
                                <h2 class="steps">Step 1 - 3</h2>
                            </div>
                        </div>
                        
                        <label class="fieldlabels">Facility Name: <strong class="text-danger">*</strong> </label>
                        <input type="text" name="fac_name" id="fac_name" placeholder="Facility Name..." required/>
                        <label class="fieldlabels">Facility Address(Building no., Street No., Barangay, City/Municipality, Province):<strong class="text-danger">*</strong></label>
                        <input type="text" name="fac_address" id="fac_address" placeholder="Facility Address..." required/>
                        <label class="fieldlabels">Owner Name:<strong class="text-danger">*</strong></label>
                        <input type="text" name="owner_name" id="owner_name" placeholder="Owner Name..." required/>
                        <label class="fieldlabels" >Owner Address(Building no., Street No., Barangay, City/Municipality, Province):<strong class="text-danger">*</strong></label>
                        <input type="text" name="owner_address" id="owner_address" placeholder="Owner Address..." required/>
                        <label class="fieldlabels">Telephone Number:<strong class="text-danger">*</strong></label>
                        <input type="text" name="telephone_number" id="telephone_number" placeholder="Telephone no..." required/>
                        <label class="fieldlabels">Area to Serve:<strong class="text-danger">*</strong></label>
                        <input type="text" name="area_to_serve" id="area_to_serve" placeholder="Area to serve..." required/>
                        <label class="fieldlabels" for="water_source_type">Type of Water Source:<strong class="text-danger">*</strong></label>
                        <div class="styled-select" style="position: relative; width: 300px;">
                            <select id="water_source_type" name="water_source_type" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; color: gray; background-color: #efebeb93;" required>
                                <option value="0">---Select---</option>
                                <option value="1">Point Source (Deep Well)</option>
                                <option value="2">Communal Faucet System/Stand Post</option>
                                <option value="3">Waterworks System (Water District)</option>
                            </select>
                        </div>
                        
                    </div>
                    <input type="button" name="next" class="next action-button" value="Next" onclick="storeFacilityInfo()"/>
                </fieldset>
                <fieldset>
                    <div class="form-card">
                        <div class="row">
                            <div class="col-7">
                                <h2 class="fs-title">Attachments (PDF Only):</h2>
                            </div>
                            <div class="col-5">
                                <h2 class="steps">Step 2 - 3</h2>
                            </div>
                        </div>
                        <label class="fieldlabels">Certificate of Potability(Laboratory Results of Water Sample):</label>
                    <input type="file" name="cert_pot" id="cert_pot" accept="application/pdf" required onchange="validateFileType(this)">
                    <label class="fieldlabels">Sanitary Survey of Water Source:</label>
                    <input type="file" name="sanitary_survey" id="sanitary_survey" accept="application/pdf" required onchange="validateFileType(this)">
                    <label class="fieldlabels">Drinking Water Site Clearance:</label>
                    <input type="file" name="watersite_clearance" id="watersite_clearance" accept="application/pdf" required onchange="validateFileType(this)">
                    <label class="fieldlabels">Engineer's Report:</label>
                    <input type="file" name="engineers_report" id="engineers_report" accept="application/pdf" required onchange="validateFileType(this)">
                    <label class="fieldlabels">Plans and Specifications for the complete multi-stage water purification design of the plant prepared:</label>
                    <input type="file" name="plans_specs" id="plans_specs" accept="application/pdf" required onchange="validateFileType(this)">
                 
                    </div>
                    <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                    <input type="button" name="next" class="next action-button" value="Next" onclick="storeAttachments()"/>
                
                </fieldset>
                
                <fieldset>
                    <div class="form-card">
                        <div class="row">
                            <div class="col-7">
                                <h2 class="fs-title">Review:</h2>
                            </div>
                            <div class="col-5">
                                <h2 class="steps">Step 3 - 3</h2>
                            </div>
                        </div>
                    <label class="fieldlabels">Facility Name:</label>
                    <span id="review_fac_name"></span><br>

                    <label class="fieldlabels">Facility Address(Building no., Street No., Barangay, City/Municipality, Province):</label>
                    <span id="review_fac_address"></span><br>

                    <label class="fieldlabels">Owner Name:</label>
                    <span id="review_owner_name"></span><br>

                    <label class="fieldlabels">Owner Address(Building no., Street No., Barangay, City/Municipality, Province):</label>
                    <span id="review_address"></span><br>

                    <label class="fieldlabels">Telephone Number:</label>
                    <span id="review_tel_no"></span><br>

                   
                    <label class="fieldlabels">Area to Serve:</label>
                    <span id="review_area_to_serve"></span><br>

                    <label class="fieldlabels" for="water_source_type">Type of Water Source:</label>
                    <span id="review_waterSource"></span><br>

                    <label class="fieldlabels">Attachments:</label>
                    <div id="review_attachments"></div><br>
                        
                    </div>
                    <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                    <div class="form-group">
                        <button type="submit" class="next action-button">Submit</button>
                    </div>
                </fieldset>
                
               
            </form>
        </div>

</div>

<script>
   


// JavaScript function to validate file type
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

     document.querySelector('form').addEventListener('submit', function(event) {
        updateProgressBar(66);
    });
    function storeFacilityInfo() {
        
        document.getElementById('review_fac_name').innerText = document.getElementById('fac_name').value;
        document.getElementById('review_fac_address').innerText = document.getElementById('fac_address').value;
        document.getElementById('review_owner_name').innerText = document.getElementById('owner_name').value;
        document.getElementById('review_address').innerText = document.getElementById('owner_address').value;
        document.getElementById('review_tel_no').innerText = document.getElementById('telephone_number').value;
        document.getElementById('review_area_to_serve').innerText = document.getElementById('area_to_serve').value;
        document.getElementById('review_waterSource').innerText = document.getElementById('water_source_type').options[document.getElementById('water_source_type').selectedIndex].text;

        // Update progress bar
        // updateProgressBar(66);
    }

    function storeAttachments() {
        let attachments = [];
        const attachmentFields = ['cert_pot', 'sanitary_survey', 'watersite_clearance', 'engineers_report', 'plans_specs'];

        attachmentFields.forEach(field => {
            let fileInput = document.getElementById(field);
            if (fileInput.files.length > 0) {
                attachments.push(fileInput.files[0].name);
            }
        });

        const reviewAttachmentsDiv = document.getElementById('review_attachments');
        reviewAttachmentsDiv.innerHTML = ''; 
        attachments.forEach(fileName => {
            const fileElement = document.createElement('div');
            fileElement.textContent = fileName;
            reviewAttachmentsDiv.appendChild(fileElement);
        });

        // Update progress bar
    }

 
    function updateProgressBar(value) {
        document.querySelector('.progress-bar').style.width = value + '%';
    }

    // Initialize progress bar
    updateProgressBar(33);


</script>
@endsection