@include('hr_ga.includes.header')
@include('hr_ga.includes.sidebar')
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
                <li class="breadcrumb-item active">OLD PR PO Table</li>
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
                            <h3 class="card-title">Purchase Order Data</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tbl_old_pr" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>PR Number</th>
                                        <th>PR Date</th>
                                        <th>Desc</th>
                                        <th>PO Number</th>
                                        <th>PO Date</th>
                                    </tr>
                                </thead>
                                {{-- <tbody>
                                    @foreach ($old_pr as $old_data_pr)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $old_data_pr->pr_number }}</td>
                                            <td>{{ $old_data_pr->description }}</td>
                                            <td>{{ $old_data_pr->po_number }}</td>
                                            <th><i class="fas fa-cog"></i></th>
                                        </tr>
                                    @endforeach
                                </tbody> --}}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </section>
</div>
@include('hr_ga.includes.footer')
<script>
    // Datatables
    // $(function () {
    //   $("#tbl_old_pr").DataTable({
    //     "responsive": true, "lengthChange": false, "autoWidth": false,
    //     "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    //   }).buttons().container().appendTo('#tbl_old_pr_wrapper .col-md-6:eq(0)');
    // });
</script>
<script>
  $(function() {
      $('#tbl_old_pr').DataTable({
          processing: true,
          serverSide: true,
          ajax: '{!! route('get_old_pr_hr_ga') !!}',
          columns: [{ 
                  data: 'id_pr',
                  name: 'id_pr'
              },
              {
                  data: 'pr_number',
                  name: 'pr_number'
              },
              {
                  data: 'date',
                  name: 'date'
              },
              {
                  data: 'description',
                  name: 'description'
              },
              {
                  data: 'po_number',
                  name: 'po_number'
              },
              {
                  data: 'date_po',
                  name: 'date_po'
              }
          ]
      });
  });
</script>