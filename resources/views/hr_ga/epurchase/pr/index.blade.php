@include('hr_ga.includes.header')
@include('hr_ga.includes.sidebar')
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
                            <a href="{{ route('create_pr_hr_ga') }}" class="float-sm-right btn btn-primary"><i class="fas fa-plus">&nbsp;Add New Request</i></a>
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
                                          <td>{{ $loop->iteration }}1. </td>
                                          <td>{{ $item_pr->pr_no }}</td>
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
                                            @elseif ( $item_pr->pr_status == 8)
                                              PR Final Check by GA
                                            @endif
                                          </td>
                                          <td>
                                            <div class="btn-group">
                                              @if ($item_pr->pr_status  == 5)
                                                  {{-- <form onsubmit="return confirm('Are you sure you want to APPROVE this request ?');" action="{{ route('approve_pr_hr_ga') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="txt_pr_no" id="txt_pr_no" value="{{ $item_pr->pr_no }}" readonly>
                                                    <button type="submit" name="btn_approval" id="btn_approval" value="approve_pr" class="btn bg-success" title="Approve PR"><i class="far fa-check-circle"></i></button>&nbsp;
                                                  </form>
                                                  <form onsubmit="return confirm('Are you sure you want to REJECT this request ?');" action="{{ route('approve_pr_hr_ga') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="txt_pr_no" id="txt_pr_no" value="{{ $item_pr->pr_no }}" readonly>
                                                    <button type="submit" name="btn_approval" id="btn_approval" value="reject_pr" class="btn bg-danger" title="Reject PR"><i class="far fa-times-circle"></i></button> &nbsp;&nbsp; 
                                                  </form> --}}
                                                  
                                                  <button type="button" class="btn bg-info" title="Show Detail" data-toggle="modal" data-target="#modal_pr_show" id="getPR" data-url="{{ route('show_modal_pr_hr_ga',['id'=>$item_pr->pr_no])}}"><i class="fas fa-eye"></i></button>&nbsp;
                                                  <button class="btn bg-secondary toastrDefaultError" title="Print PR"><i class="fas fa-print"></i></i></button>&nbsp;
                                              @elseif ( $item_pr->pr_status == 4 || $item_pr->pr_status == 3 || $item_pr->pr_status == 2 )
                                                  <button type="button" class="btn bg-info" title="Show Detail" data-toggle="modal" data-target="#modal_pr_show" id="getPR" data-url="{{ route('show_modal_pr_hr_ga',['id'=>$item_pr->pr_no])}}"><i class="fas fa-eye"></i></button>&nbsp;
                                                  <form action="{{ route('print_pr_hr_ga') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="txt_pr_no" id="txt_pr_no" value="{{ $item_pr->pr_no }}">
                                                    <button type="submit" id="print_pr" class="btn bg-secondary" title="Print PR"><i class="fas fa-print"></i></i></button>&nbsp;
                                                  </form>
                                                  
                                              @elseif ( $item_pr->pr_status == 1)
                                                  <button type="button" class="btn bg-info" title="Show Detail" data-toggle="modal" data-target="#modal_pr_show" id="getPR" data-url="{{ route('show_modal_pr_hr_ga',['id'=>$item_pr->pr_no])}}"><i class="far fa-check-circle"></i></button>&nbsp;
                                                  <form action="{{ route('print_pr_hr_ga') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="txt_pr_no" id="txt_pr_no" value="{{ $item_pr->pr_no }}">
                                                    <button type="submit" id="print_pr" class="btn bg-secondary" title="Print PR"><i class="fas fa-print"></i></i></button>&nbsp;
                                                  </form>
                                              @elseif ( $item_pr->pr_status == 8)
                                                  <form onsubmit="return confirm('Are you sure you want to Process this request ?');" action="{{ route('approve_final_pr_hr_ga') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="txt_pr_no" id="txt_pr_no" value="{{ $item_pr->pr_no }}">
                                                    <button type="submit" id="approve_pr" name="btn_approval" value="approve_final_pr" class="btn bg-success" title="Approve PR"><i class="fas fa-check-circle"></i></i></button>&nbsp;
                                                    <button type="button" id="reject-pr" name="btn_approval" value="reject_pr" class="btn bg-danger" title="Reject PR" data-url="{{ route('get_pr_update_hr_ga',['id'=>$item_pr->pr_no]) }}"><i class="fas fa-times-circle"></i></i></button>&nbsp;
                                                  </form>
                                              @else
                                                <button type="button" class="btn bg-info" title="Show Detail" data-toggle="modal" data-target="#modal_pr_show" id="getPR" data-url="{{ route('show_modal_pr_hr_ga',['id'=>$item_pr->pr_no])}}"><i class="fas fa-eye"></i></button>&nbsp;
                                                <button class="btn bg-secondary toastrDefaultError" title="Print PR"><i class="fas fa-print"></i></i></button>&nbsp;
                                              @endif
                                               
                                                  {{-- <div class="dropdown-menu" role="menu" style="">
                                                      <form onsubmit="return confirm('Apakah Anda Yakin ingin Menghapus data ?');" action="{{ route('destroy_pr_hr_ga',[$item_pr->pr_no]) }}" method="POST">
                                                          @csrf
                                                          @method('DELETE')
                                                          
                                                          <a href="javascript:void(0)" id="show-data_update" data-url="{{ route('edit_pr_hr_ga',$item_pr->pr_no) }}" class="dropdown-item"><i class="fas fa-pencil-alt"> Update</i></a>
                                                          <button type="submit" class="dropdown-item"><i class="fas fa-trash-alt"> Delete </i></button>
                                                      </form>
                                                      <button data-toggle="modal" data-target="#modal_pr_show" id="getPR"  type="button" class="dropdown-item" data-url="{{ route('show_modal_pr_hr_ga',['id'=>$item_pr->pr_no])}}">
                                                        <i class="far fa-eye">&nbsp;View</i>
                                                      </button>
                                                  </div> --}}
                                            </div>
                                            {{-- <div class="btn-group">
                                              <button class="btn bg-success" title="Approve PR"><i class="far fa-check-circle"></i></button>&nbsp;
                                              <button class="btn bg-danger" title="Reject PR"><i class="far fa-times-circle"></i></button> &nbsp;&nbsp; 
                                              <button class="btn bg-info" title="Show Detail"><i class="far fa-check-circle"></i></button>&nbsp;
                                              <button class="btn bg-secondary" title="Print PR"><i class="fas fa-print"></i></i></button>&nbsp;
                                            </div> --}}
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
    <form action="{{ route('store_pr_hr_ga') }}" method="POST" enctype="multipart/form-data" id="pr" name="pr">
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
    {{-- @include('components.modals.pr_hr_ga_show',['pr_data' => $item_pr->pr_no]) --}}
    <div class="modal fade" id="modal_pr_show">
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
          <div class="modal-body">
             <div id="dynamic-content"></div>
          </div>
          <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    {{-- End View --}}
    {{-- Update Modal --}}
    <div class="modal fade" id="modal_pr_update">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="overlay" id="modal-loader-2">
            <i class="fas fa-2x fa-sync fa-spin"></i>
          </div>
          <div class="modal-header">
              <h4 class="modal-title">PR Update Form</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
             <div id="dynamic-content-2"></div>
          </div>
          <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    {{-- End Update Modal --}}
    {{-- Reject modal --}}
    <form action="{{ route('reject_final_pr_hr_ga') }}" method="POST" enctype="multipart/form-data" id="pr_reject" name="pr_reject">
        @csrf
        <div class="modal fade" id="modal_pr_reject">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Reject PR Form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="txt_pr_no">PR Number</label>
                        <input type="text" class="form-control" id="app_txt_pr_no" name="app_txt_pr_no" placeholder="Enter PR Number" readonly>
                    </div>
                    <div class="form-group">
                        <label for="txt_pr_reject_reason">Reject Reason</label>
                        <textarea class="form-control" id="txt_pr_reject_reason" name="txt_pr_reject_reason" rows="3" placeholder="Enter Reject Reason"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" name="btn_approval" value="reject_final_pr" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
        </div>
    </form>
