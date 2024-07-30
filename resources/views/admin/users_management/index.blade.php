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
              <li class="breadcrumb-item active">Users Table</li>
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
                            <h3 class="card-title">Users Data</h3>
                            <button type="button" class="float-sm-right btn btn-primary" data-toggle="modal" data-target="#modal_users">
                                <i class="fas fa-plus">&nbsp;Add New Users</i>
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="tbl_users" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Position</th>
                                        <th>Divisi</th>
                                        <th><i class="fas fa-cog"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users_data as $item_users)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item_users->name }}</td>
                                            <td>{{ $item_users->emp_position }}</td>
                                            <td>{{ $item_users->emp_division }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <div class="col-md-4">
                                                        <button type="button" class="btn btn-outline-primary" title="Show Data" data-toggle="modal" data-target="#modal_users_show" id="get_users" data-url="{{ route('show_modal_users',['id'=>$item_users->id])}}"><i class="fas fa-eye"></i></button>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button type="button" class="btn btn-outline-warning" title="Edit Data" data-toggle="modal" data-target="#modal_users_edit" id="edit_users" data-url="{{ route('edit_users',['id'=>$item_users->id])}}"><i class="fas fa-pen"></i></button>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <form onsubmit="return confirm('Apakah Anda Yakin ingin Menghapus data ?');" action="{{ route('destroy_users',[$item_users->id]) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger" title="Delete Data" id="delete_users"><i class="fas fa-trash"></i></button>
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
    {{-- Create Modal --}}
    {{-- <form action="{{ route('store_users') }}" method="POST" enctype="multipart/form-data" id="users" name="users"> --}}
        @csrf
        <div class="modal fade" id="modal_users">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Users Form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="stepper1" class="bs-stepper">
                        <div class="bs-stepper-header" role="tablist">
                            <div class="step" data-target="#crud-form-1">
                                <button type="button" class="step-trigger" role="tab" id="stepperFormTrigger1" aria-controls="crud-form-1">
                                    <span class="bs-stepper-circle">1</span>
                                    <span class="bs-stepper-label">Personal Data</span>
                                </button>
                            </div>
                            <div class="bs-stepper-line"></div>
                            <div class="step" data-target="#crud-form-2">
                                <button type="button" class="step-trigger" role="tab" id="stepperFormTrigger2" aria-controls="crud-form-2">
                                    <span class="bs-stepper-circle">2</span>
                                    <span class="bs-stepper-label">Office Data</span>
                                </button>
                            </div>
                            <div class="bs-stepper-line"></div>
                            <div class="step" data-target="#crud-form-3">
                                <button type="button" class="step-trigger" role="tab" id="stepperFormTrigger3" aria-controls="crud-form-3">
                                    <span class="bs-stepper-circle">3</span>
                                    <span class="bs-stepper-label">Login Details</span>
                                </button>
                            </div>
                        </div>
                        <div class="bs-stepper-content">
                            <form action="{{ route('store_users') }}" method="POST" enctype="multipart/form-data" id="users" name="users" class="needs-validation" novalidate>
                                @csrf
                                {{-- Step 1 --}}
                                <div id="crud-form-1" role="tabpanel" class="bs-stepper-pane fade" aria-labelledby="stepperFormTrigger1">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="employee_name">Employee Name</label>
                                                <input type="text" class="form-control" id="employee_name" name="employee_name" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="employee_phone">Phone Number</label>
                                                <input type="number" class="form-control" id="employee_phone" name="employee_phone" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="employee_address">Employee Address</label>
                                                <textarea name="employee_address" id="employee_address" cols="10" rows="12" class="form-control" style="resize: none;"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="employee_personal_email">Personal E-Mail</label>
                                                <input type="email" name="employee_personal_email" id="employee_personal_email" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="employee_bank_number">Bank Number</label>
                                                <input type="number" name="employee_bank_number" id="employee_bank_number" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="employee_sex">Employee Sex</label>
                                                <select name="employee_sex" id="employee_sex" class="form-control">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="employee_birth">Place Birth</label>
                                                <input type="text" name="employee_birth" id="employee_birth" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="employee_dob">Employee DoB</label>
                                                <input type="date" class="form-control" id="employee_dob" name="employee_dob">
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-success btn-next-form"> Next </a>
                                </div>
                                {{-- Step 2 --}}
                                <div id="crud-form-2" role="tabpanel" class="bs-stepper-pane fade" aria-labelledby="stepperFormTrigger2">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="epmloyee_work_email">Employee Work E-mail</label>
                                                <input type="email" class="form-control" id="epmloyee_work_email" name="epmloyee_work_email">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="employee_date_join">Employee Date Joined</label>
                                                <input type="date" class="form-control" id="employee_date_join" name="employee_date_join">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="employee_level">Employee Level</label>
                                                <select name="employee_level" id="employee_level" class="form-control">
                                                    <option value="1">Director</option>
                                                    <option value="2">Manager</option>
                                                    <option value="3">Staff</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="employee_division">Employee Division</label>
                                                <select name="employee_division" id="employee_division"
                                                    class="form-control">
                                                    <option value="Operational">Operational</option>
                                                    <option value="Finance">Finance</option>
                                                    <option value="Marketing">Marketing</option>
                                                    <option value="Academic">Academic</option>
                                                    <option value="i-Link">i-Link</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="employee_nik">Employee NIK</label>
                                                <input type="number" class="form-control" id="employee_nik"
                                                    name="employee_nik">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="employee_npwp">Employee NPWP</label>
                                                <input type="number" class="form-control" id="employee_npwp"
                                                    name="employee_npwp">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="employee_bpjs_kes">Employee BPJK Kesehatan</label>
                                                <input type="number" class="form-control" id="employee_bpjs_kes"
                                                    name="employee_bpjs_kes">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="employee_bpjs_tk">Employee BPJS Ketenagakerjaan</label>
                                                <input type="number" class="form-control" id="employee_bpjs_tk"
                                                    name="employee_bpjs_tk">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="employee_contract">Work Contract</label>
                                                <select name="employee_contract" id="employee_contract"
                                                    class="form-control">
                                                    <option value="Permanent">Permanent</option>
                                                    <option value="Contract">Contract</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="employee_marriage">Marriage Status</label>
                                                <select name="employee_marriage" id="employee_marriage"
                                                    class="form-control">
                                                    <option value="Married">Married</option>
                                                    <option value="Single">Single</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-warning" onclick="stepper1.previous()">Previous</a>
                                    <a href="#" class="btn btn-success btn-next-form"> Next </a>
                                </div>
                                {{-- Step 3 --}}
                                <div id="crud-form-3" role="tabpanel" class="bs-stepper-pane fade text-center" aria-labelledby="stepperFormTrigger3">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="employee_email">Create New Email address</label>
                                                <input type="email" class="form-control" id="employee_email"
                                                    name="employee_email" placeholder="Enter email" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="employee_password"> Create New Password</label>
                                                <input type="password" class="form-control" id="employee_password"
                                                    name="employee_password" placeholder="Password" required>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-warning mt-5" onclick="stepper1.previous()">Previous</a>
                                    <input type="submit" value="Submit" class="btn btn-success mt-5">
                                </div>
                            </form>
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
    {{-- </form> --}}
    {{-- End Create --}}
    {{-- Update Modal --}}
    <form action="{{ route('update_users') }}" method="POST" enctype="multipart/form-data" id="users_update" name="users_update">
        @csrf
        <div class="modal fade" id="modal_users_edit">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="overlay" id="modal-loader">
                  <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
                <div class="modal-header">
                    <h4 class="modal-title">Users Update Form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   <div id="dynamic-content"></div>
                </div>
                <div class="modal-footer justify-content-between">
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-warning" data-dismiss="modal">Close</button>&nbsp;
                        <button type="submit" class="btn btn-outline-primary">Update</button>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </form>
    {{-- End Update Modal --}}

</div>

@include('admin.includes.footer')
<script src="{{ asset('assets/plugins/bs-stepper/js/user-form-stepper.js') }}"></script>
<script>
    // Datatables
    $(function () {
      $("#tbl_users").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#tbl_users_wrapper .col-md-6:eq(0)');
    });
</script>
<script>
    $(document).ready(function(){
  
        $(document).on('click', '#edit_users', function(e){
    
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