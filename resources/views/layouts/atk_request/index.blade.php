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
{{-- Main Content --}}
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
                <li class="breadcrumb-item active">ATK Request </li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    {{-- Section --}}
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">ATK Request Data </h3>
                            <button type="button" id="create_atk_request" class="float-sm-right btn btn-primary" data-toggle="modal" data-target="#modal_atk_request">
                                <i class="fas fa-plus">&nbsp;Add Data</i>
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="tbl_atk_request" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Item Name</th>
                                        <th>QTY</th>
                                        <th>Status</th>
                                        <th><i class="fas fa-cog"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($atk_request_data as $list_data)
                                        <tr>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>{{ $list_data->atk_name }}</td>
                                            <td>{{ $list_data->quantity }}</td>
                                            <td>
                                                @if ($list_data->status == '0')
                                                    <span class="badge badge-warning">Waiting</span>
                                                @elseif ($list_data->status == '1')
                                                    <span class="badge badge-success">Approved</span>
                                                @elseif ($list_data->status == '2')
                                                    <span class="badge badge-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>
                                                
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
    {{-- End Section --}}
</div>
{{-- Modal ATK Request --}}
<div class="modal fade" id="modal_atk_request">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">ATK Request Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('store_atk_request') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="atk_id">ATK Name</label>
                        <select class="form-control select2" name="atk_id" id="atk_id" required>
                            <option value="">-- Select ATK --</option>
                            @foreach ($atk_master as $item)
                                <option value="{{ $item->id_atk }}">{{ $item->atk_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control" name="quantity" id="quantity" placeholder="Enter quantity" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter description"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit Request</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div> 
    <!-- /.modal-dialog -->
</div>
{{-- End Modal ATK Request --}}
{{-- End Main Content --}}
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
      $("#tbl_atk_request").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#tbl_atk_request_wrapper .col-md-6:eq(0)');
    });
</script>

<script>
    $(document).ready(function () {
        // Inisialisasi Select2 ketika modal dibuka
        $('#modal_atk_request').on('shown.bs.modal', function () {
            $('#atk_name').select2({
                theme: 'bootstrap4', // atau theme lain kalau tidak pakai select2bs4
                dropdownParent: $('#modal_atk_request') // ini penting agar dropdown muncul di atas modal
            });
        });

        // Opsional: destroy select2 saat modal ditutup untuk menghindari duplikasi
        $('#modal_atk_request').on('hidden.bs.modal', function () {
            $('#atk_name').select2('destroy');
        });
    });
</script>