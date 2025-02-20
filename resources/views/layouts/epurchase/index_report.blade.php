@if (Auth::user()->user_level == '0')
    @include('admin.includes.header')
    @include('admin.includes.sidebar')
    
@elseif (Auth::user()->user_level == '1' )
    {{-- @include('dire.includes.header')
    @include('dire.includes.sidebar')
     --}}
@elseif (Auth::user()->user_level == '2' )    
    @include('manager.includes.header')
    @include('manager.includes.sidebar')
    
@elseif (Auth::user()->user_level == '3' )    
    @include('users.includes.header')
    @include('users.includes.sidebar')

@elseif (Auth::user()->user_level == '4' )
    @include('hr_ga.includes.header')
    @include('hr_ga.includes.sidebar')
@endif
    
{{-- Content --}}
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
              <li class="breadcrumb-item active">Report</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <h2 class="text-center display-5">Report  </h2>
                <h4 class="text-center display-5">Purchase Request & Order </h4>
                <br>
                <form id="form_search">
                  @csrf
                    <div class="row">
                        <div class="col-md-5 offset-md-1">
                            <div class="form-group">
                                <h5>Start Date :</h5>
                                <div class="input-group input-group-lg">
                                  <input type="text" class="form-control datetimepicker-input" id="txt_date_start" name="txt_date_start" data-toggle="datetimepicker" data-target="#txt_date_start" placeholder="YYYY/MM/DD" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 ">
                          <div class="form-group">
                              <h5>End Date :</h5>
                              <div class="input-group input-group-lg">
                                  {{-- <input type="date" name="txt_date_end" id="txt_date_end" class="form-control form-control-lg" placeholder="Type your keywords here" value="Lorem ipsum"> --}}
                                  <input type="text" class="form-control datetimepicker-input" id="txt_date_end" name="txt_date_end" data-toggle="datetimepicker" data-target="#txt_date_end" placeholder="YYYY/MM/DD" required/>
                              </div>
                          </div>
                        </div>
                        <div class="col-md-10 offset-md-1">
                          <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-default" id="getReport"  data-target="#show_report">
                              <i class="fa fa-search"> Search Report </i>
                            </button>
                            {{-- <button type="button" class="btn btn-block btn-outline-primary" title="Show Data" data-target="#show_report" id="getReport" data-url="{{ route('search_epurchase_admin_result')}}"><i class="fas fa-eye">&nbsp;View Data</i></button> --}}
                          </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="container-fluid" id="show_report">
              <div id="dynamic-content"></div>
            </div>
        </section>

        {{-- search result --}}
        <section class="content">
          
          
        </section>
</div>
@if (Auth::user()->user_level == '0')
    @include('admin.includes.footer')
@elseif (Auth::user()->user_level == '1' )
    {{-- @include('dire.includes.footer')  --}}
@elseif (Auth::user()->user_level == '2' )    
    @include('manager.includes.footer')
@elseif (Auth::user()->user_level == '3' )
    @include('users.includes.footer')
@elseif (Auth::user()->user_level == '4' )
    @include('hr_ga.includes.footer')
@endif
<script type="text/javascript">
  $(function () {
      $('#txt_date_end').datetimepicker({format: 'YYYY/MM/DD'});
      $('#txt_date_start').datetimepicker({format: 'YYYY/MM/DD'});
  });
</script>
<script>
  $(document).ready(function(){

      $(document).on('click', '#getReport', function(e){
  
          e.preventDefault();
  
          var url = '{{url("/EPurchase/Search/Submit")}}'
  
          $('#dynamic-content').html(''); // leave it blank before ajax call
          // $('#modal-loader').show();      // load ajax loader
  
          $.ajax({
              url: url,
              type: 'POST',
              data:$("#form_search").serialize(),
              headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
              },
          })
          .done(function(data){
              console.log(data);  
              $('#dynamic-content').html('');    
              $('#dynamic-content').html(data); // load response 
              // $('#modal-loader').hide();        // hide ajax loader   
          })
          .fail(function(){
              $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
              // $('#modal-loader').hide();
          });
  
      });

  });
</script>