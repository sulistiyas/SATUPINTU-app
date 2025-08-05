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
                                <h3 class="card-title">Office Legalitas </h3>
                                <button type="button" id="create_legalitas" class="float-sm-right btn btn-primary" data-toggle="modal" data-target="#modal_legalitas">
                                    <i class="fas fa-plus">&nbsp;Add Data</i>
                                </button>
                            </div>
                            <div class="card-body">
                                <table id="tbl_legalitas" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Legalitas Name</th>
                                            <th>Document Number</th>
                                            <th>Issued Date</th>
                                            <th>Expired Date</th>
                                            <th><i class="fas fa-cog"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($office_legalitas as $legalitas)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $legalitas->legalitas_name }}</td>
                                                <td>{{ $legalitas->document_number }}</td>
                                                <td>{{ \Carbon\Carbon::parse($legalitas->issued_date)->format('d-m-Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($legalitas->expired_date)->format('d-m-Y') }}</td>
                                                <td>
                                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_view_legalitas_{{ $legalitas->id_legalitas }}">
                                                        <i class="fas fa-eye"></i> View
                                                    </button>
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
@include('users.includes.footer')
<script>
    $(document).ready(function() {
        $('#tbl_legalitas').DataTable({
            "responsive": true,
            "autoWidth": false,
        });
    });

    // Add your JavaScript functions for modal handling here
</script>