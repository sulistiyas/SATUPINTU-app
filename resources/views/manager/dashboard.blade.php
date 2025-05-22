@include('manager.includes.header')
@include('manager.includes.sidebar')
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
        <div class="row">
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
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
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
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@include('manager.includes.footer')
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