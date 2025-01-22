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
          <input type="hidden" name="txt_pr_title" value="{{ $item_single->pr_title }}">
          <input type="hidden" name="txt_jn" value="{{ $item_single->job_number }}">
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
        <td>
          
        </td>
      </tr>
    </table>
    <button type="button" class="float-sm-left btn btn-primary" id="add_btn" name="add_btn">
      <i class="fas fa-plus">&nbsp;Add New Row</i>
    </button>
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
          <th><i class="fas fa-cog"></i></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data_pr as $item_list)
            <tr>
                <td>
                  <input type="hidden" name="txt_id_pr[]" value="{{ $item_list->id_pr }}">
                  {{ $loop->iteration }}.
                </td>
                <td>{{ $item_list->pr_desc }}</td>
                <td>{{ $item_list->pr_qty }}</td>
                <td>{{ $item_list->pr_unit }}</td>
                <td></td>
            </tr>
        @endforeach
      </tbody>
      <tbody id="container">
        {{--  --}}
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
<script type="text/javascript">
  // Datatables
  // $(function () {
  //   $("#tbl_create_pr").DataTable({
  //     "responsive": true, "lengthChange": false, "autoWidth": false,
      
  //   }).buttons().container().appendTo('#tbl_create_pr_wrapper .col-md-6:eq(0)');
  // });
  $(document).ready(function() {
      var count = 0;
      $("#add_btn").click(function(){
          count += 1;
          $('#container').append(
              '<tr id="row">'
                    + '<td></td>'
                    + '<td><input id="description[]" class="form-control" name="description[]" type="textdomain" maxlength="45" placeholder="Input Description Max 45 Character"></td>'
                    + '<td><input id="quantity[]" class="form-control" name="quantity[]" type="number" placeholder="Input Quantity only number"></td>'
                    + '<td>'
                      + '<select name="unit[]" id="unit[]" class="form-control select2bs4">'
                        + '<option value="Unit">- Select Unit Type -</option>'
                        + '<option value="Unit">Unit</option>'
                        + '<option value="Pcs">Pcs</option>'
                        + '<option value="Lusin">Lusin</option>'
                        + '<option value="Pack">Pack</option>'
                        + '<option value="Box">Box</option>'
                        + '<option value="Pages">Pages</option>'
                        + '<option value="Rim">Rim</option>'
                      + '</select>'
                    +'</td>'
                  + '<td><button class="btn btn-danger" id="DeleteRow" type="button">Delete</button></td>'
                   + '<input id="rows[]" name="rows[]" value="'+ count +'" type="hidden"></td></tr>'
          );
      });
      $("body").on("click", "#DeleteRow", function () {
          $(this).parents("#row").remove();
      })
  });
</script>