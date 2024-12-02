@include('admin.includes.header')
@include('admin.includes.sidebar')
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
                            <a href="{{ route('create_pr_admin') }}" class="float-sm-right btn btn-primary"><i class="fas fa-plus">&nbsp;Add New Request</i></a>
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
                                            @endif
                                          </td>
                                          <td>
                                            <div class="btn-group">
                                              @if ($item_pr->pr_status  == 5)
                                                  <div class="btn-group">
                                                    <button type="button" class="btn btn-flat" data-toggle="dropdown">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" role="menu">
                                                        <button type="button" class="dropdown-item" title="Show Data" data-toggle="modal" data-target="#modal_pr_show" id="getPR" data-url="{{ route('show_modal_pr_admin',['id'=>$item_pr->pr_no])}}">
                                                            View Data
                                                        </button>
                                                    <div class="dropdown-divider"></div>
                                                      {{-- <a class="dropdown-item" href=""></a> --}}
                                                      <button class="dropdown-item toastrDefaultError" >Print</button>
                                                    </div>
                                                  </div>
                                              @elseif ( $item_pr->pr_status == 4 || $item_pr->pr_status == 3 || $item_pr->pr_status == 2 )
                                                  <div class="btn-group">
                                                    <button type="button" class="btn btn-flat" data-toggle="dropdown">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" role="menu">
                                                        <button type="button" class="dropdown-item" title="Show Data" data-toggle="modal" data-target="#modal_pr_show" id="getPR" data-url="{{ route('show_modal_pr_admin',['id'=>$item_pr->pr_no])}}">
                                                            View Data
                                                        </button>
                                                    <div class="dropdown-divider"></div>
                                                        <form action="{{ route('print_pr_admin') }}" method="POST">
                                                          @csrf
                                                          <input type="hidden" name="txt_pr_no" id="txt_pr_no" value="{{ $item_pr->pr_no }}">
                                                          <button type="submit" class="dropdown-item" id="print_pr">Print PR</button>
                                                        </form>
                                                    </div>
                                                  </div>
                                              @elseif ( $item_pr->pr_status == 1)
                                                  <div class="btn-group">
                                                    <button type="button" class="btn btn-flat" data-toggle="dropdown">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" role="menu">
                                                        <button type="button" class="dropdown-item" title="Show Data" data-toggle="modal" data-target="#modal_pr_show" id="getPR" data-url="{{ route('show_modal_pr_admin',['id'=>$item_pr->pr_no])}}">
                                                            View Data
                                                        </button>
                                                    <div class="dropdown-divider"></div>
                                                        <form action="{{ route('print_pr_admin') }}" method="POST">
                                                          @csrf
                                                          <input type="hidden" name="txt_pr_no" id="txt_pr_no" value="{{ $item_pr->pr_no }}">
                                                          <button type="submit" class="dropdown-item" id="print_pr">Print PR</button>
                                                        </form>
                                                        <button type="button" class="btn btn-outline-success" title="Show Data" data-toggle="modal" data-target="#modal_pr_show_manager" id="getPR" data-url="{{ route('show_modal_pr_admin',['id'=>$item_pr->pr_no])}}">
                                                          Print PO
                                                        </button>
                                                    </div>
                                                  </div>
                                              @endif
                                                  <div class="dropdown-menu" role="menu" style="">
                                                      <form onsubmit="return confirm('Apakah Anda Yakin ingin Menghapus data ?');" action="{{ route('destroy_pr_admin',[$item_pr->pr_no]) }}" method="POST">
                                                          @csrf
                                                          @method('DELETE')
                                                          
                                                          <a href="javascript:void(0)" id="show-data_update" data-url="{{ route('edit_pr_admin',$item_pr->pr_no) }}" class="dropdown-item"><i class="fas fa-pencil-alt"> Update</i></a>
                                                          <button type="submit" class="dropdown-item"><i class="fas fa-trash-alt"> Delete </i></button>
                                                      </form>
                                                      <button data-toggle="modal" data-target="#modal_pr_show" id="getPR"  type="button" class="dropdown-item" data-url="{{ route('show_modal_pr_admin',['id'=>$item_pr->pr_no])}}">
                                                        <i class="far fa-eye">&nbsp;View</i>
                                                      </button>
                                                  </div>
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
</div>
@include('admin.includes.footer')
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
