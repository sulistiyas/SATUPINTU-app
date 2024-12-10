@include('users.includes.header')
@include('users.includes.sidebar')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0"></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Letter Number</li>
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
                            <h3 class="card-title">Letter Number Data</h3>
                            <button type="button" id="create_letter_number" class="float-sm-right btn btn-primary" data-toggle="modal" data-target="#modal_letter_number" data-url="{{ route('show_modal_create_letter_number_users')}}">
                                <i class="fas fa-plus">&nbsp;Add Data</i>
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="tbl_letter_number" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Letter Number</th>
                                        <th>Company</th>
                                        <th>User</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($letter_number as $item_letter_number)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item_letter_number->nomor_surat }}</td>
                                            <td>{{ $item_letter_number->nama_perusahaan }}</td>
                                            <td>{{ $item_letter_number->name }}</td>
                                            <td>{{ $item_letter_number->created_at }}</td>
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
</div>
{{-- Create Modal --}}
<form action="{{ route('store_letter_number_users') }}" method="POST" enctype="multipart/form-data" id="legalitas_office" name="legalitas_office">
    @csrf
    <div class="modal fade" id="modal_letter_number">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="overlay" id="modal-loader">
                <i class="fas fa-2x fa-sync fa-spin"></i>
            </div>
            <div class="modal-header">
                <h4 class="modal-title">Letter Number Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="dynamic-content"></div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
    </div>
</form>
{{-- End Create Modal --}}
@include('users.includes.footer')
<script>
    // Datatables
    $(function () {
      $("#tbl_letter_number").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#tbl_legalitas_wrapper .col-md-6:eq(0)');
    });
</script>
<script>
    $(document).ready(function(){
  
        $(document).on('click', '#create_letter_number', function(e){
    
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