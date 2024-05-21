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
              <li class="breadcrumb-item active">PO Table</li>
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
                            <h3 class="card-title">Purchase Order Data</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tbl_po" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>PR Number</th>
                                        <th>Status</th>
                                        <th><i class="fas fa-cog"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item_pr)
                                        <tr>
                                          <td>{{ $loop->iteration }}</td>
                                          <td>{{ $item_pr->pr_no }}</td>
                                          <td>
                                            @if ( $item_pr->pr_status  == 4)
                                              Waiting Manager Approval
                                            @elseif ( $item_pr->pr_status == 3)
                                              PR Approved
                                            @elseif ( $item_pr->pr_status == 2)
                                              PO Submitting
                                            @elseif ( $item_pr->pr_status == 1)
                                              PR PO Completed
                                            @elseif ( $item_pr->pr_status == 5)
                                              PR Rejected
                                            @elseif ( $item_pr->pr_status == 6)
                                              PO Rejected
                                            @endif
                                          </td>
                                          <td>
                                            <div class="btn-group">
                                                <div class="col-md-7">
                                                    <button type="button" class="btn btn-block btn-outline-primary" title="Show Data" data-toggle="modal" data-target="#modal_pr_show_manager" id="getPR" data-url="{{ route('show_modal_pr_admin',['id'=>$item_pr->pr_no])}}"><i class="fas fa-eye">&nbsp;View Data</i></button>
                                                </div>
                                                <div class="col-md-8">
                                                    <button type="button" class="btn btn-block btn-outline-success" title="Add Price" data-toggle="modal" data-target="#modal_price_add" id="getPrice" data-url="{{ route('show_modal_price_admin',['id'=>$item_pr->pr_no])}}"><i class="fas fa-plus">&nbsp;Add Price</i></button>
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
    <form action="{{ route('store_price_admin') }}" method="POST" enctype="multipart/form-data" id="pr" name="pr">
        @csrf
        <div class="modal fade" id="modal_price_add">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="overlay" id="modal-loader_2">
                  <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
                <div class="modal-header">
                    <h4 class="modal-title">PR Detail</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   <div id="dynamic-content_2"></div>
                </div>
                <div class="modal-footer justify-content-between">
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-warning" data-dismiss="modal">Close</button>&nbsp;
                        <button type="submit" class="btn btn-outline-primary">Submit</button>
                    </div>
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
</div>
@include('admin.includes.footer')
<script>
    // Datatables
    $(function () {
      $("#tbl_po").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#tbl_po_wrapper .col-md-6:eq(0)');
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
{{-- Price --}}
<script>
    $(document).ready(function(){
  
        $(document).on('click', '#getPrice', function(e){
    
            e.preventDefault();
    
            var url = $(this).data('url');
    
            $('#dynamic-content_2').html(''); // leave it blank before ajax call
            $('#modal-loader_2').show();      // load ajax loader
    
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'html'
            })
            .done(function(data){
                console.log(data);  
                $('#dynamic-content_2').html('');    
                $('#dynamic-content_2').html(data); // load response 
                $('#modal-loader_2').hide();        // hide ajax loader   
            })
            .fail(function(){
                $('#dynamic-content_2').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                $('#modal-loader_2').hide();
            });
    
        });
  
    });
</script>