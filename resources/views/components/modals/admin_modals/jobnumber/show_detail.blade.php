
<div class="row">
  <div class="col-12">
    <table class="table">
      <tbody>
        @foreach ($jn_data as $item_jn)
            
        @endforeach
        <tr>
          <th>Job Number</th>
          <th> : </th>
          <td>{{ $item_jn->job_number }}</td>
        </tr>
        <tr>
          <th>Client</th>
          <th> : </th>
          <td>{{ $item_jn->nama_perusahaan }}</td>
        </tr>
        <tr>
          <th>Contract Number</th>
          <th> : </th>
          <td>{{ $item_jn->contract_no }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="row">
  <div class="col-12">
    <table id="tbl_show_jn" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>PIC</th>
          <th>CP</th>
          <th>Start Date</th>
          <th>End Date</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($jn_data as $item)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $item->pic }}</td>
          <td>{{ $item->c_p }}</td>
          <td>{{ $item->starting_date }}</td>
          <td>{{ $item->ending_date }}</td>
          <td>{{ $item->status }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<script>
  $(function () {
    $("#tbl_show_jn").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
    });
  });
</script>