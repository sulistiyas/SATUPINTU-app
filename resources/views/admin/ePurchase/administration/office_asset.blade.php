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
                <li class="breadcrumb-item active">Office Asset</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Office Asset Data</h3>
                            <div class="float-sm-right">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_device_master">
                                    <i class="fas fa-plus">&nbsp;Add Asset</i>
                                </button>&nbsp;&nbsp;&nbsp;&nbsp;
                                {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_device_master">
                                    <i class="fas fa-plus">&nbsp;Add Device</i>
                                </button> --}}
                                <a href="{{ route('index_device_master') }}" class="btn btn-primary"><i class="fas fa-plus">&nbsp;Add Device</i></a>
                            </div>
                        </div>
                         <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tbl_office_asset" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Asset Code</th>
                                        <th>Device Name</th>
                                        <th>Qty</th>
                                        <th>Brand</th>
                                        <th>Condition</th>
                                        <th>User - Location</th>
                                        <th><i class="fas fa-cog"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($office_asset as $item_asset)
                                        <tr>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>{{ $item_asset->asset_code }}</td>
                                            <td>{{ $item_asset->device_name }}</td>
                                            <td>{{ $item_asset->qty }}</td>
                                            <td>{{ $item_asset->brand }}</td>
                                            <td>{{ $item_asset->kondisi }}</td>
                                            <td>{{ $item_asset->name }} - {{ $item_asset->device_location }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-block btn-outline-success" title="Show Data" data-toggle="modal" data-target="#modal_pr_show_manager" id="getPR" data-url="{{ route('show_modal_pr_admin',['id'=>$item_asset->id_asset])}}">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                    <div class="col-6">
                                                        {{-- <a href="{{ route('QR_Code_Generate') }}" class="btn btn-block btn-outline-primary"><i class="fas fa-qrcode"></i></a> --}}
                                                        <form action="{{ route('QR_Code_Generate') }}" method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="txt_id_asset" id="txt_id_asset" value="{{ $item_asset->id_asset }}">
                                                            <button type="submit" class="btn btn-block btn-outline-primary" title="QR Code">
                                                                <i class="fas fa-qrcode"></i>
                                                            </button>
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
    <form action="{{ route('store_office_asset') }}" method="POST" enctype="multipart/form-data" id="device_master" name="device_master">
        @csrf
        <div class="modal fade" id="modal_device_master">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Device Form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-10">
                            <div class="form-group">
                                <label for="txt_device_name">Device Name</label>
                                {{-- <input type="text" name="txt_device_name" id="txt_device_name" class="form-control" placeholder="Device Name" required > --}}
                                <select name="txt_id_device" id="txt_id_device" class="form-control select2bs4">
                                    @foreach ($device_master as $item_device)
                                        <option value="{{ $item_device->id_device }}">{{ $item_device->device_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="txt_model">Model</label>
                                <input type="text" class="form-control" id="txt_model" name="txt_model" placeholder="Model">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="txt_brand">Brand</label>
                                <input type="text" class="form-control" id="txt_brand" name="txt_brand" placeholder="Brand">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="txt_serial_number">Serial Number</label>
                                <input type="text" class="form-control" id="txt_serial_number" name="txt_serial_number" placeholder="Serial Number">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="txt_purchase_date">Purchase Date</label>
                                <input type="date" class="form-control" id="txt_purchase_date" name="txt_purchase_date" placeholder="Purchase Date">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="txt_price">Price</label>
                                <input type="number" class="form-control" id="txt_price" name="txt_price" placeholder="Price">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="txt_asset_qty">Qty</label>
                                <input type="number" class="form-control" id="txt_asset_qty" name="txt_asset_qty" placeholder="Qty">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="">Condition</label>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="txt_condition" value="Good" name="txt_condition">
                                    <label for="txt_condition" class="custom-control-label">Good</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="txt_condition2" value="Damaged" name="txt_condition">
                                    <label for="txt_condition2" class="custom-control-label">Damaged</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="txt_id_users">User</label>
                                <select name="txt_id_users" id="txt_id_users" class="form-control select2bs4" required>
                                    @foreach ($user_data as $item_user)
                                        <option value="{{ $item_user->id_employee }}">{{ $item_user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="txt_device_location">Device Location</label>
                                <input type="text" class="form-control" id="txt_device_location" name="txt_device_location" placeholder="Device Location">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-10">
                            <div class="form-group">
                                <label for="txt_desc">Description</label>
                                <textarea name="txt_desc" id="txt_desc" cols="10" rows="5" class="form-control" style="resize: none"></textarea>
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
</div>
@include('admin.includes.footer')
<script>
    // Datatables
    $(function () {
      $("#tbl_office_asset").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#tbl_office_asset_wrapper .col-md-6:eq(0)');
    });
</script>