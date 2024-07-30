@include('admin.includes.header')
@include('admin.includes.sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        {{-- Purchase Request --}}
        <div class="row">
          
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>
                  @php
                      $query_pr = Illuminate\Support\Facades\DB::table('pr')->where('pr_status','=','4')
                      ->orWhere('pr_status','=','3')
                      ->orWhere('pr_status','=','2')
                      ->orWhere('pr_status','=','1')->get();
                      $pr_count =  $query_pr->count();
                  @endphp
                  {{ $pr_count }}
                </h3>

                <p>PR Approved</p>
              </div>
              <div class="icon">
                <i class="far fa-thumbs-up"></i>
              </div>
              <a href="{{ route('index_pr_admin') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>
                  @php
                      $query_pr = Illuminate\Support\Facades\DB::table('pr')->where('pr_status','=','5')
                      ->orWhere('pr_status','=','4')
                      ->orWhere('pr_status','=','3')
                      ->orWhere('pr_status','=','2')->get();
                      $pr_count =  $query_pr->count();
                  @endphp
                  {{ $pr_count }}
                </h3>

                <p>PR On Process</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-clock"></i>
              </div>
              <a href="{{ route('index_pr_admin') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>
                  @php
                      $query_pr = Illuminate\Support\Facades\DB::table('pr')->where('pr_status','=','6')->get();
                      $pr_count =  $query_pr->count();
                  @endphp
                  {{ $pr_count }}
                </h3>

                <p>PR Rejected</p>
              </div>
              <div class="icon">
                <i class="far fa-thumbs-down"></i>
              </div>
              <a href="{{ route('index_pr_admin') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>
                  @php
                      $query_letter = Illuminate\Support\Facades\DB::table('letter_number')->where('deleted_at','=',NULL)->get();
                      $letter_count =  $query_letter->count();
                  @endphp
                  {{ $letter_count }}
                </h3>

                <p>Letter Numbers</p>
              </div>
              <div class="icon">
                <i class="fas fa-box-open"></i>
              </div>
              <a href="{{ route('index_letter_number') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        {{-- Purchase Order --}}
        <!-- Small boxes (Stat box) -->
        <div class="row">
          
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>
                  @php
                      $query_po = Illuminate\Support\Facades\DB::table('po')->where('po_status','=','1')->get();
                      $po_count =  $query_po->count();
                  @endphp
                  {{ $po_count }}
                </h3>

                <p>PO Approved</p>
              </div>
              <div class="icon">
                <i class="far fa-thumbs-up"></i>
              </div>
              <a href="{{ route('index_po_admin') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>
                  @php
                      $query_po = Illuminate\Support\Facades\DB::table('po')->where('po_status','=','4')
                      ->orWhere('po_status','=','3')
                      ->orWhere('po_status','=','2')->get();
                      $po_count =  $query_po->count();
                  @endphp
                  {{ $po_count }}
                </h3>

                <p>PO On Process</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-clock"></i>
              </div>
              <a href="{{ route('index_po_admin') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>
                  @php
                      $query_po = Illuminate\Support\Facades\DB::table('po')->where('po_status','=','7')->get();
                      $po_count =  $query_po->count();
                  @endphp
                  {{ $po_count }}
                </h3>

                <p>PR Rejected</p>
              </div>
              <div class="icon">
                <i class="far fa-thumbs-down"></i>
              </div>
              <a href="{{ route('index_po_admin') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <section class="col-lg-6 connectedSortable">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-file-alt"></i>
                  Legalitas Office
                </h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                <table id="tbl_legalitas" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Dokumen</th>
                        {{-- <th>Number</th> --}}
                        <th>End Date</th>
                        <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach(Illuminate\Support\Facades\DB::table('legalitas_office')->where('status','=','3')->orderBy('berakhir','DESC')->get() as $item_legalitas)
                        <tr>
                          <td>{{ $loop->iteration }}.</td>
                          <td>{{ $item_legalitas->dokumen }} &nbsp;&nbsp;<a href="{{ route('index_office_legalitas') }}"><i class="fas fa-external-link-alt"></i></a></td>
                          {{-- <td>{{ $item_legalitas->no_legalitas }}</td> --}}
                          <td>{{ $item_legalitas->berakhir }}</td>
                          <td><p style="color: red; font-weight: 900;">Expired</p></td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </section>
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@include('admin.includes.footer')
<script>
  // Datatables
  $(function () {
    $("#tbl_legalitas").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "excel", "pdf"]
    }).buttons().container().appendTo('#tbl_legalitas_wrapper .col-md-6:eq(0)');
  });
</script>