</div>
@include('hr_ga.includes.footer')
<!-- SweetAlert2 -->
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Toastr -->
<script src="{{ asset('assets/plugins/toastr/toastr.min.js')}}"></script>
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
<script>
  $(document).ready(function(){
      $(document).on('click', '#updatePR', function(e){
          e.preventDefault();
          var url = $(this).data('url');
          $('#dynamic-content-2').html(''); // leave it blank before ajax call
          $('#modal-loader-2').show();      // load ajax loader
          $.ajax({
              url: url,
              type: 'GET',
              dataType: 'html'
          })
          .done(function(data){
              console.log(data);  
              $('#dynamic-content-2').html('');    
              $('#dynamic-content-2').html(data); // load response 
              $('#modal-loader-2').hide();        // hide ajax loader   
          })
          .fail(function(){
              $('#dynamic-content-2').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
              $('#modal-loader-2').hide();
          });
      });
  });
</script>
<script>
  $(document).ready(function () {
      /* When click show Client */
      $('body').on('click', '#reject-pr', function () {
          var prURL = $(this).data('url');
          $.get(prURL, function (data) {
              $('#modal_pr_reject').modal('show');
              $('#app_txt_pr_no').val(data.pr_no);
          })
      });

    });
</script>
<script>
  $(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    $('.toastrDefaultError').click(function() {
      toastr.error('PR NOT APPROVED by MANAGER or GA.')
    });
  });
</script>
