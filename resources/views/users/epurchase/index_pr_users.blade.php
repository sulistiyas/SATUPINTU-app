@include('users.includes.header')
@include('users.includes.sidebar')
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
                            <a href="{{ route('create_pr_users') }}" class="float-sm-right btn btn-primary"><i class="fas fa-plus">&nbsp;Add New Request</i></a>
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
                                              PR Approved - PO Submitting by GA
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
                                            @elseif ( $item_pr->pr_status == 9)
                                              PO Submitting by GA
                                            @endif
                                          </td>
                                          <td>
                                            <div class="btn-group">
                                              @if ($item_pr->pr_status  == 5)
                                                <div class="col-md-12">
                                                  <button type="button" class="btn bg-info" title="Show Detail" data-toggle="modal" data-target="#modal_pr_show" id="getPR" data-url="{{ route('show_modal_pr_users',['id'=>$item_pr->pr_no])}}"><i class="far fa-eye"></i></button>&nbsp;
                                                  <button type="button" class="btn bg-warning" title="Edit Data" data-toggle="modal" data-target="#modal_pr_edit" id="editPR" data-url="{{ route('show_modal_pr_users_edit',['id'=>$item_pr->pr_no])}}"><i class="fas fa-pen"></i></button>&nbsp;
                                                  <button type="button" class="btn bg-primary" title="Add Data" data-toggle="modal" data-target="#modal_pr_add" id="addPR" data-url="{{ route('show_modal_pr_users_add',['id'=>$item_pr->pr_no])}}"><i class="fas fa-plus"></i></button>&nbsp;
                                                  {{-- <button class="btn bg-secondary toastrDefaultError" title="Print PR"><i class="fas fa-print"></i></i></button>&nbsp; --}}
                                                </div>
                                              @elseif ( $item_pr->pr_status == 4 )
                                                <div class="col-md-5">
                                                    <button type="button" class="btn bg-info" title="Show Detail" data-toggle="modal" data-target="#modal_pr_show" id="getPR" data-url="{{ route('show_modal_pr_users',['id'=>$item_pr->pr_no])}}"><i class="far fa-eye"></i></button>&nbsp;
                                                </div>
                                                <div class="col-md-4">
                                                    <form action="{{ route('print_pr_users') }}" method="POST">
                                                      @csrf
                                                      <input type="hidden" name="txt_pr_no" id="txt_pr_no" value="{{ $item_pr->pr_no }}">
                                                      <button type="submit" class="btn bg-secondary" id="print_pr" title="Print PR"><i class="fas fa-print"></i></i></button>&nbsp;
                                                    </form>
                                                </div>
                                              @elseif ( $item_pr->pr_status == 3 )
                                                  <div class="col-md-6">
                                                    <button type="button" class="btn bg-info" title="Show Detail" data-toggle="modal" data-target="#modal_po_show_po" id="getPO" data-url="{{ route('show_modal_po_pirce_users',['id'=>$item_pr->po_no])}}"><i class="far fa-eye"></i></button>&nbsp;
                                                  </div>
                                                  <div class="col-md-6">
                                                    <form action="{{ route('print_pr_users') }}" method="POST">
                                                      @csrf
                                                      <input type="hidden" name="txt_pr_no" id="txt_pr_no" value="{{ $item_pr->pr_no }}">
                                                      <button type="submit" class="btn bg-secondary" id="print_pr" title="Print PR"><i class="fas fa-print"></i></i></button>&nbsp;
                                                    </form>
                                                  </div>
                                              @elseif ( $item_pr->pr_status == 2 )
                                                  <div class="col-md-12">
                                                    <button type="button" class="btn bg-info" title="Show Detail" data-toggle="modal" data-target="#modal_po_show_po" id="getPO" data-url="{{ route('show_modal_po_pirce_users',['id'=>$item_pr->po_no])}}"><i class="far fa-eye"></i></button>&nbsp;
                                                    <button class="btn bg-secondary toastrDefaultError2" title="Print PO"><i class="fas fa-print"></i></i></button>&nbsp;
                                                  </div>
                                              @elseif ( $item_pr->pr_status == 1)
                                                  <div class="col-md-5">
                                                    <button type="button" class="btn bg-info" title="Show Detail" data-toggle="modal" data-target="#modal_po_show_po" id="getPO" data-url="{{ route('show_modal_po_pirce_users',['id'=>$item_pr->po_no])}}"><i class="far fa-eye"></i></button>&nbsp;
                                                  </div>
                                                  <div class="col-md-4">
                                                    <form action="{{ route('print_po_users') }}" method="POST">
                                                      @csrf
                                                      <input type="hidden" name="txt_po_no" id="txt_po_no" value="{{ $item_pr->po_no }}">
                                                      <button type="submit" class="btn bg-secondary" title="Print PO"><i class="fas fa-print"></i></i></button>&nbsp;
                                                    </form>
                                                  </div>
                                              @else
                                                <div class="dropdown-menu" role="menu" style="">
                                                  <button data-toggle="modal" data-target="#modal_pr_show" id="getPR"  type="button" class="dropdown-item" data-url="{{ route('show_modal_pr_users',['id'=>$item_pr->pr_no])}}">
                                                    <i class="far fa-eye">&nbsp;View</i>
                                                  </button>
                                                </div>
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
    {{-- Modal PR Edit --}}
    <div class="modal fade" id="modal_pr_edit">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form action="{{ route('update_pr_users') }}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="overlay" id="modal-loader-2">
              <i class="fas fa-2x fa-sync fa-spin"></i>
            </div>
            <div class="modal-header">
                <h4 class="modal-title">PR Update Forms</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <div id="dynamic-content-2"></div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" value="Submit" name="submit_update_pr" class="btn btn-primary">
            </div>
          </form>
        </div>
      </div>
    </div>
    {{-- Modal PR Edit End --}}
    {{-- Modal PR Edit ADD --}}
    <div class="modal fade" id="modal_pr_add">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form action="{{ route('update_item_pr_users') }}" method="POST">
            @csrf
            <div class="overlay" id="modal-loader-3">
              <i class="fas fa-2x fa-sync fa-spin"></i>
            </div>
            <div class="modal-header">
                <h4 class="modal-title">PR Update Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <div id="dynamic-content-3">
              </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" value="Submit" name="submit_update_add_pr" class="btn btn-primary">
            </div>
          </form>
        </div>
      </div>
    </div>
    {{-- Modal PR Edit End --}}
    {{-- Modal Show PO --}}
    <div class="modal fade" id="modal_po_show_po">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="overlay" id="modal-loader_4">
            <i class="fas fa-2x fa-sync fa-spin"></i>
          </div>
          <div class="modal-header">
              <h4 class="modal-title">PO Detail</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
             <div id="dynamic-content_4"></div>
             
          </div>
          <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
