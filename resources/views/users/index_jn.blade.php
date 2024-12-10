@include('users.includes.header')
@include('users.includes.sidebar')
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
                                      <div class="btn-group">
                                        <button type="button" class="btn bg-primary" title="Show Detail" data-toggle="modal" data-target="#modal-show-jn" id="show-data-pr" data-url="{{ route('show_jn_users',$item->id_jn) }}"><i class="far fa-eye"></i></button>&nbsp;
                                        {{-- <button type="button" class="btn btn-default btn-flat" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-align-justify"></i>
                                        </button>
                                        <div class="dropdown-menu" role="menu" style="">
                                          <form onsubmit="return confirm('Apakah Anda Yakin ingin Menghapus data ?');" action="{{ route('destroy_jn_users',[$item->id_jn]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:void(0)" id="show-data" data-url="{{ route('show_jn_users',$item->id_jn) }}" class="dropdown-item"><i class="fas fa-pencil-alt"> Edit</i></a>
                                            <button type="submit" class="dropdown-item"><i class="fas fa-trash-alt"> Delete</i>  </button>
                                          </form>
                                        </div> --}}
                                      </div>
                                        
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
    <form action="{{ route('store_jn_users') }}" method="POST" enctype="multipart/form-data" id="jobnumber" name="jobnumber">
        @csrf
        <div class="modal fade" id="modal_jn">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Job Number Form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    @foreach ($latest_jn as $late_jn)
                    <div class="col-5">
                      <div class="form-group">
                        <label for="txt_old_jn">Last Job Number</label>
                        <input type="text" class="form-control" name="txt_old_jn" id="txt_old_jn"  readonly>
                      </div>
                    </div>
                    <div class="col-1">
                      <div class="form-group">
                        <label for="btn_refresh_jn" style="color: white">Refresh</label>
                        <a href="javascript:void(0)" id="btn_refresh_jn" name="btn_refresh_jn" class="btn btn-warning form-control" data-url="{{ route('refresh_jn_users') }}">
                          <i class="fas fa-sync-alt"></i>
                        </a>
                      </div>
                    </div>
                    @endforeach
                    <div class="col-5">
                      <div class="form-group">
                        <label for="txt_jn">New Job Number</label>
                        <input type="text" name="txt_jn" id="txt_jn" class="form-control" required placeholder="New Job Number Here">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-3">
                      <div class="form-group">
                        <label for="txt_contract">No. Contract</label>
                        <input type="text" id="txt_contract" name="txt_contract" class="form-control">
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-group">
                        <label for="txt_amount">Amount</label>
                        <input type="number" id="txt_amount" name="txt_amount" class="form-control">
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-group">
                        <label for="txt_comp">Company</label>
                        <select name="txt_comp" id="txt_comp" class="form-control select2bs4" required>
                          <option value="3">- Select Company -</option>
                          @foreach ($data_client as $item)
                              <option value="{{ $item->id_client }}">{{ $item->nama_perusahaan }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-group">
                        <label for="txt_program_name">Program</label>
                        <input type="text" id="txt_program_name" name="txt_program_name" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-3">
                      <div class="form-group">
                        <label for="txt_cp">Contact Person</label>
                        <input type="text" id="txt_cp" name="txt_cp" class="form-control">
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-group">
                        <label for="txt_hours">Hours</label>
                        <input type="number" id="txt_hours" name="txt_hours" class="form-control">
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-group">
                        <label for="txt_pic">PIC</label>
                        <input type="text" id="txt_pic" name="txt_pic" class="form-control">
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-group">
                        <label for="txt_instructor">Instructor</label>
                        <input type="text" id="txt_instructor" name="txt_instructor" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-3">
                      <div class="form-group">
                        <label for="txt_day_start">Day Training ( Start )</label>
                        <select name="txt_day_start" id="txt_day_start" class="form-control select2bs4">
                          <option value="Monday">Monday</option>
                          <option value="Tuesday">Tuesday</option>
                          <option value="Wednesday">Wednesday</option>
                          <option value="Thursday">Thursday</option>
                          <option value="Friday">Friday</option>
                          <option value="Saturday">Saturday</option>
                          <option value="Sunday">Sunday</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-group">
                        <label for="txt_day_end">Day Training ( End )</label>
                        <select name="txt_day_end" id="txt_day_end" class="form-control select2bs4">
                          <option value="Monday">Monday</option>
                          <option value="Tuesday">Tuesday</option>
                          <option value="Wednesday">Wednesday</option>
                          <option value="Thursday">Thursday</option>
                          <option value="Friday">Friday</option>
                          <option value="Saturday">Saturday</option>
                          <option value="Sunday">Sunday</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-group">
                        <label for="txt_start_date">Start Date</label>
                        <input type="date" name="txt_start_date" id="txt_start_date" class="form-control" required>
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-group">
                        <label for="txt_end_date">End Date</label>
                        <input type="date" name="txt_end_date" id="txt_end_date" class="form-control" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="txt_teacher_comp">Teacher Composition</label>
                        <input type="text" name="txt_teacher_comp" id="txt_teacher_comp" class="form-control">
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="txt_total_day">Total Days</label>
                        <input type="text" name="txt_total_day" id="txt_total_day" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <label for="txt_remarks"> Remarks </label>
                      <textarea name="txt_remarks" id="txt_remarks" cols="15" rows="5" class="form-control"></textarea>
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
    <form action="{{ route('update_jn_users',1) }}" method="POST" enctype="multipart/form-data" id="update_jn_form" name="update_jn_form">
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
    {{-- Show Modal --}}
    <div class="modal fade" id="modal-show-jn">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">JobNumber : </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="show_txt_old_jn">JobNumber</label>
                    <input type="text" name="show_txt_old_jn" id="show_txt_old_jn" class="form-control" readonly>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-3">
                  <div class="form-group">
                    <label for="show_txt_contract">No. Contract</label>
                    <input type="text" id="show_txt_contract" name="show_txt_contract" class="form-control" @readonly(true)>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label for="show_txt_amount">Amount</label>
                    <input type="number" id="show_txt_amount" name="show_txt_amount" class="form-control" @readonly(true)>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label for="show_txt_comp">Company</label>
                      <input type="text" name="show_txt_comp" id="show_txt_comp" class="form-control" @readonly(true)>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label for="show_txt_program_name">Program</label>
                    <input type="text" id="show_txt_program_name" name="show_txt_program_name" class="form-control" @readonly(true)>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-3">
                  <div class="form-group">
                    <label for="show_txt_cp">Contact Person</label>
                    <input type="text" id="show_txt_cp" name="show_txt_cp" class="form-control" @readonly(true)>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label for="show_txt_hours">Hours</label>
                    <input type="number" id="show_txt_hours" name="show_txt_hours" class="form-control" @readonly(true)>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label for="show_txt_pic">PIC</label>
                    <input type="text" id="show_txt_pic" name="show_txt_pic" class="form-control" @readonly(true)>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label for="show_txt_instructor">Instructor</label>
                    <input type="text" id="show_txt_instructor" name="show_txt_instructor" class="form-control" @readonly(true)>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-3">
                  <div class="form-group">
                    <label for="show_txt_day_start">Day Training ( Start )</label>
                    <input type="text" name="show_txt_day_start" id="show_txt_day_start" class="form-control" @readonly(true)>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label for="show_txt_day_end">Day Training ( End )</label>
                    <input type="text" name="show_txt_day_end" id="show_txt_day_end" class="form-control" @readonly(true)>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label for="show_txt_start_date">Start Date</label>
                    <input type="text" name="show_txt_start_date" id="show_txt_start_date" class="form-control"  @readonly(true)>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label for="show_txt_end_date">End Date</label>
                    <input type="text" name="show_txt_end_date" id="show_txt_end_date" class="form-control"  @readonly(true)>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="show_txt_teacher_comp">Teacher Composition</label>
                    <input type="text" name="show_txt_teacher_comp" id="show_txt_teacher_comp" class="form-control" @readonly(true)>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="show_txt_total_day">Total Days</label>
                    <input type="text" name="show_txt_total_day" id="show_txt_total_day" class="form-control" @readonly(true)>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <label for="show_txt_remarks"> Remarks </label>
                  <textarea name="show_txt_remarks" id="show_txt_remarks" cols="15" rows="5" class="form-control" @readonly(true)></textarea>
                </div>
              </div>
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
    // Show Modal
    $(document).ready(function () {
      /* When click show Client */
      $('body').on('click', '#show-data-pr', function () {
          var oldJNURL = $(this).data('url');
          $.get(oldJNURL, function (data) {
              $('#modal-show-jn').modal('show');
              $('#show_txt_old_jn').val(data.job_number);
              $('#show_txt_contract').val(data.contract_no);
              $('#show_txt_amount').val(data.amount);
              $('#show_txt_comp').val(data.nama_perusahaan);
              $('#show_txt_program_name').val(data.program);
              $('#show_txt_cp').val(data.c_p);
              $('#show_txt_hours').val(data.hours);
              $('#show_txt_pic').val(data.pic);
              $('#show_txt_instructor').val(data.instructor);
              $('#show_txt_day_start').val(data.day_training);
              $('#show_txt_day_end').val(data.day_training2);
              $('#show_txt_start_date').val(data.starting_date);
              $('#show_txt_end_date').val(data.ending_date);
              $('#show_txt_teacher_comp').val(data.teacher_comp);
              $('#show_txt_total_day').val(data.total_manday);
              $('#show_txt_remarks').val(data.remarks);
              
          })
      });
      
    });
  $(document).ready(function(){
      $('body').on('click','#btn_refresh_jn',function(){
        var jnURL = $(this).data('url');
        $.get(jnURL, function (data){
          $('#txt_old_jn').val(data.job_number);
        })
      });
  });
  </script>

