<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>SATUPINTU - APP | Purchase Request Order</title>
    <style>
        .image_logo{
            max-height: 50px;
            width: auto;
        }
    </style>
</head>

<body style="margin:0px; background: #f8f8f8; ">
<div width="100%" style="background: #f8f8f8; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
    <div style="max-width: 700px; padding:50px 0;  margin: 0px auto; font-size: 14px">
        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px">
            <tbody>
            <tr>
                <td style="vertical-align: top; padding-bottom:30px; background-color: white" align="center">
                    <img src="{{ asset('assets/dist/img/Inlingua_Logo-removebg-preview.png') }}" width="300" alt="Inlingua" style="border:none">
                </td>
            </tr>
            </tbody>
        </table>
        <div style="padding: 40px; background: #fff;">
            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                <tbody>
                    <tr>
                        <td>
                            <b>Dear {{ $manager }},</b>
                            <p>You get a message from {{ $fullname }}, waiting for PR ( Purchase Request ) approval.</p>
                            
                            <ul>
                                <li><b>Job Number :</b> </li>
                                <li><b>PR Number : </b> </li>
                            </ul>
                            <table class="table" border="1" cellpadding="0" cellspacing="0" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Desc</th>
                                        <th>Qty</th>
                                        <th>Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            <p>Please proceed to <a href="#"><b>EMS - APP</b>.</a></p>
                            <p>Kind regards,</p>
                            <p>EMS - APP</p>
                            <br>
                            <p>inlingua International Indonesia</p>
                            <p >Jl. Puri Indah Raya Kav A3 No. 2, Kembangan, Jakarta Barat 11610</p>
                            <p >T +62 21 583 55 088 </p>
                            <p><a href="https://inlingua.co.id/">www.inlingua.co.id</a></p>
                            <img src="{{ asset('asset/img/inl_wscc.png') }}" width="300" alt="inl wscc" style="border:none">
                            <p style="color: #3366ff; font-weight: 600"><i>“We keep growing and never stop learning”</i></p>
                        </td>
                    </tr>
                </tbody>
            </table>
            
        </div>
        <div style="text-align: center; font-size: 12px; color: #b2b2b5; margin-top: 20px">
            <p> Powered by Sulistiya Nugroho
                <br>
        </div>
    </div>
</div>
</body>

</html>