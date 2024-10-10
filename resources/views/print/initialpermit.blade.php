<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <title>Initial Permit</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
     <style>
        /* @page { size: A4; margin: 20mm; } */
        @page {
                size: A4; /* Ensures the page size is A4 */
                margin: 20mm; /* Set margins on all sides */
                }
        body { margin: 0; font-family: Arial, sans-serif; font-size: 11px; }
        .table { width: 100%; border-collapse: collapse; }
        .table td, .table th { border: 1px solid #000; padding: 3px; height: 30px; vertical-align: top; }
        .upper, .info, .table { width: 100%; }
        .upper td, .info td { padding: 5px; }
        .medium-text { font-size: 14px; }
        .large-text { font-size: 16px; }
        .extra-large-text { font-size: 20px; }
        .center { text-align: center; }
        .underline {
border-bottom: 1px solid black; /* Adjust the color and thickness as needed */
    display: inline;
    padding-bottom: 2px; /* Adjust the padding to align with the text */
}
    </style>
</head>
<body>
    <div class="container">
        <div class="column">
            <table class="upper" cellpadding="0" cellspacing="0">
                <tr>
                    {{-- <td width="10%" style="border:none;"><center><img src="{{ $imageDoh }}" width="80"></center></td> --}}
                    <td width="30%" style="border:none;"><center><img src="{{ public_path('images/doh.png') }}" width="80"></center></td>
                    {{-- <td width="10%" style="border:none;"><center><img src="{{ $imageBagongPilipinas }}" width="90"></center></td> --}}
                    <td width="40%" style="font-size: 12px; border:none;">
                        <center>
                            <strong class="">Republic of the Philippines</strong><br>
                            DEPARTMENT OF HEALTH<br>
                            <strong class="">CENTER FOR HEALTH DEVELOPMENT <br> SOCCSKSARGEN Region</strong><br>
                        </center>
                    </td>
                    <td width="30%" style="border:none;"><center><img src="{{ public_path('images/bagong_pilipinas.png') }}" width="90"></center></td>

                    {{-- <td width="30%" style="border:none;"><center><img src="{{ $imageDohsoccs }}" width="80"></center></td> --}}
                </tr>
                <tr>
                    <td colspan="4" style="border:none;">
                        <center>
                        <b class="extra-large-text">INITIAL PERMIT</b><br>
                        <b class="large-text">(Construction of Water Supply System)</b><br>
                        </center>
                    </td>
                </tr>
            </table>
           <br><br><br>
           {{-- <span class="underline">{{$fac_name}}</span> --}}
           <p class="medium-text" style=" margin-bottom: 0;">
            Permit is hereby granted to 
            <span class="large-text" style="text-decoration: underline; text-transform: uppercase;">{{$owner_name}}</span>
        </p>
        <span style="display: block; margin-top: 0rem; font-style: italic; color: #555;">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Name of Applicant/Owner)
        </span>
        <p style=" margin-bottom: 0;">
            <span class="medium-text" style="text-decoration: underline; text-transform: uppercase;">{{$owner_address}}</span>
        </p>
        <span style="display: block; margin-top: 0rem; font-style: italic; color: #555;">
            Address(No., Street, City/Municipal, Province)
        </span>

        <p style=" margin-bottom: 0;">
            <span class="medium-text"> to </span>
            <span class="medium-text" style="text-decoration: underline; text-transform: uppercase;">{{$scopeOfWork}}</span>
        </p>
        <span style="display: block; margin-top: 0rem; font-style: italic; color: #555;">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Scope of Work)
        </span>


<p class="medium-text">a water supply system heretofore specified subject to the following conditions:</p>
<p class="medium-text">1. That the proposed construction shall be in accordance with approved plans filed with this office and
    <br>
    &nbsp;&nbsp;&nbsp;&nbsp;in conformity with the provisions of the IRR of Chapter II - "Water Supply" of P.D. 856. 
</p>
<p class="medium-text">2. That a certificate of completion duly signed by the sanitary engineer in-charge of construction shall 
    <br>
    &nbsp;&nbsp;&nbsp;&nbsp;be submitted to this office not later than seven (7) days after completion of the construction.
</p>
<br><br><br><br>

<p class="medium-text">Recommending Approval:</p>
<br><br>

<span class="medium-text"><u>KAMARUDIN M. KUNAKON, CE, SE, MPH</u> <br>Regional Sanitary Engineer</span> 

<br><br>
<br><br>
<p class="medium-text" style="margin-left: 40%;">Approved:</p>
<br><br>

<p class="medium-text" style="margin-left: 40%;"><u>ARISTIDES CONCEPCION TAN, MD, MPH, CESO III</u> <br>Director IV</span> 
<br><br><br><br>

        
        </div>

       
<footer style="position: fixed; bottom: 0; width: 100%; text-align: right; padding-right: 20px;">
    <p class="medium-text" style="margin: 0;">DOH-CHDXII-LHSDEOH-SOP01-Form2 Rev0</p>
</footer>
    </div>
</body>
</html>
