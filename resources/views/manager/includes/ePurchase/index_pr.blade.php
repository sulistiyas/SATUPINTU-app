@include('manager.includes.header')
@include('manager.includes.sidebar')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">PR Table</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Purchase Request Data</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tbl_pr" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>PR Number</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th><i class="fas fa-cog"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item_pr)
                                        <tr>
                                          <td>{{ $loop->iteration }}</td>
                                          <td><b>{{ $item_pr->pr_no }}</b></td>
                                          <td>{{ $item_pr->pr_title }}</td>
                                          <td>
                                            @if ( $item_pr->pr_status  == 5)
                                              Waiting Manager Approval
                                            @elseif ( $item_pr->pr_status == 4)
                                              PR Approved
                                            @elseif ( $item_pr->pr_status == 3)
                                              PR Approved - PO Submitting
                                            @elseif ( $item_pr->pr_status == 2)
                                              PR Approved - PO Submitting
                                            @elseif ( $item_pr->pr_status == 1)
                                              PR PO Completed
                                            @elseif ( $item_pr->pr_status == 6)
                                              PR Rejected
                                            @elseif ( $item_pr->pr_status == 7)
                                              PO Rejected
                                            @endif
                                          </td>
                                          <td>
                                            <div class="btn-group">
                                              @if ( $item_pr->pr_status  == 5)
                                              <div class="col-5">
                                                <button type="button" class="btn btn-outline-primary" title="Show Data" data-toggle="modal" data-target="#modal_pr_show_manager" id="getPR" data-url="{{ route('show_modal_pr_manager',['id'=>$item_pr->pr_no])}}"><i class="fas fa-eye">&nbsp;View Data</i></button>
                                              </div>
                                              <div class="col-5">
                                                <form onsubmit="return confirm('Are you sure you want to APPROVE this request ?');" action="{{ route('approve_pr_manager') }}" method="POST">
                                                  @csrf
                                                  <input type="hidden" name="txt_pr_no" id="txt_pr_no" value="{{ $item_pr->pr_no }}" readonly>
                                                  <button type="submit" name="btn_approval" id="btn_approval" value="approve_pr" class="btn btn-outline-success" title="Approve PR"><i class="fas fa-check">&nbsp; Approve</i></button>
                                                </form>
                                              </div>
                                              <div class="col-4">
                                                <form onsubmit="return confirm('Are you sure you want to REJECT this request ?');" action="{{ route('approve_pr_manager') }}" method="POST">
                                                  @csrf
                                                  <input type="hidden" name="txt_pr_no" id="txt_pr_no" value="{{ $item_pr->pr_no }}" readonly>
                                                  <button type="submit" name="btn_approval" id="btn_approval" value="reject_pr" class="btn btn-outline-danger" title="Reject PR"><i class="fas fa-times">&nbsp; Reject</i></button>
                                                </form>
                                              </div>
                                              @elseif ( $item_pr->pr_status  == 4 || $item_pr->pr_status  == 3 || $item_pr->pr_status  == 2 || $item_pr->pr_status  == 1)
                                              <div class="col-7">
                                                <button type="button" class="btn btn-outline-primary" title="Show Data" data-toggle="modal" data-target="#modal_pr_show_manager" id="getPR" data-url="{{ route('show_modal_pr_manager',['id'=>$item_pr->pr_no])}}"><i class="fas fa-eye">&nbsp;View Data</i></button>
                                              </div>
                                              <div class="col-6">
                                                <form action="{{ route('print_pr_manager') }}" method="POST">
                                                  @csrf
                                                  <input type="hidden" name="txt_pr_no" id="txt_pr_no" value="{{ $item_pr->pr_no }}">
                                                  <button type="submit" class="btn btn-outline-success" id="print_pr"><i class="fas fa-print">&nbsp;Print PR</i></button>
                                                </form>
                                              </div>
                                              {{-- @elseif ($item_pr->pr_status  == 2)
                                              <div class="col-7">
                                                <button type="button" class="btn btn-outline-primary" title="Show Data" data-toggle="modal" data-target="#modal_pr_show_manager" id="getPR" data-url="{{ route('show_modal_pr_manager',['id'=>$item_pr->pr_no])}}"><i class="fas fa-eye">&nbsp;View Data</i></button>
                                              </div>
                                              <div class="col-6">
                                                <form action="{{ route('print_pr_manager') }}" method="POST">
                                                  @csrf
                                                  <input type="hidden" name="txt_pr_no" id="txt_pr_no" value="{{ $item_pr->pr_no }}">
                                                  <button type="submit" class="btn btn-outline-success" id="print_pr"><i class="fas fa-print">&nbsp;Print PR</i></button>
                                                </form>
                                              </div> --}}
                                              @endif
                                            </div>
                                          </td>
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
    <!-- /.content -->
    {{-- End Content --}}
    {{-- Create Modal --}}
    <form action="{{ route('store_pr_admin') }}" method="POST" enctype="multipart/form-data" id="pr" name="pr">
        @csrf
        <div class="modal fade" id="modal_pr">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New PR Form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
        </div>
    </form>
    {{-- End Create --}}
    {{-- View Modal --}}
    {{-- @include('components.modals.pr_admin_show',['pr_data' => $item_pr->pr_no]) --}}
    <div class="modal fade" id="modal_pr_show_manager">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="overlay" id="modal-loader">
            <i class="fas fa-2x fa-sync fa-spin"></i>
          </div>
          <div class="modal-header">
              <h4 class="modal-title">PR Detail</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div id="dynamic-content">
          
          </div>
        </div>
      </div>
    </div>
    {{-- End View --}}
</div>
@include('manager.includes.footer')
<script>
    // Datatables
    $(function () {
      $("#tbl_pr").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#tbl_pr_wrapper .col-md-6:eq(0)');
    });
    

</script>
<script>
  $(document).ready(function(){
  
      $(document).on('click', '#getPR', function(e){
  
          e.preventDefault();
  
          var url = $(this).data('url');
  
          $('#dynamic-content').html(''); // leave it blank before ajax call
          $('#modal-loader').show();      // load ajax loader
  
          $.ajax({
              url: url,
              type: 'GET',
              dataType: 'html'
          })
          .done(function(data){
              console.log(data);  
              $('#dynamic-content').html('');    
              $('#dynamic-content').html(data); // load response 
              $('#modal-loader').hide();        // hide ajax loader   
          })
          .fail(function(){
              $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
              $('#modal-loader').hide();
          });
  
      });
  
  });
  
  </script>