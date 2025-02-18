<div class="row">
    <div class="col-6">
      <table class="table">
        @foreach ($pr_data as $item_single)
            
        @endforeach
        <tr>
          <th>PR Number </th>
          <td>:</td>
          <th>{{ $item_single->pr_number }}</th>
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
      <table id="tbl_show_pr" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>No.</th>
            <th>Description</th>
            <th>Qty</th>
            <th>Unit</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pr_data as $item_list)
              <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item_list->description }}</td>
                  <td>{{ $item_list->quantity }}</td>
                  <td>{{ $item_list->unit }}</td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <script>
    $(function () {
      $("#tbl_show_pr").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
      });
    });
  </script>