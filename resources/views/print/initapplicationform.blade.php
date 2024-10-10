<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <title>Initial Application Preview</title>
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
        .extra-large-text { font-size: 18px; }
        .center { text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="column">
            <table class="upper" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="10%" style="border:none;"><center><img src="{{ $imageDoh }}" width="80"></center></td>
                    {{-- <td width="10%" style="border:none;"><center><img src="{{ public_path('images/doh.png') }}" width="80"></center></td>
                    <td width="10%" style="border:none;"><center><img src="{{ public_path('images/bagong_pilipinas.png') }}" width="90"></center></td> --}}
                    <td width="10%" style="border:none;"><center><img src="{{ $imageBagongPilipinas }}" width="90"></center></td>
                    <td width="35%" style="font-size: 12px; border:none;">
                        <center>
                            <strong class="">Republic of the Philippines</strong><br>
                            DEPARTMENT OF HEALTH<br>
                            <strong class="">CENTER FOR HEALTH DEVELOPMENT <br> SOCCSKSARGEN Region</strong><br>
                        </center>
                    </td>
                    <td width="30%" style="border:none;"><center><img src="{{ $imageDohsoccs }}" width="80"></center></td>
                    {{-- <td width="20%" style="border:none;"><center><img src="{{ public_path('images/dohsoccsksargen.png') }}" width="80"></center></td> --}}
                </tr>
                <tr>
                    <td colspan="4" style="border:none;">
                        <center>
                        <b class="medium-text">APPLICATION FORM</b><br>
                            <span class="">INITIAL PERMIT</span>
                            <br>
                            <span>(WATER SOURCE OF RETAIL WATER SYSTEM OR REFILLING STATION)</span>
                            <br>
                        </center>
                    </td>
                </tr>
            </table>
           


                <table class="table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="70%" class="custom-height">
                            <label class="" style="margin-left: 5px;">NAME OF APPLICANT (Surname, Given Name, M.I.):</label>
                            <p class="medium-text" style="margin-left: 5px;">{{ $owner_name }}</p>
                        </td>
                        <td width="30%" class="custom-height">
                            <label class="" style="margin-left: 5px;">DATE:</label>
                           
                            <p class="medium-text" style="margin-left: 5px;"> {{ $submission_date }}</p>
                        </td>
                    </tr>
                </table>
                <table class="table" cellpadding="0" cellspacing="0">
                    <tr>    
                        <td width="70%" class="custom-height " >
                          <label style="margin-left: 5px;">ADDRESS (No., Street, City/Municipality, Province):</label>  
                          <p class="medium-text" style="margin-left: 5px;"> {{ $owner_address }}</p>
                        </td>
                        
                        <td width="30%" class="custom-height ">
                            <label style="margin-left: 5px;">TELEPHONE NO.:</label>
                            <p class="medium-text" style="margin-left: 5px;"> {{ $telephone_number }}</p>
                        </td>
                    </tr>
                </table>
                <table class="table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="100%" class="custom-height ">
                            <label style="margin-left: 5px;">NAME OF RETAIL WATER SYSTEM OR REFILLING STATION:</label>
                            <p class="medium-text" style="margin-left: 5px;"> {{ $fac_name }}</p>
                        </td>
                       
                    </tr>
                </table>
                <table class="table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="100%" class="custom-height ">
                            <label style="margin-left: 5px;">LOCATION OF WATER REFILLING STATION (No., Street, City/Municipality, Province):</label> 
                            <p class="medium-text" style="margin-left: 5px;"> {{ $fac_address }}</p>
                        </td>
                       
                    </tr>
                </table>
                <table class="table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="100%" class="custom-height ">
                            <label style="margin-left: 5px;">NAME OF OWNER/OPERATOR:</label> 
                            <p class="medium-text" style="margin-left: 5px;">{{ $owner_name }}</p>
                        </td>
                       
                    </tr>
                </table>
                <table class="table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="60%" class="custom-height ">
                            <label style="margin-left: 5px;">AREA TO BE SERVED:</label> 
                            <p class="medium-text" style="margin-left: 5px;">{{ $area_to_serve }}</p>
                        </td>
                        <td width="40%" class="custom-height ">
                            <label style="margin-left: 5px;">TYPE OF WATER SOURCE:</label> 
                            <p class="medium-text" style="margin-left: 5px;">{{ $waterSourceTypes[$water_source_type] ?? 'Unknown' }}</p>
                        </td>
                    </tr>
                </table>
                <table class="table" cellpadding="0" cellspacing="0">


                    <tr>
                        
                        <td width="100%" class="custom-height ">
                            <br>
                            <br>
                            
                            <br>
                            <p class="medium-text" align='right' style="margin-right: 80px;"><u>{{$owner_name}}</u></p>
                           <p align='right' style="margin-right: 40px;"> Signature Over Printed Name of Applicant</p>
                           <br>
                           
                           
                           <p align='right' style="margin-right: 20px;"><STRONG>TO BE ACCOMPLISHED BY THE DOH-CHD XII</STRONG></p>
                           <br>
                           <P align='right' style="margin-right: 20px;">Official Receipt:__________________________</P>
                           <P align='right' style="margin-right: 20px;">Data Issued:____________________________</P>
                           <P align='right' style="margin-right: 20px;">Amount Paid:___________________________</P>
                        </td>
                    </tr>
               
                </table>
                <br><br><br><br><br>
                <p align='right' class="large-text" style="margin-right: 20px;">DOH-CHDXII-LHSD-EOH-SOP-00-Form1 Rev.0</p>
            {{-- </div> --}}
        </div>
    </div>
</body>
</html>
