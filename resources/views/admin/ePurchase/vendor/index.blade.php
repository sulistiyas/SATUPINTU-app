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
              <li class="breadcrumb-item active">Vendor Table</li>
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
                            <h3 class="card-title">Vendor Data</h3>
                            <button type="button" class="float-sm-right btn btn-primary" data-toggle="modal" data-target="#modal_vendor">
                                <i class="fas fa-plus">&nbsp;Add New Vendor</i>
                            </button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tbl_vendor" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Vendor</th>
                                        <th>CP</th>
                                        <th>Telepon</th>
                                        <th>E-Mail</th>
                                        <th>Alamat</th>
                                        <th><i class="fas fa-cog"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vendor_data as $item_vendor)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item_vendor->vendor }}</td>
                                            <td>{{ $item_vendor->vendor_cp }}</td>
                                            <td>{{ $item_vendor->telepon }}</td>
                                            <td>{{ $item_vendor->email }}</td>
                                            <td>{{ $item_vendor->alamat }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-flat" data-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-align-justify"></i>
                                                    </button>
                                                    <div class="dropdown-menu" role="menu" style="">
                                                        <form onsubmit="return confirm('Apakah Anda Yakin ingin Menghapus data ?');" action="{{ route('destroy_vendor_admin',[$item_vendor->id_vendor]) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a href="javascript:void(0)" id="show-data" data-url="{{ route('edit_vendor_admin',$item_vendor->id_vendor) }}" class="dropdown-item"><i class="fas fa-pencil-alt"> Update</i></a>
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
    <form action="{{ route('store_vendor_admin') }}" method="POST" enctype="multipart/form-data" id="vendor" name="vendor">
        @csrf
        <div class="modal fade" id="modal_vendor">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Vendor Form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="txt_vendor">Vendor Name</label>
                                <input type="text" id="txt_vendor" name="txt_vendor" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="txt_vendor_cp">Vendor Contact Person</label>
                                <input type="text" id="txt_vendor_cp" name="txt_vendor_cp" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="txt_vendor_phone">Vendor Phone</label>
                                <input type="number" id="txt_vendor_phone" name="txt_vendor_phone" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="txt_vendor_mail">Vendor E-Mail</label>
                                <input type="email" id="txt_vendor_mail" name="txt_vendor_mail" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="txt_vendor_add">Vendor Address</label>
                                <textarea name="txt_vendor_add" id="txt_vendor_add" class="form-control" cols="12" rows="5"></textarea>
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
    {{-- Update Modal --}}
    <form action="{{ route('update_vendor_admin',$item_vendor->id_vendor) }}" method="POST" enctype="multipart/form-data" id="update_vendor_admin" name="update_vendor_admin">
        @csrf
        <div class="modal fade" id="modal-update-vendor">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Client Update Form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="update_txt_vendor">Vendor Name</label>
                                <input type="text" id="update_txt_vendor" name="update_txt_vendor" class="form-control" required>
                                <input type="hidden" name="update_id_vendor" id="update_id_vendor">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="update_txt_vendor_cp">Vendor Contact Person</label>
                                <input type="text" id="update_txt_vendor_cp" name="update_txt_vendor_cp" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="update_txt_vendor_phone">Vendor Phone</label>
                                <input type="number" id="update_txt_vendor_phone" name="update_txt_vendor_phone" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="update_txt_vendor_mail">Vendor E-Mail</label>
                                <input type="email" id="update_txt_vendor_mail" name="update_txt_vendor_mail" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="update_txt_vendor_add">Vendor Address</label>
                                <textarea name="update_txt_vendor_add" id="update_txt_vendor_add" class="form-control" cols="12" rows="5"></textarea>
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
    {{-- End Update --}}
</div>
@include('admin.includes.footer')
<script>
    // Datatables
    $(function () {
      $("#tbl_vendor").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#tbl_vendor_wrapper .col-md-6:eq(0)');
    });
    $(document).ready(function () {
      /* When click show Client */
      $('body').on('click', '#show-data', function () {
          var userURL = $(this).data('url');
          $.get(userURL, function (data) {
              $('#modal-update-vendor').modal('show');
              $('#update_id_vendor').val(data.id_vendor);
              $('#update_txt_vendor').val(data.vendor);
              $('#update_txt_vendor_cp').val(data.vendor_cp);
              $('#update_txt_vendor_phone').val(data.telepon);
              $('#update_txt_vendor_mail').val(data.email);
              $('#update_txt_vendor_add').val(data.alamat);
          })
      });

    });
</script>