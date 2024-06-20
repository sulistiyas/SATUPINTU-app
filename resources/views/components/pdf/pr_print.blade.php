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
                    Purchase Request
                </td>
            </tr>
        </tbody>
    </table>
    <div style="background: #fff;">
        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
            <tbody>
                <td>
                    <table style="margin-top: -40px">
                        <tbody>
                            <tr id="top-left-2">
                                <th align="left">PR Number</th>
                                <th>:</th>
                                <th><input type="text" style="background: lightgray" readonly value="{{ $pr_no }}"></th>
                            </tr>
                            <br>
                            <tr id="top-left-3">
                                <th align="left">Vendor</th>
                                <th>:</th>
                                <th>(Note : Please only use info below)</th>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    {{-- Header Data --}}
                    @php
                        $header_data = DB::table('pr')
                                    ->join('employee','employee.id_employee','=','pr.id_employee')
                                    ->join('users','users.id','=','employee.id_users')
                                    ->where('pr.pr_no','=',$pr_no)->get();
                    @endphp
                    @foreach ($header_data as $item_header)
                        
                    @endforeach
                    <table>
                        <tbody>
                            <br>
                            <tr id="top-left-2">
                                <th align="left">Date</th>
                                <th>:</th>
                                <th>{{ $item_header->pr_date }}</th>
                            </tr>
                            <br>
                            <tr id="top-right">
                                <th align="left">Request Order</th>
                                <th>:</th>
                                <th></th>
                            </tr>
                            <tr id="top-right-2">
                                <td>Name</td>
                                <td>:</td>
                                <td id="td1">{{ $item_header->name }}</td>
                            </tr>
                            <tr id="top-right-2">
                                <td>Job Number</td>
                                <td>:</td>
                                <td id="td1">{{ $item_header->job_number }}</td>
                            </tr>
                            <tr id="top-right-2">
                                <td>Division</td>
                                <td>:</td>
                                <td id="td1">{{ $item_header->emp_division }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tbody>
        </table>
        <br><br>
        {{-- PR Table Data Content --}}
        @php
            $pr_table = DB::table('pr')->where('pr_no','=',$pr_no)->get();
        @endphp
        <table border="1" cellpadding="0" cellspacing="0" style="width: 100%;" id="pr">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Unit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pr_table as $item_pr)
                    <tr>
                        <td>{{ $loop->iteration }}.</td>
                        <td>{{ $item_pr->pr_desc }}</td>
                        <td>{{ $item_pr->pr_qty }}</td>
                        <td>{{ $item_pr->pr_unit }}</td>
                    </tr>
                @endforeach
            </tbody>
            {{-- <tfoot>
                <tr>
                    <th id="sub" colspan="5">Sub Total</th>
                    <th></th>
                </tr>
                <tr>
                    <td align="right" colspan="5"><i>Disc (0%)</i></td>
                    <td></td>
                </tr>
                <tr>
                    <td align="right" colspan="5"><i>Tax(11%)</i></td>
                    <td></td>
                </tr>
                <tr>
                    <th id="sub" colspan="5"> Grand Total</th>
                    <th></th>
                </tr>
            </tfoot> --}}
        </table>
        {{-- Bottom Data --}}
        @php
            $bot_data = DB::table('pr')
                        ->join('employee','employee.id_employee','=','pr.id_manager')
                        ->join('users','users.id','=','employee.id_users')
                        ->where('pr.pr_no','=',$pr_no)->get();
        @endphp
        @foreach ($bot_data as $bot_item)
            
        @endforeach
        <div class="section">
            @if ($bot_item->pr_status == '3' || $bot_item->pr_status == '2' || $bot_item->pr_status == '1')
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