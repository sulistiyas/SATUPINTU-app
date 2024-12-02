@include('users.includes.header')
@include('users.includes.sidebar')
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
        </div>
    </section>
</div>
@include('users.includes.footer')
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