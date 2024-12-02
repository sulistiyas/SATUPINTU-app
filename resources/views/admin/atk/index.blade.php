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
              <li class="breadcrumb-item active">ATK Table</li>
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
                            <h3 class="card-title">ATK Data</h3>
                            <button type="button" id="create_atk" class="float-sm-right btn btn-primary" data-toggle="modal" data-target="#modal_letter_number" data-url="{{ route('show_modal_create_atk')}}">
                                <i class="fas fa-plus">&nbsp;Add Data</i>
                            </button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tbl_atk_master" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item Desc</th>
                                        <th>Item Brand</th>
                                        <th>Stock</th>
                                        <th>Unit</th>
                                        <th><i class="fas fa-cog"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($atk_list as $item_atk)
                                        <tr>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>{{ $item_atk->atk_name }}</td>
                                            <td>{{ $item_atk->atk_brand }}</td>
                                            <td>{{ $item_atk->atk_stock }}</td>
                                            <td>{{ $item_atk->atk_unit }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <div class="col-md-5">
                                                        <button type="button" class="btn btn-outline-primary" title="Show Data" data-toggle="modal" data-target="#modal_legalitas_show" id="get_legalitas" data-url="{{ route('show_modal_pr_admin',['id'=>$item_atk->id_atk])}}"><i class="fas fa-eye"></i></button>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <form onsubmit="return confirm('Apakah Anda Yakin ingin Menghapus data ?');" action="{{ route('destroy_client_admin',[$item_atk->id_atk]) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger" title="Delete Data" id="delete_atk"><i class="fas fa-trash-alt"></i></button>
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
</div>
@include('admin.includes.footer')
{{-- Create Modal --}}
<form action="{{ route('store_atk_master') }}" method="POST" enctype="multipart/form-data" id="atk_form" name="atk_form">
    @csrf
    <div class="modal fade" id="modal_letter_number">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="overlay" id="modal-loader">
                <i class="fas fa-2x fa-sync fa-spin"></i>
            </div>
            <div class="modal-header">
                <h4 class="modal-title">ATK Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="atk_name">ATK Name</label>
                            <input type="text" name="atk_name" id="atk_name" class="form-control" required placeholder="ATK NAME">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="atk_brand">ATK Brand</label>
                            <input type="text" name="atk_brand" id="atk_brand" class="form-control" required placeholder="ATK BRAND">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="atk_stock">Item Stock</label>
                            <input type="number" name="atk_stock" id="atk_stock" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="atk_unit">Unit</label>
                            <select name="atk_unit" id="atk_unit" class="form-control select2bs4">
                                <option value="Unit" disabled>- Select Unit Type -</option>
                                <option value="Unit">Unit</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Lusin">Lusin</option>
                                <option value="Pack">Pack</option>
                                <option value="Box">Box</option>
                                <option value="Pages">Pages</option>
                                <option value="Rim">Rim</option>
                              </select>
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
{{-- End Create Modal --}}
<script>
    // Datatables
    $(function () {
      $("#tbl_atk_master").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#tbl_atk_master_wrapper .col-md-6:eq(0)');
    });
</script>
<script>
    $(document).ready(function(){
  
        $(document).on('click', '#create_atk', function(e){
    
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