</div>
@include('users.includes.footer')
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
    $('.toastrDefaultError2').click(function() {
      toastr.error('PO NOT APPROVED by MANAGER.')
    });
  });
</script>
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
  
      $(document).on('click', '#editPR', function(e){
  
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
  $(document).ready(function(){
  
      $(document).on('click', '#addPR', function(e){
  
          e.preventDefault();
  
          var url = $(this).data('url');
  
          $('#dynamic-content-3').html(''); // leave it blank before ajax call
          $('#modal-loader-3').show();      // load ajax loader
  
          $.ajax({
              url: url,
              type: 'GET',
              dataType: 'html'
          })
          .done(function(data){
              console.log(data);  
              $('#dynamic-content-3').html('');    
              $('#dynamic-content-3').html(data); // load response 
              $('#modal-loader-3').hide();        // hide ajax loader   
          })
          .fail(function(){
              $('#dynamic-content-3').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
              $('#modal-loader-3').hide();
          });
  
      });
  
  });
  
</script>
<script>
  $(document).ready(function(){

      $(document).on('click', '#getPO', function(e){
  
          e.preventDefault();
  
          var url = $(this).data('url');
  
          $('#dynamic-content_4').html(''); // leave it blank before ajax call
          $('#modal-loader_4').show();      // load ajax loader
  
          $.ajax({
              url: url,
              type: 'GET',
              dataType: 'html'
          })
          .done(function(data){
              console.log(data);  
              $('#dynamic-content_4').html('');    
              $('#dynamic-content_4').html(data); // load response 
              $('#modal-loader_4').hide();        // hide ajax loader   
          })
          .fail(function(){
              $('#dynamic-content_4').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
              $('#modal-loader_4').hide();
          });
  
      });

  });
</script>