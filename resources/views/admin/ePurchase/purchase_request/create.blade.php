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
              <li class="breadcrumb-item"><a href="{{ route('index_pr_admin') }}">PR Table</a></li>
              <li class="breadcrumb-item active">Purchase Request Form</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <form action="{{ route('store_pr_admin') }}" method="POST" enctype="multipart/form-data" id="create_pr" name="create_pr">
            @csrf
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Purchase Request Form</h3>
                                <button type="button" class="float-sm-right btn btn-primary" id="add_btn" name="add_btn">
                                    <i class="fas fa-plus">&nbsp;Add New Row</i>
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="txt_jn">Job Number</label>
                                            <input type="hidden" id="txt_pr_number" name="txt_pr_number" class="form-control" value="{{ $id }}" readonly>
                                            <select name="txt_jn" id="txt_jn" class="form-control select2bs4">
                                                <option value="Operational Office">Operational Office</option>
                                                <option value="I-Link">I-Link</option>
                                                <option value="PT. Conexus">PT. Conexus</option>
                                                @foreach ($data as $list_jn)
                                                    <option value="{{ $list_jn->id_jn }}">{{ $list_jn->job_number }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <table id="tbl_create_pr" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Description</th>
                                                    <th>Qty</th>
                                                    <th>Unit</th>
                                                    <th><i class="fas fa-cog"></i></th>
                                                </tr>
                                            </thead>
                                            <tbody id="container">
                                                {{--  --}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                             <div class="card-footer">
                                <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <input type="submit" value="Submit" name="submit" id="submit" class="form-control btn btn-success">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <a href="{{ route('index_pr_admin') }}" class="form-control btn btn-danger">Cancel</a>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
    <!-- /.content -->
</div>
@include('admin.includes.footer')
<script type="text/javascript">
    // Datatables
    $(function () {
      $("#tbl_create_pr").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        
      }).buttons().container().appendTo('#tbl_create_pr_wrapper .col-md-6:eq(0)');
    });
    $(document).ready(function() {
        var count = 0;
        $("#add_btn").click(function(){
            count += 1;
            $('#container').append(
                '<tr id="row">'
                      + '<td><input id="description[]" class="form-control" name="description[]" type="textdomain" maxlength="45" placeholder="Input Description Max 45 Character"></td>'
                      + '<td><input id="quantity[]" class="form-control" name="quantity[]" type="number" placeholder="Input Quantity only number"></td>'
                      + '<td>'
                        + '<select name="unit[]" id="unit[]" class="form-control select2bs4">'
                          + '<option value="Unit">- Select Unit Type -</option>'
                          + '<option value="Unit">Unit</option>'
                          + '<option value="Pcs">Pcs</option>'
                          + '<option value="Lusin">Lusin</option>'
                          + '<option value="Pack">Pack</option>'
                          + '<option value="Box">Box</option>'
                          + '<option value="Pages">Pages</option>'
                          + '<option value="Rim">Rim</option>'
                        + '</select>'
                      +'</td>'
                    + '<td><button class="btn btn-danger" id="DeleteRow" type="button">Delete</button></td>'
                     + '<input id="rows[]" name="rows[]" value="'+ count +'" type="hidden"></td></tr>'
            );
        });
        $("body").on("click", "#DeleteRow", function () {
            $(this).parents("#row").remove();
        })
    });
</script>
