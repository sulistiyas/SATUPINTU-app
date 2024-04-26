@include('admin.includes.header')
@include('admin.includes.sidebar')
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
              <li class="breadcrumb-item active">Job Number Table</li>
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
                      <h3 class="card-title">Job Number Data</h3>
                      <button type="button" class="float-sm-right btn btn-primary" data-toggle="modal" data-target="#modal_jn">
                        <i class="fas fa-plus">&nbsp;Add Data</i>
                      </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <table id="tbl_jn" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Job Number</th>
                                <th>Contract</th>
                                <th>Company</th>
                                <th>Program</th>
                                <th>PIC</th>
                                <th><i class="fas fa-cog"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jn_data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->job_number }}</td>
                                    <td>{{ $item->contract_no }}</td>
                                    <td>{{ $item->nama_perusahaan }}</td>
                                    <td>{{ $item->program }}</td>
                                    <td>{{ $item->pic }}</td>
                                    <td>
                                        <form onsubmit="return confirm('Apakah Anda Yakin ingin Menghapus data ?');" action="{{ route('destroy_client_admin',[$item->id_jn]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:void(0)" id="show-data" data-url="{{ route('edit_client_admin',$item->id_jn) }}" class="btn btn-warning"><i class="fas fa-pencil-alt"></i></a> |
                                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt	"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Job Number</th>
                                <th>Contract</th>
                                <th>Company</th>
                                <th>Program</th>
                                <th>PIC</th>
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
    <form action="{{ route('store_jn_admin') }}" method="POST" enctype="multipart/form-data" id="jobnumber" name="jobnumber">
        @csrf
        <div class="modal fade" id="modal_jn">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Job Number Form</h4>
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
    {{-- Update Modal --}}
    <form action="{{ route('update_jn_admin',$item->id_jn) }}" method="POST" enctype="multipart/form-data" id="update_jn_form" name="update_jn_form">
        @csrf
        <div class="modal fade" id="modal-update-jn">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Job Number Update Form</h4>
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
    {{-- End Update --}}
  </div>
  
@include('admin.includes.footer')
<script>
    // Datatables
    $(function () {
      $("#tbl_jn").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#tbl_jn_wrapper .col-md-6:eq(0)');
    });
    // Edit Modal
    $(document).ready(function () {
      /* When click show Client */
      $('body').on('click', '#show-data', function () {
          var userURL = $(this).data('url');
          $.get(userURL, function (data) {
              $('#modal-update-jn').modal('show');
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

