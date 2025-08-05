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
                        </div>
                        <div class="card-body">
                            <table id="tbl_request_hr_ga" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Item Name</th>
                                        <th>QTY</th>
                                        <th>Requester</th>
                                        <th>Status</th>
                                        <th><i class="fas fa-cog"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach ($atk_request_list as $atk_request)
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $atk_request->atk_name }}</td>
                                            <td>{{ $atk_request->quantity }}</td>
                                            <td>{{ $atk_request->name }}</td>
                                            <td>
                                                @php
                                                    if ( $atk_request->status == '0') {
                                                        echo '<span class="badge badge-warning">Pending</span>';
                                                    } elseif ( $atk_request->status == '1') {
                                                        echo '<span class="badge badge-success">Approved</span>';
                                                    } elseif ( $atk_request->status == '2') {
                                                        echo '<span class="badge badge-danger">Rejected</span>';
                                                    } else {
                                                        # code...
                                                    }
                                                @endphp
                                            </td>
                                            <td>
                                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_view_atk_request_{{ $atk_request->atk_request_id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_view_atk_request_{{ $atk_request->atk_request_id }}">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal_view_atk_request_{{ $atk_request->atk_request_id }}">
                                                    <i class="far fa-times-circle"></i>
                                                </button>
                                            </td>
                                        @endforeach
                                    </tr>
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
@include('hr_ga.includes.footer')

<script>
    $(document).ready(function() {
        $('#tbl_request_hr_ga').DataTable({
            "responsive": true,
            "autoWidth": false,
            "lengthChange": true,
            "pageLength": 10,
            "language": {
                "search": "Search:",
                "lengthMenu": "Show _MENU_ entries",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "No entries available",
                "infoFiltered": "(filtered from _MAX_ total entries)"
            }
        });
    });
</script>