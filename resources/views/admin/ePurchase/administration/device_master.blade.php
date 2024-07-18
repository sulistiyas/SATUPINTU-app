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
                <li class="breadcrumb-item"><a href="{{ route('index_office_asset') }}">Office Asset</a></li>
                <li class="breadcrumb-item active">Device Master</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Device Master Data</h3>
                            <button type="button" class="float-sm-right btn btn-primary" data-toggle="modal" data-target="#modal_device_master">
                                <i class="fas fa-plus">&nbsp;Add Data</i>
                            </button>
                        </div>
                         <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tbl_device_master" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Device Name</th>
                                        <th><i class="fas fa-cog"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($device_master as $item_device)
                                        <tr>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>{{ $item_device->device_name }}</td>
                                            <td>
                                                {{--  --}}
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
    {{-- Create Modal --}}
    <form action="{{ route('store_device_master') }}" method="POST" enctype="multipart/form-data" id="device_master" name="device_master">
        @csrf
        <div class="modal fade" id="modal_device_master">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Device Form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-10">
                            <div class="form-group">
                                <label for="txt_device_name">Device Name</label>
                                <input type="text" name="txt_device_name" id="txt_device_name" class="form-control" placeholder="Device Name" required >
                            </div>
                        </div>
                    </div>
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
</div>
@include('admin.includes.footer')
<script>
    // Datatables
    $(function () {
      $("#tbl_device_master").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#tbl_device_master_wrapper .col-md-6:eq(0)');
    });
</script>