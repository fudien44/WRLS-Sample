<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <title>Operational Permit</title>
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
        .ultra-large-text { font-size: 20px; }
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
                    <td width="30%" style="border:none;"><center><img src="{{ $imageDoh }}" width="80"></center></td>
                    {{-- <td width="10%" style="border:none;"><center><img src="{{ $imageBagongPilipinas }}" width="90"></center></td> --}}
                    <td width="40%" style="font-size: 12px; border:none;">
                        <center>
                            <strong class="">Republic of the Philippines</strong><br>
                            DEPARTMENT OF HEALTH<br>
                            <strong class="">CENTER FOR HEALTH DEVELOPMENT <br> SOCCSKSARGEN Region</strong><br>
                        </center>
                    </td>
                    <td width="30%" style="border:none;"><center><img src="{{ $imageBagongPilipinas }}" width="90"></center></td>

                    {{-- <td width="30%" style="border:none;"><center><img src="{{ $imageDohsoccs }}" width="80"></center></td> --}}
                </tr>
                <tr>
                    <td colspan="4" style="border:none;">
                        <center>
                        <b class="ultra-large-text">OPERATIONAL PERMIT</b><br>
                        <b class="large-text">(Retailed Water System)</b><br>
                        </center>
                    </td>
                </tr>
            </table>
           <br>
           {{-- <span class="underline">{{$fac_name}}</span> --}}
           <p align="center" class="large-text" style=" margin-bottom: 0;">
            <b>ISSUED TO:</b>
            <span class="extra-large-text" style="text-decoration: underline; text-transform: uppercase;"><b>{{$owner_name}}</b></span>
        </p>
        <span class="medium-text" style="margin-left:70px; display: block; margin-top: 0rem; font-style: italic; color: #555;">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Name of Owner/Operator)
        </span>
        <p align="center" class="medium-text" style=" margin-bottom: 0;">
            <b>ADDRESS:</b>
            <span class="medium-text" style="text-decoration: underline; text-transform: uppercase;"><b>{{$owner_address}}</b></span>
        </p>
        <p align="center" class="medium-text" style=" display: block; margin-top: 0rem; font-style: italic; color: #555;">
            Address(No., Street, City/Municipal, Province)
        </p>
        <p align="center" class="medium-text" style=" margin-bottom: 0;">
           
            <span class="medium-text" style="text-decoration: underline; text-transform: uppercase;"><b>{{$fac_name}}</b></span>
        </p>
        <p align="center" class="medium-text" style=" display: block; margin-top: 0rem; font-style: italic; color: #555;">
            NAME OF NEW/RECENTLY REPAIRED WATER SUPPLY SYSTEM
        </p>
        <p class="medium-text" style=" margin-bottom: 0;"><b>TYPE OF NEW/RECENTLY REPAIRED WATER SUPPLY SYSTEM:</b>
            @if($water_source_type == '1')
            <u>I</u>
            @elseif($water_source_type == '2')
            <u>II</u>
            @elseif($water_source_type == '3')
            <u>III</u>
            @endif
        </p>
            
        <p  class="medium-text" style="margin-left:66%; display: block; margin-top: 0rem; font-style: italic; color: #555;">
            (Level I/II/III)
        </p>
        
        <p class="medium-text">LOCATION: <u>{{$fac_address}}</u></p>
        <p class="medium-text">AREA TO BE SERVED: <u>{{$area_to_serve}}</u></p>
        <p class="medium-text">NO. OF POPULATION TO BE SERVED: <u>{{$population}}</u></p>
        <p class="medium-text">NO. OF LOTS/HOUSING UNITS: <u>{{$lots}}</u> OP NO.: <u>{{$controlNumber}}</u></p>
        

<br>

<p class="medium-text">Recommending Approval:</p>
<br><br>
<span class="medium-text"><u>KAMARUDIN M. KUNAKON, CE, SE, MPH</u> <br>Regional Sanitary Engineer</span> 
<br><br>
<br><br>
<p class="medium-text" style="margin-left: 40%;">Approved:</p>
<br><br>
<p class="medium-text" style="margin-left: 40%;"><u>ARISTIDES CONCEPCION TAN, MD, MPH, CESO III</u> <br>Director IV</span> 
    <br><br>
    <br><br>
<p class="medium-text" style=" margin-bottom: 0;">Operational Permit No. <u>{{$controlNumber}}</u></p>
<p class="medium-text" style=" margin-top: 0rem;">Date Issued: </p>
<p class="" ><b>Note: This permit will be revoked for violation of the provisions of Chapter II - "Water Supply" of the Code of Sanitation of the Philippines (P.D. 856) and its implementing rules and regulations and other existing laws and pertinent local ordinances</b> </p>
       
</div>

       
<footer style="position: fixed; bottom: 0; width: 100%; text-align: right; padding-right: 20px;">
    <p class="medium-text" style="margin: 0;">DOH-CHDXII-LHSD-EOH-SOP-00-Form3 Rev.0</p>
</footer>
    </div>
</body>
</html>
