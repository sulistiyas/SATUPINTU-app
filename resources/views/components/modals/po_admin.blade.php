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
                <th>
                    <select name="txt_id_vendor" id="txt_id_vendor" class="form-control select2bs4">
                        @foreach ($vendor_data as $item_vendor)
                            <option value="{{ $item_vendor->id_vendor }}">{{ $item_vendor->vendor }}</option>
                        @endforeach
                        
                    </select>
                </th>
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
                        {{ $loop->iteration }}
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
                    <th colspan="5">Grand Total</th>
                    <th>
                        @foreach ($total_prices as $grand)
                            @currency($grand->grand_total)
                        @endforeach
                    </th>
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
