  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <table id="tbl_show_pr" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Request</th>
                    <th>Desc</th>
                    <th>PR Number</th>
                    <th>Date PR</th>
                    <th>PO Number</th>
                    <th>Date PO</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data_pr as $item_report)
                    <tr>
                      <td>{{ $loop->iteration }}.</td>
                      <td>{{ $item_report->name }}</td>
                      <td>{{ $item_report->pr_title }}</td>
                      <td align="center"><a href="{{ route('print_pr_epurchase_admin',['id'=>$item_report->pr_no]) }}">{{ $item_report->pr_no }} <i class="fas fa-file-download"></i></a> </td>
                      <td>{{ $item_report->pr_date }}</td>
                      <td align="center">
                        @if ($item_report->po_no == "")
                          <b style="color: gray;">Data Empty</b>
                        @else
                          <a href="{{ route('print_po_epurchase_admin',['id'=>$item_report->po_no]) }}">{{ $item_report->po_no }} <i class="fas fa-file-download"></i></a>    
                        @endif
                        
                      </td>
                      <td>{{ $item_report->po_date }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script>
    $(function () {
      $("#tbl_show_pr").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
      });
    });
  </script>