@if (Auth::user()->user_level == '0')
    @include('admin.includes.header')
    @include('admin.includes.sidebar')
    
@elseif (Auth::user()->user_level == '1' )
    {{-- @include('dire.includes.header')
    @include('dire.includes.sidebar')
     --}}
@elseif (Auth::user()->user_level == '2' )    
    @include('manager.includes.header')
    @include('manager.includes.sidebar')
    
@elseif (Auth::user()->user_level == '3' )    
    @include('users.includes.header')
    @include('users.includes.sidebar')

@elseif (Auth::user()->user_level == '4' )
    @include('hr_ga.includes.header')
    @include('hr_ga.includes.sidebar')
@endif

{{-- Content --}}

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
              <li class="breadcrumb-item"><a href="{{ route('index_jn_users') }}">Job Number Table</a></li>
              <li class="breadcrumb-item active">Old Job Number Table</li>
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
                      <h3 class="card-title">2020 Job Number Data</h3>
                      
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <table id="tbl_jn" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th style="width:200%">Job Number</th>
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
                                    <td>{{ $item->nama_perusahaan }}</td>
                                    <td>{{ $item->program }}</td>
                                    <td>{{ $item->pic }}</td>
                                    <td>
                                      <a href="javascript:void(0)" id="show-data" data-url="{{ route('show_jn_old_users',$item->id_jn) }}" class="btn btn-primary" title="View Data"><i class="far fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Job Number</th>
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

{{-- End Content --}}
@if (Auth::user()->user_level == '0')
    @include('admin.includes.footer')
@elseif (Auth::user()->user_level == '1' )
    {{-- @include('dire.includes.footer')  --}}
@elseif (Auth::user()->user_level == '2' )    
    @include('manager.includes.footer')
@elseif (Auth::user()->user_level == '3' )
    @include('users.includes.footer')
@elseif (Auth::user()->user_level == '4' )
    @include('hr_ga.includes.footer')
@endif
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
</script>