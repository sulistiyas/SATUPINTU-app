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
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Letter Number 2019</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
  </div>
  <section class="content">
      <div class="container-fluid">
          <div class="row">
              <div class="col-12">
                  <div class="card">
                      <div class="card-header">
                          <h3 class="card-title">Letter Number Data 2019</h3>
                      </div>
                      <div class="card-body">
                          <table id="tbl_letter_number" class="table table-bordered table-striped">
                              <thead>
                                  <tr>
                                      <th>No.</th>
                                      <th>Letter Number</th>
                                      <th>Company</th>
                                      <th>User</th>
                                      <th>Created</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($letter_number as $item_letter_number)
                                      <tr>
                                          <td>{{ $loop->iteration }}</td>
                                          <td>{{ $item_letter_number->nomor_surat }}</td>
                                          <td>{{ $item_letter_number->nama_perusahaan }}</td>
                                          <td>{{ $item_letter_number->username }}</td>
                                          <td>{{ $item_letter_number->log_date }}</td>
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
</div>

{{-- End Content --}}
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
<script>
    // Datatables
    $(function () {
      $("#tbl_letter_number").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#tbl_legalitas_wrapper .col-md-6:eq(0)');
    });
</script>