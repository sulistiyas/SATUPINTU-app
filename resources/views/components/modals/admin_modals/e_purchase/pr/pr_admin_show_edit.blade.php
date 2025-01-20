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
          <input type="hidden" name="txt_pr_number" value="{{ $item_single->pr_no }}">
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
    </table>
  </div>
</div>
<div class="row">
  <div class="col-12">
    <table id="tbl_edit_pr" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No.</th>
          <th>Description</th>
          <th>Qty</th>
          <th>Unit</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data_pr as $item_list)
            <tr>
                <td>{{ $loop->iteration }}.</td>
                <td>
                  <input type="hidden" name="txt_id_pr[]" value="{{ $item_list->id_pr }}">
                  <input type="text" class="form-control" name="txt_desc[]" value="{{ $item_list->pr_desc }}" required>
                </td>
                <td>
                  <input type="number" class="form-control" name="txt_pr_qty[]" value="{{ $item_list->pr_qty }}" required>
                </td>
                <td>
                  <select name="unit[]" id="unit[]" class="form-control select2bs4">
                    <option value="Unit">- Select Unit Type -</option>
                    <option value="Unit" {{ $item_list->pr_unit == "Unit" ? 'selected': '' }}>Unit</option>
                    <option value="Pcs" {{ $item_list->pr_unit == "Pcs" ? 'selected': '' }}>Pcs</option>
                    <option value="Lusin" {{ $item_list->pr_unit == "Lusin" ? 'selected': '' }}>Lusin</option>
                    <option value="Pack" {{ $item_list->pr_unit == "Pack" ? 'selected': '' }}>Pack</option>
                    <option value="Box" {{ $item_list->pr_unit == "Box" ? 'selected': '' }}>Box</option>
                    <option value="Pages" {{ $item_list->pr_unit == "Pages" ? 'selected': '' }}>Pages</option>
                    <option value="Rim" {{ $item_list->pr_unit == "Rim" ? 'selected': '' }}>Rim</option>
                  </select>
                </td>
            </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<script>
  $(function () {
    $("#tbl_edit_pr").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
    });
  });
</script>