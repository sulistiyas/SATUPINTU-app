<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<div class="row">
    <div class="col-10">
        <table class="table">
            @foreach ($data_po as $item_single)

            @endforeach
            <tr>
                <th>PR Number </th>
                <td>:</td>
                <th>
                    {{ $item_single->pr_no }}
                    <input type="hidden" name="txt_pr_no" id="txt_pr_no" value="{{ $item_single->pr_no }}" readonly>
                </th>
            </tr>
            <tr>
                <th>PO Number </th>
                <td>:</td>
                <th>
                    {{ $item_single->po_no }}
                    <input type="hidden" name="txt_po_no" id="txt_po_no" value="{{ $item_single->po_no }}" readonly>
                </th>
            </tr>
            <tr>
                <th>Job Number </th>
                <td>:</td>
                <th>{{ $item_single->job_number }}</th>
            </tr>
            <tr>
                <th>Requester </th>
                <td>:</td>
                <th>{{ $item_single->name }}</th>
            </tr>
            <tr>
                <th>Vendor </th>
                <td>:</td>
                <th>{{ $item_single->vendor }}</th>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <table id="tbl_po_submit" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data_po as $item_list)
                <tr>
                    <td>
                        {{ $loop->iteration }}.
                        <input type="hidden" name="txt_id_po" id="txt_id_po" value="{{ $item_list->id_po }}">
                    </td>
                    <td>{{ $item_list->pr_desc }}</td>
                    <td>
                        {{ $item_list->pr_qty }}
                    </td>
                    <td>{{ $item_list->pr_unit }}</td>
                    <td>
                        @currency($item_list->price)
                        <input type="hidden" name="txt_count_data[]" id="txt_count_data[]" value="{{ $loop->iteration }}">
                        
                    </td>
                    <td>
                        @currency($item_list->total_price)
                        <input type="hidden" name="txt_total_price" id="txt_total_price" value="{{ $loop->iteration }}">
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5">Sub Total</th>
                    <th>@currency($sub)</th>
                </tr>
                <tr>
                    <td align="right" colspan="5"><i>Disc ({{ $item_single->po_disc }}%)</i></td>
                    <td align="center">@currency($a_disc)</td>
                </tr>
                <tr>
                    <td align="right" colspan="5"><i>Tax ({{ $item_single->po_tax }}%)</i></td>
                    <td align="center">@currency($a_tax)</td>
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
                    <th colspan="5">Grand Total</th>
                    <th>@currency($grand_total)</th>
                </tr>
            </tfoot>
            
        </table>
    </div>
</div>
<script>
    $(function () {
      $("#tbl_po_submit").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
      });
    });
</script>
<!-- Select2 -->
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
    })
</script>
