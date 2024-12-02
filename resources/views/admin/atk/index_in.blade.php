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
              <li class="breadcrumb-item"><a href="{{ route('index_atk_master') }}">ATK Table</a></li>
              <li class="breadcrumb-item active">ATK In</li>
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
                <div class="col-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">ATK in Form</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('store_atk_in') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="txt_atk_id">ATK Name</label>
                                    <select name="txt_atk_id" id="txt_atk_id" class="form-control select2bs4">
                                        <option value=""@disabled(true)>- Select Name -</option>
                                        @foreach ($atk_item as $item_atk)
                                            <option value="{{ $item_atk->id_atk }}">{{ $item_atk->atk_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="txt_atk_qty">Qty</label>
                                    <input type="number" name="txt_atk_qty" id="txt_atk_qty" class="form-control" required placeholder="QTY ATK in">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">ATK Data</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tbl_atk_in" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item Desc</th>
                                        <th>Item Brand</th>
                                        <th>Stock</th>
                                        <th>Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($atk_in_list as $item_atk)
                                        <tr>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>{{ $item_atk->atk_name }}</td>
                                            <td>{{ $item_atk->atk_brand }}</td>
                                            <td>{{ $item_atk->atk_stock }}</td>
                                            <td>{{ $item_atk->atk_unit }}</td>
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
<script>
    // Datatables
    $(function () {
      $("#tbl_atk_in").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
      }).buttons().container().appendTo('#tbl_atk_in_wrapper .col-md-6:eq(0)');
    });
</script>