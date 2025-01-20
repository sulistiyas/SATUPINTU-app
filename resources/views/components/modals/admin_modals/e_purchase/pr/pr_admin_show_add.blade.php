<div class="row">
  <div class="col-6">
    <table class="table">
      @foreach ($data_pr as $item_single)
          
      @endforeach
      <tr>
        <th>PR Number </th>
        <td>:</td>
        <th>{{ $item_single->pr_no }}</th>
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
    <table id="tbl_add_pr" class="table table-bordered table-striped">
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
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item_list->pr_desc }}</td>
                <td>{{ $item_list->pr_qty }}</td>
                <td>{{ $item_list->pr_unit }}</td>
            </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<script>
  $(function () {
    $("#tbl_add_pr").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
    });
  });
</script>