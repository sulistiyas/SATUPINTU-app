<div class="row">
    <div class="col-6">
      <table class="table">
        @foreach ($data_pr as $item_single)
            
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
          <th>Currency </th>
          <td>:</td>
          <th>
            <select name="txt_currency" id="txt_currency" class="form-control">
              <option value="IDR">IDR</option>
              <option value="$">USD</option>
            </select>
          </th>
        </tr>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <table id="tbl_price" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>No.</th>
            <th>Description</th>
            <th>Qty</th>
            <th>Unit</th>
            <th>Price (Per Unit)</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data_pr as $item_list)
              <tr>
                  <td>
                    {{ $loop->iteration }}
                    <input type="hidden" name="txt_id_pr[]" id="txt_id_pr[]" value="{{ $item_list->id_pr }}">
                    <input type="hidden" name="txt_po_no[]" id="txt_po_no[]" value="{{ $po_no }}">
                  </td>
                  <td>{{ $item_list->pr_desc }}</td>
                  <td>
                    {{ $item_list->pr_qty }}
                    <input type="hidden" name="txt_qty_pr[]" id="txt_qty_pr[]" value="{{ $item_list->pr_qty }}">
                  </td>
                  <td>{{ $item_list->pr_unit }}</td>
                  <td>
                    <input type="number" name="txt_price[]" id="txt_price[]" class="form-control" required>
                    <input type="hidden" name="txt_count[]" id="txt_count[]" value="{{ $loop->iteration }}">
                  </td>
              </tr>
          @endforeach
          
        </tbody>
      </table>
    </div>
</div>
  <script>
    $(function () {
      $("#tbl_price").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
      });
    });
  </script>