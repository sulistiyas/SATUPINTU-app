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
                            {{-- <button type="button" class="float-sm-right btn btn-primary" data-toggle="modal" data-target="#modal_pr">
                                <i class="fas fa-plus">&nbsp;Add New Request</i>
                            </button> --}}
                            <a href="{{ route('create_pr_admin') }}" class="float-sm-right btn btn-primary"><i class="fas fa-plus">&nbsp;Add New Request</i></a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tbl_pr" class="table table-bordered table-striped">
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
                                            @if ( $item_pr->pr_status  == 3)
                                              Waiting Manager Approval
                                            @elseif ( $item_pr->pr_status == 2)
                                              PR Approved - PO Submitting
                                            @elseif ( $item_pr->pr_status == 1)
                                              PR Completed
                                            @elseif ( $item_pr->pr_status == 4)
                                              PR Declined
                                            @endif
                                          </td>
                                          <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-flat" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-align-justify"></i>
                                                </button>
                                                <div class="dropdown-menu" role="menu" style="">
                                                    <form onsubmit="return confirm('Apakah Anda Yakin ingin Menghapus data ?');" action="{{ route('destroy_pr_admin',[$item_pr->id_pr]) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="javascript:void(0)" id="show-data" data-url="{{ route('show_pr_admin',$item_pr->id_pr) }}" class="dropdown-item"><i class="far fa-eye"> View</i></a>
                                                        <a href="javascript:void(0)" id="show-data_update" data-url="{{ route('edit_pr_admin',$item_pr->id_pr) }}" class="dropdown-item"><i class="fas fa-pencil-alt"> Update</i></a>
                                                        <button type="submit" class="dropdown-item"><i class="fas fa-trash-alt"> Delete </i></button>
                                                    </form>
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
        <div class="modal fade" id="modal_pr">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">PR Detail</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
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
      $("#tbl_pr").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#tbl_pr_wrapper .col-md-6:eq(0)');
    });
</script>