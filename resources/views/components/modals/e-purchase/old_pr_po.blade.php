<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<div class="row">
    <div class="col-10">
        <table class="table">
            @foreach ($pr_po_data as $item_single)

            @endforeach
            <tr>
                <th>PR Number </th>
                <td>:</td>
                <th>
                    {{ $item_single->pr_number }}
                    <input type="hidden" name="txt_pr_no" id="txt_pr_no" value="{{ $item_single->pr_number }}" readonly>
                </th>
            </tr>
            <tr>
                <th>PO Number </th>
                <td>:</td>
                <th>
                    {{ $item_single->po_number }}
                    <input type="hidden" name="txt_po_no" id="txt_po_no" value="{{ $item_single->po_number }}" readonly>
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
                <th>{{ $item_single->request }}</th>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <table id="tbl_pr_po_old" class="table table-bordered table-striped">
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
                @foreach ($pr_po_data as $item_list)
                <tr>
                    <td>{{ $loop->iteration }}.</td>
                    <td>{{ $item_list->description }}</td>
                    <td>{{ $item_list->quantity }}</td>
                    <td>{{ $item_list->unit }}</td>
                    <td>@currency($item_list->price)</td>
                    <td>@currency($item_list->total_price)</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5">Sub Total</th>
                    <th>@currency($sub_total)</th>
                </tr>
                <tr>
                    <td align="right" colspan="5"><i>Disc ({{ $item_single->discount }}%)</i></td>
                    <td align="center">@currency($a_disc)</td>
                </tr>
                <tr>
                    <td align="right" colspan="5"><i>Tax ({{ $item_single->tax }}%)</i></td>
                    <td align="center">@currency($a_tax)</td>
                </tr>
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
      $("#tbl_pr_po_old").DataTable({
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
