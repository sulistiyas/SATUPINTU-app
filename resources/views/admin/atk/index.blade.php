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
                            <button type="button" id="create_atk" class="float-sm-right btn btn-primary" data-toggle="modal" data-target="#modal_atk" data-url="{{ route('show_modal_create_atk')}}">
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
                                                    <div class="col-md-4">
                                                        {{-- <button type="button" class="btn btn-outline-primary" title="Show Data" data-toggle="modal" data-target="#modal_legalitas_show" id="get_legalitas" data-url="{{ route('show_modal_pr_admin',['id'=>$item_atk->id_atk])}}"><i class="fas fa-eye"></i></button> --}}
                                                        <a href="javascript:void(0)" id="show-data" data-url="{{ route('show_atk_master_hr_ga',['id'=>$item_atk->id_atk])}}" class="btn btn-outline-primary"><i class="far fa-eye"></i></a>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <a href="javascript:void(0)" id="edit-data" data-url="{{ route('edit_atk_master_hr_ga',['id'=>$item_atk->id_atk])}}" class="btn btn-outline-warning"><i class="fas fa-pencil-alt"></i></a>
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
{{-- Create Modal --}}
@if (Auth::user()->user_level == '0')
    <form action="{{ route('store_atk_master') }}" method="POST" enctype="multipart/form-data" id="atk_form" name="atk_form">
@elseif (Auth::user()->user_level == '4' )
    <form action="{{ route('store_atk_master_hr_ga') }}" method="POST" enctype="multipart/form-data" id="atk_form" name="atk_form">
@endif
{{-- <form action="{{ route('store_atk_master') }}" method="POST" enctype="multipart/form-data" id="atk_form" name="atk_form"> --}}
    @csrf
    <div class="modal fade" id="modal_atk">
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
{{-- View Modal --}}
<div class="modal fade" id="modal_atk_show">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
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
                        <label for="show_txt_atk_name">ATK Name</label>
                        <input type="text" name="show_txt_atk_name" id="show_txt_atk_name" class="form-control" required placeholder="ATK NAME" readonly>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="show_txt_atk_brand">ATK Brand</label>
                        <input type="text" name="show_txt_atk_brand" id="show_txt_atk_brand" class="form-control" required placeholder="ATK BRAND" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="show_txt_atk_stock">Item Stock</label>
                        <input type="number" name="show_txt_atk_stock" id="show_txt_atk_stock" class="form-control" required readonly>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="show_txt_atk_unit">Unit</label>
                        <input type="text" name="show_txt_atk_unit" id="show_txt_atk_unit" class="form-control" required readonly>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
{{-- Edit Modal --}}
{{-- Create Modal --}}
@if (Auth::user()->user_level == '0')
    <form action="{{ route('update_atk_master') }}" method="POST" enctype="multipart/form-data" id="edit_atk_form" name="edit_atk_form">
@elseif (Auth::user()->user_level == '4' )
    <form action="{{ route('update_atk_master_hr_ga') }}" method="POST" enctype="multipart/form-data" id="edit_atk_form" name="edit_atk_form">
@endif
{{-- <form action="{{ route('store_atk_master') }}" method="POST" enctype="multipart/form-data" id="atk_form" name="atk_form"> --}}
    @csrf
    <div class="modal fade" id="modal_atk_edit">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            {{-- <div class="overlay" id="modal-loader">
                <i class="fas fa-2x fa-sync fa-spin"></i>
            </div> --}}
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
                            <label for="edit_atk_name">ATK Name</label>
                            <input type="text" name="edit_atk_name" id="edit_atk_name" class="form-control" required placeholder="ATK NAME">
                            <input type="hidden" name="edit_atk_id" id="edit_atk_id" class="form-control" required placeholder="ATK NAME">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="edit_atk_brand">ATK Brand</label>
                            <input type="text" name="edit_atk_brand" id="edit_atk_brand" class="form-control" required placeholder="ATK BRAND">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="edit_atk_stock">Item Stock</label>
                            <input type="number" name="edit_atk_stock" id="edit_atk_stock" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="edit_atk_unit">Unit</label>
                            <select name="edit_atk_unit" id="edit_atk_unit" class="form-control select2bs4">
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

        $(document).ready(function () {
            /* When click show Client */
            $('body').on('click', '#show-data', function () {
                var url_atk_view = $(this).data('url');
                $.get(url_atk_view, function (data) {
                    $('#modal_atk_show').modal('show');
                    $('#show_txt_atk_name').val(data.atk_name);
                    $('#show_txt_atk_brand').val(data.atk_brand);
                    $('#show_txt_atk_stock').val(data.atk_stock);
                    $('#show_txt_atk_unit').val(data.atk_unit);
                });
            });

            $('body').on('click', '#edit-data', function () {
                var url_atk_edit = $(this).data('url');
                $.get(url_atk_edit, function (data) {
                    $('#modal_atk_edit').modal('show');
                    $('#edit_atk_id').val(data.id_atk);
                    $('#edit_atk_name').val(data.atk_name);
                    $('#edit_atk_brand').val(data.atk_brand);
                    $('#edit_atk_stock').val(data.atk_stock);
                    $('#edit_atk_unit').val(data.atk_unit);
                });
            });
        });
  
    });
</script>