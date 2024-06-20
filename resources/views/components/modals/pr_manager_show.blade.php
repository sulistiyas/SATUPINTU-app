<div class="modal-body">
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
          <tr>
            <th>Status </th>
            <td>:</td>
            <th>
              @if ( $item_single->pr_status  == 5)
                Waiting Manager Approval
              @elseif ( $item_single->pr_status == 4)
                PR Approved
              @elseif ( $item_single->pr_status == 3)
                PR Approved - PO Submitting
              @elseif ( $item_single->pr_status == 2)
                PR Approved - PO Submitting
              @elseif ( $item_single->pr_status == 1)
                PR PO Completed
              @elseif ( $item_single->pr_status == 6)
                PR Rejected
              @elseif ( $item_single->pr_status == 7)
                PO Rejected
              @endif
            </th>
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
        $("#tbl_show_pr").DataTable({
          "responsive": true, "lengthChange": false, "autoWidth": false,
        });
      });
    </script>
</div>
<div class="modal-footer justify-content-between">
    @if ( $item_single->pr_status  == 4)
        <div class="row">
            <form onsubmit="return confirm('Are you sure you want to APPROVE this request ?');" action="{{ route('approve_pr_manager') }}" method="POST">
                @csrf
                    <div class="col-12">
                        <input type="hidden" name="txt_pr_no" id="txt_pr_no" value="{{ $item_single->pr_no }}" readonly>
                        <button type="submit" name="btn_approval" id="btn_approval" value="approve_pr" class="btn btn-block btn-outline-success"><i class="fas fa-check">&nbsp;Approve</i></button>
                    </div>
                </div>
            </form>
            <form onsubmit="return confirm('Are you sure you want to REJECT this request ?');" action="{{ route('approve_pr_manager') }}" method="POST">
                @csrf
                    <div class="col-12">
                        <input type="hidden" name="txt_pr_no" id="txt_pr_no" value="{{ $item_single->pr_no }}" readonly>
                        <button type="submit" name="btn_approval" id="btn_approval" value="reject_pr" class="btn btn-block btn-outline-danger"><i class="fas fa-times">&nbsp;Reject</i></button>
                    </div>
            </form>
        </div>
    @else
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    @endif    
</div>