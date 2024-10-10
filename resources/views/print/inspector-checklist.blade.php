<?php
$checklist = Session::get('checklist');
$idnum = (int)1;

$path = 'images/doh.png';
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
?>
<html lang="en">
    <head>
        <title>Inspector's checklist form</title>
        <style>
            @page {
                size: 8.5in 14in;
                /* margin: 35.56cm 21.59cm 35.56cm 21.59cm !important; */
            }
            html {
                margin: 30px !important;
            }
            .upper,
            .info,
            .table {
                width: 100%;
            }
            .upper td,
            .info td,
            .table td {
                border: 1px solid #000;
            }
            .upper td {
                padding: 10px;
            }
            .info {
                margin-top: 90px;
            }
            .info td {
                padding: 5px;
                vertical-align: top;
            }
            .table th {
                border: 1px solid #000;
            }
            .table td {
                padding: 5px;
                vertical-align: top;
            }
            .ow {
                overflow-wrap: break-word;
                word-wrap: break-word;
                hyphens: auto;
            }
            .fs {
                font-family: Arial, sans-serif;
                font-size: 11px;
            }
            .alc {
                text-align: center;
            }

            .form-group label {
                display: block;
                margin-bottom: 5px;
            }

            .form-control {
                margin-top: -5px;
                margin-left: 255px;
                border: none;
                border-bottom: 1px solid black;
            }
            .item {
                display: inline-block;
            }
        </style>
    </head>

    <body>
        <table class="upper" cellpadding="0" cellspacing="0">
            <tr>
                <td width="20%" style="border: none">
                    <center>
                        <img
                            style="height: 6%; width: 60%; margin-left: 150px"
                            src="<?php echo $base64?>"
                            alt="Image not available"
                        />
                    </center>
                </td>
                <td width="60%" style="font-size: 11pt; border: none">
                    <center>
                        Republic of the Philippines<br />
                        <div style="font-size: 15pt">Department of Health</div>
                        <strong>CENTER FOR HEALTH DEVELOPMENT <br /></strong>
                        SOCCSKSARGEN REGION
                    </center>
                </td>
                <td style="border: none"><center></center></td>
            </tr>
        </table>

        <div style="margin-top: 35px; margin-bottom: 70px">
            <div style="float: left; border: 0px solid black">
                <div>
                    <b style="font-size: smaller">NAME OF REFILLING STATION: </b
                    ><u>{{ $checklist["facility_name"] }}</u>
                </div>
                <div style="margin-top: 0px">
                    <b style="font-size: smaller">ADDRESS: </b
                    ><u>{{ $checklist["facility_address"] }}</u>
                </div>
                <div style="margin-top: 0px">
                    <b style="font-size: smaller">OWNER/OPERATOR: </b
                    ><u>{{ $checklist["owner_name"] }}</u>
                </div>
                <div style="margin-top: 0px">
                    <b style="font-size: smaller">PERSONNEL:</b> Number:____with
                    Health Certificates_____
                </div>
            </div>
            <div style="float: right; border: 0px solid black">
                <div style="margin-left: 225px">
                    <b style="font-size: smaller">TEL. Nos.: </b
                    ><u>{{ $checklist["facility_telephone"] }}</u>
                </div>
                <div style="margin-top: 0px; margin-left: 225px">
                    <b style="font-size: smaller">DELIVERY: </b
                    ><label style="font-size: smaller"
                        >with:_____w/o:_____</label
                    >
                </div>
                <div style="margin-top: 0; margin-left: 76px">
                    <b style="font-size: smaller">PLANT MGR./SUPERVISOR: </b
                    >_____________________
                </div>
                <div style="margin-top: 0px; margin-left: 61px">
                    <b style="font-size: smaller">SANITARY PERMIT: </b
                    ><label style="font-size: smaller"
                        >No.__________Date Issued:__________</label
                    >
                </div>
            </div>
        </div>

        <!-- <table
            width="100%"
            cellspacing="0"
            class="table"
            style="table-layout: fixed; margin-top: 35px"
        >
            <tr>
                <td style="border: none" colspan="2">
                    <b>NAME OF REFILLING STATION: </b
                    ><u>{{ $checklist["facility_name"] }}</u>
                </td>
                <td style="border: none">
                    <b>TEL. Nos.:</b>
                    <u>{{ $checklist["facility_telephone"] }}</u>
                </td>
            </tr>
            <tr>
                <td style="border: none" colspan="2">
                    <b>ADDRESS: </b><u>{{ $checklist["facility_address"] }}</u>
                </td>
                <td style="border: none"><b>DELIVERY:</b>with_____w/o_____</td>
            </tr>
            <tr>
                <td style="border: none" colspan="2">
                    <b>OWNER/OPERATOR: </b><u>{{ $checklist["owner_name"] }}</u>
                </td>
                <td style="border: none" colspan="2">
                    <b>PLANT MGR./SUPERVISOR:</b
                    >_____________________________
                </td>
            </tr>
            <tr>
                <td style="border: none" colspan="2">
                    <b>PERSONNEL:</b> Number:____with Health Certificates_____
                </td>
                <td style="border: none;" colspan="2">
                    <b>SANITARY PERMIT: </b>No._______Date Issued:________
                </td>
            </tr>
        </table> -->
        <br />

        <table
            width="100%"
            cellspacing="0"
            class="table"
            style="table-layout: fixed; margin-top: -10px"
        >
            <thead>
                <tr>
                    <th>
                        ITEMS <br />
                        <label style="font-size: small; font-weight: normal"
                            >(see attached Sanitation Standard for each
                            item)</label
                        >
                    </th>
                    <th style="width: 15%">
                        DEMERITS <br />(X)<br /><label
                            style="font-size: xx-small; font-weight: normal"
                            >(a demerit for any one non-complying under the
                            sanitation standard item heading)</label
                        >
                    </th>
                    <th>
                        RECOMMENDED SPECIFIC CORRECTIVE MEASURES <br />
                        <label style="font-size: small; font-weight: normal"
                            >(use additional sheet if necessary)</label
                        >
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-size: small">1. QUALITY OF SOURCE WATER</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size: small">
                        2. QUALITY OF REFILLED/PRODUCT WATER
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size: small">
                        3. PROTECTION OF PRODUCT WATER
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size: small">
                        4. WATER PURIFICATION PROCESS
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size: small">5. FILLING AND CAPPING</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size: small">
                        6. CONTAINERS, CAPS AND DISPENSERS
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size: small">7. WASHING AND SANITIZING</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size: small">8. STORAGE OF WATER</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size: small">
                        9. TRANSPORT OF PRODUCT WATER
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size: small">
                        10. ROOM/FACILITY AREA ALLOCATION
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size: small">
                        11. CONSTRUCTION OF PREMISES
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size: small">
                        12. MAINTENANCE OF PREMISES
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size: small">13. TOILET FACILITIES</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size: small">14. HANDWASHING FACILITIES</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size: small">15. SANITARY PLUMBING</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size: small">
                        16. LIQUID WASTE MANAGEMENT
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size: small">17. SOLID WASTE MANAGEMENT</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size: small">18. VERMIN CONTROL</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size: small">19. PERSONNEL REQUIREMENTS</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-size: small">20. MISCELLANEOUS</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="border: none; font-weight: bold">
                        <center>TOTAL DEMERITS................</center>
                    </td>
                    <td style="height: 20px"></td>
                    <td style="border: none"></td>
                </tr>
            </tbody>
        </table>
        <br />
        <div class="container" style="display: flex">
            <div class="item" style="border: 10px solid black; width: 20%">
                <b
                    >PERCENTAGE <br />
                    RATING(%)</b
                >
                <br />
                (100% Less Total Demerits)
            </div>
            <div
                class="item"
                style="
                    border: 10px solid black;
                    margin-left: -6px;
                    width: 7%;
                    height: 76px;
                "
            ></div>
            <div class="item" style="margin-left: 16px; height: 86px">
                <b style="font-size: small">NOTE:</b
                ><label style="font-size: small"
                    >Non-complying item is indicated with an (x). Every such
                    item is weighted <br />
                    with a demerit of 5. The rating of the establishment is
                    therefore 100 less <br />
                    (number of demerit x 5). The result is expressed as a
                    percentage (%) rating.</label
                ><br /><br /><b style="font-size: small"
                    ><u>SANITATION STANDARD PERCENTAGE RATING</u></b
                ><br />
                <d style="margin-left: 50px"
                    >EXCELLENT .............. 90% - 100%</d
                ><br />
                <d style="margin-left: 17px"
                    >VERY SATISFACTORY ...... 70% - 89%</d
                ><br />
                <d style="margin-left: 39px"
                    >SATISFACTORY ............. 50% - 69%</d
                >
            </div>
        </div>
        <br /><br />
        <div style="width: 100%; margin-top: 30px">
            <div style="float: left"><b>Received by:</b></div>
            <div style="float: right; margin-right: 160px">
                <b>Evaluated/Inspected by:</b>
            </div>
        </div>
        <br /><br />
        <div style="margin-top: 20px">
            <div style="float: left">
                <div style="margin-left: 70px">
                    <input style="border-top: 1px solid black; width: 110%" />
                    <div style="margin-top: 0px; font-size: smaller">
                        Owner/Manager/Supervisor
                    </div>
                </div>
                <div style="margin-left: 70px; margin-top: 20px">
                    <input style="border-top: 1px solid black; width: 100%" />
                    <div
                        style="
                            margin-top: -20px;
                            font-size: smaller;
                            margin-left: 60px;
                        "
                    >
                        Date
                    </div>
                </div>
            </div>
            <div style="float: right; margin-right: 60px">
                <div style="margin-left: 70px">
                    <input style="border-top: 1px solid black; width: 110%" />
                    <div style="margin-top: 0px; font-size: smaller">
                        Owner/Manager/Supervisor
                    </div>
                </div>
                <div style="margin-left: 70px; margin-top: 20px">
                    <input style="border-top: 1px solid black; width: 100%" />
                    <div
                        style="
                            margin-top: -20px;
                            font-size: smaller;
                            margin-left: 60px;
                        "
                    >
                        Date
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-top: 90px; width: 100%">
            <div style="float: right">
                DOH-CHDXII-LHSD-EOH-SOP-01-Form1 Rev.0
            </div>
        </div>
    </body>
</html>
