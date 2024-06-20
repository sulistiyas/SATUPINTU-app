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
        #pr {
          font-family: Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }
        
        #pr td, #pr th {
          border: 1px solid #ddd;
          padding: 8px;
        }
        
        #pr tr:nth-child(even){background-color: #f2f2f2;}
        
        #pr tr:hover {background-color: #ddd;}
        
        #pr th {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: left;
          background-color: lightslategray;
          color: white;
        }

        #pr #sub {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: right;
          background-color: lightslategray;
          color: white;
        }

        #pr #sub2 {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: center;
          background-color: lightslategray;
          color: white;
        }
    </style>
    <style>
        #td1 {
            border: 1px solid black;
        }
    </style>
    <style>
        #top-left{
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 26;
            padding-right:40px;
        }
        #top-left-2{
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 11;
            
        }
        #top-left-3{
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 10;
        }

        #top-left-4{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10;
        }

        #top-right{
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 10;
        }

        #top-right-2{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10;
        }
    </style>
</head>

<body style="margin:0px; background: white; ">
    <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-top: -20px; background-color: white">
        <tbody>
            <tr>
                <td style="padding-left:35px;" align="left">
                    <img src="{{ asset('assets/dist/img/Inlingua_Logo-removebg-preview.png') }}" width="200" alt="Inlingua" style="border:none">
                </td>
                <td align="right" id="top-left">
                    Purchase Order
                </td>
            </tr>
        </tbody>
    </table>
    <div style="background: #fff;">
        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
            <tbody>
                <td>
                    <table style="margin-top: -80px">
                        <tbody>
                            <tr id="top-left-2">
                                <th align="left">PO Number</th>
                                <th>:</th>
                                <th><input type="text" style="background: lightgray" readonly value="{{ $po_no }}"></th>
                            </tr>
                            <br>
                            <tr id="top-left-3">
                                <th align="left">Vendor</th>
                                <th>:</th>
                                <th>(Note : Please only use info below)</th>
                            </tr>
                            <tr id="top-left-4">
                                <td>PT. Blabla</td>
                            </tr>
                            <tr id="top-left-4">
                                <td>Attn</td>
                                <td>:</td>
                                <td>Si anu itu lupa</td>
                            </tr>
                            <tr id="top-left-4">
                                <td>No. Ref Quo</td>
                                <td>:</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    {{-- Header Data --}}
                    @php
                        $header_data = DB::table('po')
                                    ->join('pr', 'pr.id_pr', '=', 'po.id_pr')
                                    ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
                                    ->join('users', 'users.id', '=', 'employee.id_users')
                                    ->where('po.po_no', '=', $po_no)->get();
                    @endphp
                    @foreach ($header_data as $item_header)
                        
                    @endforeach
                    <table>
                        <tbody>
                            <br>
                            <tr id="top-left-2">
                                <th align="left">Date</th>
                                <th>:</th>
                                <th align="left" >{{ date('l, j F Y',strtotime($item_header->po_date)) }}</th>
                            </tr>
                            </tr>
                            <br>
                            <tr id="top-right">
                                <th align="left">Ship To</th>
                                <th>:</th>
                                <th>(Site to be shipped)</th>
                            </tr>
                            <tr id="top-right-2">
                                <td>Name</td>
                                <td>:</td>
                                <td id="td1">{{ $item_header->name }}</td>
                            </tr>
                            <tr id="top-right-2">
                                <td>Company</td>
                                <td>:</td>
                                <td id="td1">PT.inlingua</td>
                            </tr>
                            <tr id="top-right-2">
                                <td>Address</td>
                                <td>:</td>
                                <td id="td1">Gd. inlingua</td>
                            </tr>
                            <tr id="top-right-2">
                                <td></td>
                                <td></td>
                                <td id="td1">Jl. Puri Indah Raya Kav A3 No. 33-35</td>
                            </tr>
                            <tr id="top-right-2">
                                <td></td>
                                <td></td>
                                <td id="td1">Jakarta Barat (11610)</td>
                            </tr>
                            <tr id="top-right-2">
                                <td>Phone</td>
                                <td>:</td>
                                <td id="td1">(021) 583 55 088</td>
                            </tr>
                            <tr>
                                <td>e-Mail</td>
                                <td>:</td>
                                <td id="td1">asdasdasd@gmail.com</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tbody>
        </table>
        <br><br>
        {{-- Table Data Content --}}
        @php
            $po_table = DB::table('po')
                ->join('pr', 'pr.id_pr', '=', 'po.id_pr')
                ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
                ->join('users', 'users.id', '=', 'employee.id_users')
                ->where('po.po_no', '=', $po_no)->get();
            
            $sub_total = DB::table('po')->selectRaw('SUM(total_price) as sub_total')->where('po_no', '=', $po_no)->get();
                foreach ($sub_total as $subs) {
                    $sub = $subs->sub_total;
                }
                
            foreach ($po_table as $data_bal) {
                $disc   = $data_bal->po_disc;
                $tax    = $data_bal->po_tax;
            }

            $a_disc = ($disc / 100) * $sub;
            $a_tax = ($tax / 100) * $sub;

            $grand_total = $sub - $a_disc + $a_tax;
        @endphp
        <table border="1" cellpadding="0" cellspacing="0" style="width: 100%;" id="pr">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($po_table as $item_pr)
                    <tr>
                        <td>{{ $loop->iteration }}.</td>
                        <td>{{ $item_pr->pr_desc }}</td>
                        <td>{{ $item_pr->pr_qty }}</td>
                        <td>{{ $item_pr->pr_unit }}</td>
                        <td>@currency($item_pr->price)</td>
                        <td>@currency($item_pr->total_price)</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th id="sub" colspan="5">Sub Total</th>
                    <th>@currency($sub)</th>
                </tr>
                <tr>
                    <td align="right" colspan="5"><i>Disc ({{ $item_pr->po_disc }}%)</i></td>
                    <td>@currency($a_disc)</td>
                </tr>
                <tr>
                    <td align="right" colspan="5"><i>Tax({{ $item_pr->po_tax }}%)</i></td>
                    <td>@currency($a_tax)</td>
                </tr>
                <tr>
                    <th id="sub" colspan="5"> Grand Total</th>
                    <th>@currency($grand_total)</th>
                </tr>
            </tfoot>
        </table>
        {{-- Bottom Data --}}
        @php
            $bot_data = DB::table('po')
                ->join('pr', 'pr.id_pr', '=', 'po.id_pr')
                ->join('employee','employee.id_employee','=','pr.id_manager')
                ->join('users', 'users.id', '=', 'employee.id_users')
                ->where('po.po_no', '=', $po_no)->get();
        @endphp
        @foreach ($bot_data as $bot_item)
            
        @endforeach
        <div class="section">
            @if ($bot_item->po_status == '1')
                <p id="top-left-2" style="margin-top: 40px">Authorized by,</p>    
                <p id="top-right-2" style="margin-top: 20px"><u>{{ $bot_item->name }}</u></p>
                <p id="top-right-2">inlingua</p>
            @else
                <p id="top-left-2">Not Approved By Manager</p>    
            @endif
            
        </div>
    </div>
    <div style="text-align: center; font-size: 12px; color: #b2b2b5; margin-top: 20px">
        <p> Copyright &copy; 2024-2025 <a href="https://github.com/sulistiyas">Sulistiya Nugroho</a>.</p>
            <br>
    </div>
</div>
</body>
</html>