@include('hr_ga.includes.header')
@include('hr_ga.includes.sidebar')
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
                    <li class="breadcrumb-item active">Furniture</li>
                  </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Furniture Table</h3>
                            <button class="float-sm-right btn btn-primary" data-toggle="modal" data-target="#modal_furniture">
                                <i class="fas fa-plus">&nbsp;Add Data</i>
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="furniture_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Condition</th>
                                        <th>Location</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($furnitures as $furniture)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $furniture->item_name }}</td>
                                        <td>{{ $furniture->quantity }}</td>
                                        <td>{{ $furniture->condition }}</td>
                                        <td>
                                            <button class="btn btn-warning" data-toggle="modal" data-target="#modal_edit_furniture" onclick="editFurniture({{ $furniture->id }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger" onclick="deleteFurniture({{ $furniture->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Condition</th>
                                        <th>Location</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
{{-- Modals --}}
<div class="modal fade" id="modal_furniture">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Furniture Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('store_furniture') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="item_name">Item Name</label>
                        <input type="text" name="item_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="condition">Condition</label>
                        <input type="text" name="condition" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('hr_ga.includes.footer')
<script>
    $(document).ready(function() {
        $('#furniture_table').DataTable();
    });

    function editFurniture(id) {
        $.ajax({
            url: '/hr-ga/inventory/furniture/' + id + '/edit',
            type: 'GET',
            success: function(data) {
                $('#edit_id').val(data.id);
                $('#edit_item_name').val(data.item_name);
                $('#edit_quantity').val(data.quantity);
                $('#edit_condition').val(data.condition);
                $('#edit_location').val(data.location);
            }
        });
    }

    function deleteFurniture(id) {
        if (confirm('Are you sure want to delete this data?')) {
            $.ajax({
                url: '/hr-ga/inventory/furniture/' + id,
                type: 'DELETE',
                success: function(data) {
                    location.reload();
                }
            });
        }
    }
</script>