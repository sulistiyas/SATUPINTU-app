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
                <li class="breadcrumb-item active">Office Legalitas</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Legalitas Office Data</h3>
                            <button type="button" class="float-sm-right btn btn-primary" data-toggle="modal" data-target="#modal_legalitas">
                                <i class="fas fa-plus">&nbsp;Add Data</i>
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="tbl_legalitas" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Dokumen</th>
                                        <th>Number</th>
                                        <th>Company</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th><i class="fas fa-cog"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($legalitas_office as $item_legalitas)
                                        <tr>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>{{ $item_legalitas->dokumen }}</td>
                                            <td>{{ $item_legalitas->no_legalitas }}</td>
                                            <td>{{ $item_legalitas->nama_perusahaan }}</td>
                                            <td>{{ $item_legalitas->berakhir }}</td>
                                            <td>
                                                @php
                                                    $date_now = date('Y-m-d');
                                                @endphp
                                                {{-- @if ($date_now > $item_legalitas->berakhir)
                                                    <p style="color: red; font-weight: 900;">Expired</p>
                                                @else
                                                    <p style="color: green; font-weight: 900;">Good</p>
                                                @endif --}}
                                                @if ($item_legalitas->status == "1")
                                                    <p style="color: green; font-weight: 900;">Ok</p>
                                                @elseif ($item_legalitas->status == "2")
                                                    <p style="color: orange; font-weight: 900;">Proses</p>
                                                @elseif ($item_legalitas->status == "3")
                                                    <p style="color: red; font-weight: 900;">Expired</p>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <div class="col-md-5">
                                                        <button type="button" class="btn btn-outline-primary" title="Show Data" data-toggle="modal" data-target="#modal_legalitas_show" id="get_legalitas" data-url="{{ route('show_modal_pr_admin',['id'=>$item_legalitas->id_legalitas])}}"><i class="fas fa-eye"></i></button>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button type="button" class="btn btn-outline-warning" title="Edit Data" data-toggle="modal" data-target="#modal_legalitas_edit" id="edit_legalitas" data-url="{{ route('edit_office_legalitas',['id'=>$item_legalitas->id_legalitas])}}"><i class="fas fa-pen"></i></button>
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
    <form action="{{ route('store_office_legalitas') }}" method="POST" enctype="multipart/form-data" id="legalitas_office" name="legalitas_office">
        @csrf
        <div class="modal fade" id="modal_legalitas">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Legalitas Form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="txt_no_legalitas">Nomor</label>
                                <input type="text" name="txt_no_legalitas" id="txt_no_legalitas" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="txt_dokumen">Dokumen</label>
                                <input type="text" name="txt_dokumen" id="txt_dokumen" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="txt_comp"> Company </label>
                                <select name="txt_comp" id="txt_comp" class="form-control select2bs4">
                                    <option value="PT. Inlingua International Indonesia">PT. Inlingua International Indonesia</option>
                                    <option value="PT. i-Link">PT. i-Link</option>
                                    <option value="PT. Jakarta International College (JIC)">PT. Jakarta International College (JIC)</option>
                                    <option value="PT. Multi Sarana Edukasi (MSE)">PT. Multi Sarana Edukasi (MSE)</option>
                                    <option value="PT. Sinergy Informasi Pratama (SIP)">PT. Sinergy Informasi Pratama (SIP)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="txt_issued">Issued</label>
                            <div class="input-group input-group-lg">
                                <input type="date" class="form-control datetimepicker-input" id="txt_issued" name="txt_issued" data-toggle="datetimepicker" data-target="#txt_issued" placeholder="YYYY/MM/DD" required/>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="txt_expiry">Expiry</label>
                            <div class="input-group input-group-lg">
                                <input type="date" class="form-control datetimepicker-input" id="txt_expiry" name="txt_expiry" data-toggle="datetimepicker" data-target="#txt_expiry" placeholder="YYYY/MM/DD" required/>
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
    <form action="{{ route('update_office_legalitas') }}" method="POST" enctype="multipart/form-data" id="legalitas_office_update" name="legalitas_office_update">
        @csrf
        <div class="modal fade" id="modal_legalitas_edit">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="overlay" id="modal-loader">
                  <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
                <div class="modal-header">
                    <h4 class="modal-title">Legalitas Update Form</h4>
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
<script type="text/javascript">
  $(function () {
      $('#txt_issued').datetimepicker({format: 'YYYY/MM/DD'});
      $('#txt_expiry').datetimepicker({format: 'YYYY/MM/DD'});
  });
</script>
<script>
    // Datatables
    $(function () {
      $("#tbl_legalitas").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#tbl_legalitas_wrapper .col-md-6:eq(0)');
    });
</script>
<script>
    $(document).ready(function(){
  
        $(document).on('click', '#edit_legalitas', function(e){
    
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