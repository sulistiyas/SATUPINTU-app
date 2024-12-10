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
    <style>
        #po {
          font-family: Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }
        
        #po td, #po th {
          border: 1px solid #ddd;
          padding: 8px;
        }
        
        #po tr:nth-child(even){background-color: #f2f2f2;}
        
        #po tr:hover {background-color: #ddd;}
        
        #po th {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: left;
          background-color: #2563d4;
          color: white;
        }

        #po #sub {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: right;
          background-color: #2563d4;
          color: white;
        }

        #po #sub2 {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: center;
          background-color: #2563d4;
          color: white;
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
        @foreach ($po_data as $po_datas)
            
        @endforeach
        <div style="padding: 40px; background: #fff;">
            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                <tbody>
                    <tr>
                        <td>
                            <b>Dear {{ $manager }},</b>
                            <br>
                            <p>You get a message from {{ $ga }}, waiting for PO approval</b>.</p>
                            {{-- <p>Please Confirm to General Affair (GA) for Purchase Order (PO) Request</p> --}}
                            
                            <ul>
                                <li><b>Job Number : {{ $po_datas->job_number }}</b></li>
                                <li><b>PR Number : {{ $po_datas->pr_no }}</b> </li>
                                <li><b>PO Number : {{ $po_datas->po_no }}</b> </li>
                                <li><b>Items :</b> </li>
                            </ul>
                            <table id="po">
                                <thead>
                                    <tr align="center">
                                        <th style="font-weight: 900;">No.</th>
                                        <th style="font-weight: 900;">Desc</th>
                                        <th style="font-weight: 900;">Qty</th>
                                        <th style="font-weight: 900;">Unit</th>
                                        <th style="font-weight: 900;">Price</th>
                                        <th style="font-weight: 900;">Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($po_data as $item_po)
                                        <tr align="left">
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>{{ $item_po->pr_desc }}</td>
                                            <td align="center">{{ $item_po->pr_qty }}</td>
                                            <td>{{ $item_po->pr_unit }}</td>
                                            <td>@currency($item_po->price)</td>
                                            <td>@currency($item_po->total_price)</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th id="sub" colspan="5">Sub Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th id="sub2">@currency($sub_total)</th>
                                    </tr>
                                    <tr>
                                        <td align="right" colspan="5"><i>Disc&nbsp;({{ $po_datas->po_disc }}%)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></td>
                                        <td align="center">@currency($disc)</td>
                                    </tr>
                                    <tr>
                                        <td align="right" colspan="5"><i>Tax&nbsp;({{ $po_datas->po_tax }}%)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></td>
                                        <td align="center">@currency($tax)</td>
                                    </tr>
                                    @if ($service_charge == Null && $delivery_fee == NULL && $addtional_charge == NULL)
                                        
                                    @elseif($delivery_fee == NULL && $addtional_charge == NULL)
                                        <tr>
                                            <td align="right" colspan="5"><i>Service Charge&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></td>
                                            <td align="center">@currency($service_charge)</td>
                                        </tr>
                                    @elseif($addtional_charge == NULL)
                                        <tr>
                                            <td align="right" colspan="5"><i>Service Charge&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></td>
                                            <td align="center">@currency($service_charge)</td>
                                        </tr>
                                        <tr>
                                            <td align="right" colspan="5"><i>Delivery Charge&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></td>
                                            <td align="center">@currency($delivery_fee)</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td align="right" colspan="5"><i>Service Charge&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></td>
                                            <td align="center">@currency($service_charge)</td>
                                        </tr>
                                        <tr>
                                            <td align="right" colspan="5"><i>Delivery Charge&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></td>
                                            <td align="center">@currency($delivery_fee)</td>
                                        </tr>
                                        <tr>
                                            <td align="right" colspan="5"><i>Additional Charge&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></td>
                                            <td align="center">@currency($addtional_charge)</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th id="sub" colspan="5">Grand Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th id="sub2">@currency($grand_total)</th>
                                    </tr>
                                    
                                </tfoot>
                            </table>
                            <p>Please proceed to <a href="#"><b>SATUPINTU - APP</b>.</a></p>
                            <p>Kind regards,</p>
                            <p>SATUPINTU - APP</p>
                            <br>
                            <p>inlingua International Indonesia</p>
                            <p >Jl. Puri Indah Raya Kav A3 No. 2, Kembangan, Jakarta Barat 11610</p>
                            <p >T +62 21 583 55 088 </p>
                            <p><a href="https://inlingua.co.id/">www.inlingua.co.id</a></p>
                            <img src="{{ asset('assets/dist/img/inl_wscc.png') }}" width="300" alt="inl wscc" style="border:none">
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