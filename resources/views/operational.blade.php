@extends('layouts.auth')


@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Operational Application</h1>
</div>
<div class="accordion" id="accordionExample">
    <div class="card ">
      <div class="card-header border-left-primary shadow h-100 py-2" id="headingOne">
        <h2 class="mb-0">
          <button class="btn btn-block text-left " type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            Water Refilling Station
          </button>
        </h2>
      </div>
  
      <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
        <div class="card-body">
          Please provide the following documents before proceeding:
          <br><br>
          1. Letter of intent to be address to ARISTIDES CONCEPION TAN, MD, MPH, CESO III<br>
          2. Certificate of completion (given by private sanitary engineer)<br>
          3. Certificate of Endorsement if water district – water source / Certificate of Potability if Deep Well Source<br>
          4. 40 hours training (certification course for water refilling station and plant operators and workshop on water safety plan development)<br>
          5. Xerox copy of Initial Permit of Water Refilling station
        
        </div>
        <div class="text-center">
          <a href="/operational-wrs" class="btn btn-success btn-icon-split mb-3">
                
            <span class="text">Proceed</span>
        </a>
          </div>
          
      </div>
    </div>
    {{-- <div class="card">
      <div class="card-header border-left-success shadow h-100 py-2" id="headingTwo">
        <h2 class="mb-0">
          <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            Public Cemetery/Memorial Park/Private Burial Ground
          </button>
        </h2>
      </div>
      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
        <div class="card-body">
            PROVIDE THE FOLLOWING DOCUMENTS AS PROVIDED UNDER SECTION 3 OF THE IMPLEMENTING RULES AND REGULATIONS (IRR) OF CHAPTER XXI – “DISPOSAL OF DEAD PERSONS” OF THE CODE ON SANITATION OF THE PHILIPPINES (PD 856).
        <br><br>
        PUBLIC CEMETERY/MEMORIAL PARK:
        <p>
        1. Resolution of the city/municipality council for the cemetery site embodying therein the strict compliance to these rules and regulations.
        </p>
        <p>2. Map of the proposed cemetery in triplicate copies indicating the dimensions of the cemetery in length and in width and the 25-50 meter zones, the dwelling places and sources of water supply within said zones.</p>
        
        <p>3. Title of ownership of the land proposed to be utilized as cemetery, duly registered with the office of the register of deeds of the province/city.</p>
        
        <p>4. Certification from the Sanitary Engineer of the DOH with regard to the suitability of the land proposed to be utilized as cemetery, as to the depth of water table during the dry and rainy season, highest flood level, direction of run-off, drainage disposal, the distance of any dwelling house within the 25 meter zone and drilling of a well or any source of potable water supply within 50 meter zone.</p>
        
        <p>5. Plan for the construction of a reinforced concrete wall or steel grille or combination thereof with a minimum height of two (2) meters around the cemetery with a steel grille main door provided with a lock.</p>
        
        <p>6. Plan for the construction of a chapel or a structure/building for public assembly within the cemetery with minimum area of 50 square meter (5m x 10m).</p>
        
        <p>7. Plan for the construction of a 4-meter wide main road from the gate to the rear and the 1-meter minimum cross roads which divide the cemetery in lots and sections.</p>
        
        <p>8. Topographic map of the cemetery zone.</p>
        
        <p>
            9. Technical description of the proposed cemetery showing the following:
            <br>
                <span style="display: inline-block; padding-left: 20px;">a. The name of the cemetery/memorial park or in case of private burial ground, the name of applicant, and the barangay, municipality or city or province where the proposed site is located;</span>
                <br>
                <span style="display: inline-block; padding-left: 20px;">b. Exact dimension of all the sides of the proposed cemetery site;</span>
                <br>
                <span style="display: inline-block; padding-left: 20px;">c. The area of the said site;</span>
                <br>
                <span style="display: inline-block; padding-left: 20px;">d. The 25 meter zone around the property delimited;</span>
                <br>
                <span style="display: inline-block; padding-left: 20px;">e. The name of all the land or residential owners within the 25 meter zone, indicating the portion/s belonging to each owner;</span>
                <br>
                <span style="display: inline-block; padding-left: 20px;">f. The direction of the compass, the top of the plan be the North; and</span>
                <br>
                <span style="display: inline-block; padding-left: 20px;">g. The distance of the corners of the proposed cemetery site proper from some known and permanent topographical objects, or some characteristics of the place which will facilitate the accurate identification of the cemetery site proper even if its fence or wall is removed.</span>
          </p>
          
          <p>PRIVATE BURIAL GROUND:</p>
          <p>1. Requirements under item 2, 3, 4, 5, 8 and 9;</p>
          <p>2. Resolution by the city/municipal council permitting the establishment of the private burial ground;</p>
          <p>3. Certification by the city/municipal planning and development office with regard to the proposed site location;</p>
          <p>4. Certification by the city/municipal engineer that the design of the proposed structures conforms to the National Building Code of the Philippines.</p>
          
        </div>

        <div class="text-center">
            <button class="btn btn-success text-left mb-3" type="button">
              Proceed
            </button>
          </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header border-left-info shadow h-100 py-2" id="headingThree">
        <h2 class="mb-0">
          <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
            Public Schools, Public Institution, etc.
          </button>
        </h2>
      </div>
      <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
        <div class="card-body">
          And lastly, the placeholder content for the third and final accordion panel. This panel is hidden by default.
        </div>
      </div>
    </div>
    <div class="card">
        <div class="card-header border-left-warning shadow h-100 py-2" id="headingFour">
          <h2 class="mb-0">
            <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                Funeral Establishment
            </button>
          </h2>
        </div>
        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
          <div class="card-body">
            <p>SUBMIT THE FOLLOWING DOCUMENTS AS PROVIDED UNDER SECTION 3 OF THE IMPLEMENTING RULES AND REGULATIONS (IRR) OF CHAPTER XXI – “DISPOSAL OF DEAD PERSONS” OF THE CODE ON SANITATION OF THE PHILIPPINES (PD 856).</p>

            <p>FUNERAL ESTABLISHMENT:</p>

                <span style="display: inline-block; padding-left: 20px;">1. Site development plan indicating lot property boundaries, building lay-out and future expansion (if any), entrance or exit to the main service road and parking.</span>
                <br>
                <span style="display: inline-block; padding-left: 20px;">
                    2. Floor Plan and specs showing the following:
                    <br>
                    <span style="display: inline-block; padding-left: 20px;">- Reception area, storage or display area for caskets, chapel</span>
                  </span>
                <br>
                <span style="display: inline-block; padding-left: 20px;">3. Zoning clearance</span>
                <br>
                <span style="display: inline-block; padding-left: 20px;">4. Transfer certificate of title or contract of lease</span>
                <br>
                <span style="display: inline-block; padding-left: 20px;">5. Inspection report from provincial sanitary Engineer</span>
          </div>
          <div class="text-center">
            <button class="btn btn-success text-left mb-3" type="button">
              Proceed
            </button>
          </div>
        </div>
      </div> --}}
  </div>
@endsection