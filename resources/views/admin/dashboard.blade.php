@include('admin.includes.header')
<style type="text/css">
  .dataTables_wrapper .dataTables_filter {
    float: none;
    text-align: center;
}
</style>
@include('admin.includes.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          {{-- <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col --> --}}
          <div class="col-12">
            <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              
              @php
                  $time_now = date('H:i');
                  $date_now = date('l, j F Y');
              @endphp
              <h5>
                
                {{-- <i class="icon fas fa-check"></i> Alert!{{ $time_now }} --}}
                @if ($time_now >= "00:00" && $time_now <= "11:59")
                    <p style="font-weight: 300; font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif; font-size:30px;">Good Morning !!!</p> 
                @elseif ($time_now >= "12:00" && $time_now <= "16:59")
                    <p style="font-weight: 300; font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif; font-size:30px;">Good Afternoon !!! </p> 
                @elseif ($time_now >= "17:00" && $time_now <= "23:59")
                    <p style="font-weight: 300; font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif; font-size:30px;">Good Evening !!! </p> 
                @endif
              </h5>
              <br>
              <div class="row-mb-2">
                <div class="col-12">
                  
                </div>
              </div>
              {{ $date_now }}
              <div id="time"></div>
            </div>
          </div>
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
        {{-- Left Row --}}
        <div class="row">
          <section class="col-lg-6 connectedSortable">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-file-alt"></i>
                  Legalitas Office
                </h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                <table id="tbl_legalitas" class="table table-hover table-bordered table-striped">
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
                          <td>
                            
                            <a href="{{ route('index_office_legalitas') }}">
                              {{ $item_legalitas->dokumen }}
                            </a>
                          </td>
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
          <section class="col-lg-6 connectedSortable">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-shopping-cart"></i>
                  Purchase Request
                </h3>
              </div>
              <div class="card-body">
                <table id="tbl_epurchase" class="table table-hover table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>PR Number</th>
                      <th>Requester</th>
                      <th>Desc</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach(Illuminate\Support\Facades\DB::table('pr')->where('pr_status','=','5')
                                                          ->join('employee','employee.id_employee','=','pr.id_employee')
                                                          ->join('users','users.id','=','employee.id_users')
                                                          ->orderBy('id_pr','DESC')->get() as $item_pr)
                        <tr>
                          <td>{{ $loop->iteration }}.</td>
                          <td>
                            <a href="{{ route('index_pr_admin') }}">
                              {{ $item_pr->pr_no }}
                            </a>
                          </td>
                          <td>{{ $item_pr->name }}</td>
                          <td>{{ $item_pr->pr_desc }}</td>
                          <td>
                            @if ($item_pr->pr_status == 5)
                                <p style="color: orange; font-weight: 900">Waiting Approval</p>
                            @else
                                <p style="color: orange; font-weight: 900">Approved</p>
                            @endif
                          </td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-cart-plus"></i>
                  Purchase Order
                </h3>
              </div>
              <div class="card-body">
                <table id="tbl_po" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>PO Number</th>
                      <th>Requester</th>
                      <th>Desc</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach(Illuminate\Support\Facades\DB::table('po')
                                                          ->join('pr','pr.pr_no','=','po.po_no')
                                                          ->join('employee','employee.id_employee','=','pr.id_employee')
                                                          ->join('users','users.id','=','employee.id_users')
                                                          ->where('po_status','=','3')
                                                          ->orWhere('po_status','=','2')
                                                          ->orderBy('id_po','DESC')->get() as $item_po)
                        <tr>
                          <td>{{ $loop->iteration }}.</td>
                          <td>
                            <a href="{{ route('index_po_admin') }}">
                              {{ $item_po->po_no }}
                            </a>
                          </td>
                          <td>{{ $item_po->name }}</td>
                          <td>{{ $item_po->pr_desc }}</td>
                          <td>
                            @if ($item_po->po_status == 3 || $item_po->po_status == 2)
                                <p style="color: orange; font-weight: 900">Waiting Approval</p>
                            @else
                                <p style="color: orange; font-weight: 900">Approved</p>
                            @endif
                          </td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </section>
        </div>
        {{-- End Left Row --}}
        {{-- Right Row --}}

        {{-- End Right Row --}}
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
      pageLength : 5,
      lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']],
      "responsive": true, "lengthChange": false, "autoWidth": false,
      
    }).buttons().container().appendTo('#tbl_legalitas_wrapper .col-md-6:eq(0)');
  });
  // Datatables
  $(function () {
    $("#tbl_epurchase").DataTable({
      
      "responsive": true, "lengthChange": false, "autoWidth": false,
      
    }).buttons().container().appendTo('#tbl_epurchase_wrapper .col-md-6:eq(0)');
  });
  // Datatables
  $(function () {
    $("#tbl_po").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      
    }).buttons().container().appendTo('#tbl_po_wrapper .col-md-6:eq(0)');
  });
</script>
<script type="text/javascript">
  function showTime() {
    var date = new Date(),
        utc = new Date(Date(
          date.getFullYear(),
          date.getMonth(),
          date.getDate(),
          date.getHours(),
          date.getMinutes(),
          date.getSeconds()
        ));

    document.getElementById('time').innerHTML = date.toLocaleTimeString('id', { timeZone: 'Asia/Jakarta' });
  }

  setInterval(showTime, 1000);
</script>