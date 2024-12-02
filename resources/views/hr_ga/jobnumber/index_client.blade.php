@include('hr_ga.includes.header')
@include('hr_ga.includes.sidebar')
  <!-- Content Wrapper. Contains page content -->
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
              <li class="breadcrumb-item active">Client Table</li>
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
                      <h3 class="card-title">Client's Data</h3>
                      <button type="button" class="float-sm-right btn btn-primary" data-toggle="modal" data-target="#modal_client">
                        <i class="fas fa-plus">&nbsp;Add Data</i>
                      </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <table id="tbl_client" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Company</th>
                                <th>Address</th>
                                <th>NPWP</th>
                                <th>NPWP Address</th>
                                <th><i class="fas fa-cog"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($client_data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_perusahaan }}</td>
                                    <td>{{ $item->almt_perusahaan }}</td>
                                    <td>{{ $item->npwp }}</td>
                                    <td>{{ $item->almt_npwp }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-flat" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-align-justify"></i>
                                            </button>
                                            <div class="dropdown-menu" role="menu" style="">
                                                <form onsubmit="return confirm('Apakah Anda Yakin ingin Menghapus data ?');" action="{{ route('destroy_client_admin',[$item->id_client]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="javascript:void(0)" id="show-data" data-url="{{ route('edit_client_admin',$item->id_client) }}" class="dropdown-item"><i class="fas fa-pencil-alt"> Update</i></a>
                                                    <button type="submit" class="dropdown-item"><i class="fas fa-trash-alt"> Delete </i></button>
                                                </form>
                                            </div>
                                        </div>
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Company</th>
                                <th>Address</th>
                                <th>NPWP</th>
                                <th>NPWP Address</th>
                                <th><i class="fas fa-cog"></i></th>
                            </tr>
                        </tfoot>
                      </table>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
            </div>
          </div>
        </div>
    </section>   
    <!-- /.content -->
    {{-- End Content --}}
    {{-- Create Modal --}}
    <form action="{{ route('store_client_admin') }}" method="POST" enctype="multipart/form-data" id="client" name="client">
        @csrf
        <div class="modal fade" id="modal_client">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Client Form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="txt_comp_name">Company Name</label>
                                <input type="text" name="txt_comp_name" id="txt_comp_name" class="form-control" placeholder="Company Name" required >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="txt_comp_add">Company Address</label>
                                <input type="text" name="txt_comp_add" id="txt_comp_add" class="form-control" placeholder="Company Address" required >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="txt_comp_npwp">NPWP</label>
                                <input type="number" name="txt_comp_npwp" id="txt_comp_npwp" class="form-control" placeholder="NPWP" >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="txt_comp_npwp_add">NPWP Address</label>
                                <input type="text" name="txt_comp_npwp_add" id="txt_comp_npwp_add" class="form-control" placeholder="NPWP Address" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="txt_comp_kota">Kota</label>
                                <input type="text" name="txt_comp_kota" id="txt_comp_kota" class="form-control" placeholder="Kota" required >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="txt_comp_kode_pos">Kode Pos</label>
                                <input type="number" name="txt_comp_kode_pos" id="txt_comp_kode_pos" class="form-control" placeholder="Kode Pos">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="txt_comp_name_up">Nama UP</label>
                                <input type="text" name="txt_comp_name_up" id="txt_comp_name_up" class="form-control" placeholder="Nama UP" required >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="txt_jbt_comp_up">Jabatan UP</label>
                                <input type="text" name="txt_jbt_comp_up" id="txt_jbt_comp_up" class="form-control" placeholder="Jabatan UP">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="txt_phone_comp">Phone</label>
                                <input type="number" name="txt_phone_comp" id="txt_phone_comp" class="form-control" placeholder="Phone" required >
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
    <form action="{{ route('update_client_admin',$item->id_client) }}" method="POST" enctype="multipart/form-data" id="update_client_form" name="update_client_form">
        @csrf
        <div class="modal fade" id="modal-update-client">
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
                                <input type="hidden" name="txt_client_id" id="txt_client_id">
                                <label for="update_txt_comp_name">Company Name</label>
                                <input type="text" name="update_txt_comp_name" id="update_txt_comp_name" class="form-control" placeholder="Company Name" required >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="update_txt_comp_add">Company Address</label>
                                <input type="text" name="update_txt_comp_add" id="update_txt_comp_add" class="form-control" placeholder="Company Address" required >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="update_txt_comp_npwp">NPWP</label>
                                <input type="number" name="update_txt_comp_npwp" id="update_txt_comp_npwp" class="form-control" placeholder="NPWP" >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="update_txt_comp_npwp_add">NPWP Address</label>
                                <input type="text" name="update_txt_comp_npwp_add" id="update_txt_comp_npwp_add" class="form-control" placeholder="NPWP Address" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="update_txt_comp_kota">Kota</label>
                                <input type="text" name="update_txt_comp_kota" id="update_txt_comp_kota" class="form-control" placeholder="Kota" required >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="update_txt_comp_kode_pos">Kode Pos</label>
                                <input type="number" name="update_txt_comp_kode_pos" id="update_txt_comp_kode_pos" class="form-control" placeholder="Kode Pos">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="update_txt_comp_name_up">Nama UP</label>
                                <input type="text" name="update_txt_comp_name_up" id="update_txt_comp_name_up" class="form-control" placeholder="Nama UP" required >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="update_txt_jbt_comp_up">Jabatan UP</label>
                                <input type="text" name="update_txt_jbt_comp_up" id="update_txt_jbt_comp_up" class="form-control" placeholder="Jabatan UP">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="update_txt_phone_comp">Phone</label>
                                <input type="number" name="update_txt_phone_comp" id="update_txt_phone_comp" class="form-control" placeholder="Phone" required >
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
  
  @include('hr_ga.includes.footer')
<script>
    // Datatables
    $(function () {
      $("#tbl_client").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#tbl_client_wrapper .col-md-6:eq(0)');
    });
    // Edit Modal
    $(document).ready(function () {
      /* When click show Client */
      $('body').on('click', '#show-data', function () {
          var userURL = $(this).data('url');
          $.get(userURL, function (data) {
              $('#modal-update-client').modal('show');
              $('#txt_client_id').val(data.id_client);
              $('#update_txt_comp_name').val(data.nama_perusahaan);
              $('#update_txt_comp_add').val(data.almt_perusahaan);
              $('#update_txt_comp_npwp').val(data.npwp);
              $('#update_txt_comp_npwp_add').val(data.almt_npwp);
              $('#update_txt_comp_kota').val(data.kota);
              $('#update_txt_comp_kode_pos').val(data.kodepos);
              $('#update_txt_comp_name_up').val(data.nama_up);
              $('#update_txt_jbt_comp_up').val(data.jabatan_up);
              $('#update_txt_phone_comp').val(data.phone);
              
          })
      });

    });
</script>

