<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <title>Order of Payment</title>
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
                    <td width="10%" style="border:none;"><center><img src="{{ public_path('images/doh.png') }}" width="80"></center></td>
                    <td width="10%" style="border:none;"><center><img src="{{ public_path('images/bagong_pilipinas.png') }}" width="90"></center></td>
                    {{-- <td width="10%" style="border:none;"><center><img src="{{ $imageBagongPilipinas }}" width="90"></center></td> --}}
                    <td width="35%" style="font-size: 12px; border:none;">
                        <center>
                            <strong class="">Republic of the Philippines</strong><br>
                            DEPARTMENT OF HEALTH<br>
                            <strong class="">CENTER FOR HEALTH DEVELOPMENT <br> SOCCSKSARGEN Region</strong><br>
                        </center>
                    </td>
                    {{-- <td width="30%" style="border:none;"><center><img src="{{ $imageDohsoccs }}" width="80"></center></td> --}}
                    <td width="30%" style="border:none;"><center><img src="{{ public_path('images/dohsoccsksargen.png') }}" width="80"></center></td>
                </tr>
                <tr>
                    <td colspan="4" style="border:none;">
                        <center>
                        <b class="extra-large-text">ORDER OF PAYMENT</b><br>
                        </center>
                    </td>
                </tr>
            </table>
           <br><br><br>
           {{-- <span class="underline">{{$fac_name}}</span> --}}
<p class="large-text">Name of Establishment/Facility: <u>{{$fac_name}}</u></p>
<p class="large-text">Address: <u>{{$fac_address}}</u>
</p>
<p class="large-text"><b>To CASHIER:</b></p>
<p class="large-text">Please charge the amount of <u>Two Thousand Six Hundred Pesos Only (P 2,600.00)</u></p>
<p class="large-text">For application of: <u>Initial Permit for Water Refilling Station</u></p>
<br><br><br>
<p class="large-text">Prepared by:</p>
<br><br><br>

<span class="large-text"><u>Name of Data Encoder</u> <br>Data Encoder</span> 


<br><br><br>
<p class="large-text">Amount:_______________</p>
<p class="large-text">O.R. no:_______________</p>
<p class="large-text">Date:_______________</p>

                
        </div>
    </div>
</body>
</html>
