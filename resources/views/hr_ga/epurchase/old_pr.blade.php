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
                                        <th><i class="fas fa-cog"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($old_pr as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->pr_number }}</td>
                                        <td>{{ $item->date }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->po_number }}</td>
                                        <td>{{ $item->date_po }}</td>
                                        <td>
                                            @if ($item->po_number == null)
                                                {{-- <a href="javascript:void(0)" id="show-data-pr" data-url="{{ route('show_old_pr_only',$item->id_pr) }}" class="btn btn-primary" title="View Data"><i class="far fa-eye"></i></a> --}}
                                                <button type="button" class="btn btn-primary" title="View Data PR" data-toggle="modal" data-target="#modal-show-old-pr" id="getOldPR" data-url="{{ route('show_old_pr_only',['id'=>$item->pr_number])}}"><i class="far fa-eye"></i></button>&nbsp;
                                            @else
                                                {{-- <a href="javascript:void(0)" id="show-data" data-url="{{ route('show_old_prpo',$item->id_pr) }}" class="btn btn-primary" title="View Data All"><i class="far fa-eye"></i></a> --}}
                                                <button type="button" class="btn btn-primary" title="View Data All" data-toggle="modal" data-target="#modal-show-old-pr-po" id="getOldPRPO" data-url="{{ route('show_old_prpo',['id'=>$item->pr_number])}}"><i class="far fa-eye"></i></button>&nbsp;
                                            @endif
                                            
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
    {{-- Show Modal PR PO--}}
    <div class="modal fade" id="modal-show-old-pr-po">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="overlay" id="modal-loader">
            <i class="fas fa-2x fa-sync fa-spin"></i>
          </div>
          <div class="modal-header">
              <h4 class="modal-title">Detail PR PO</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
             <div id="dynamic-content"></div>
             
          </div>
          <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    {{-- End Modal PR PO --}}
    {{-- Show Modal PR Only--}}
    <div class="modal fade" id="modal-show-old-pr">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="overlay" id="modal-loader-2">
            <i class="fas fa-2x fa-sync fa-spin"></i>
          </div>
          <div class="modal-header">
              <h4 class="modal-title">Detail PR</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
             <div id="dynamic-content-2"></div>
             
          </div>
          <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    {{-- End Modal PR Only --}}
    
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
  $(function() {
    //   $('#tbl_old_pr').DataTable({
    //       processing: true,
    //       serverSide: true,
    //       ajax: '{!! route('get_old_pr_hr_ga') !!}',
    //       columns: [{ 
    //               data: 'id_pr',
    //               name: 'id_pr'
    //           },
    //           {
    //               data: 'pr_number',
    //               name: 'pr_number'
    //           },
    //           {
    //               data: 'date',
    //               name: 'date'
    //           },
    //           {
    //               data: 'description',
    //               name: 'description'
    //           },
    //           {
    //               data: 'po_number',
    //               name: 'po_number'
    //           },
    //           {
    //               data: 'date_po',
    //               name: 'date_po'
    //           },
    //           {
    //             data: 'action',
    //             name: 'action',
                  
    //           }
    //       ]
    //   });

    $(function () {
      $("#tbl_old_pr").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#tbl_vendor_wrapper .col-md-6:eq(0)');
    });
  });
        //   Old PR PO Modal
        $(document).ready(function(){
            $(document).on('click', '#getOldPRPO', function(e){
                e.preventDefault();
                var url = $(this).data('url');
                $('#dynamic-content').html(''); // leave it blank before ajax call
                $('#modal-loader').show();      // load ajax loader
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'html'
                })
                .done(function(data){
                    console.log(data);  
                    $('#dynamic-content').html('');    
                    $('#dynamic-content').html(data); // load response 
                    $('#modal-loader').hide();        // hide ajax loader   
                })
                .fail(function(){
                    $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                    $('#modal-loader').hide();
                });    
            });
            // Old PR Only Modal
            $(document).on('click', '#getOldPR', function(e){
                e.preventDefault();
                var url = $(this).data('url');
                $('#dynamic-content-2').html(''); // leave it blank before ajax call
                $('#modal-loader-2').show();      // load ajax loader
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'html'
                })
                .done(function(data){
                    console.log(data);  
                    $('#dynamic-content-2').html('');    
                    $('#dynamic-content-2').html(data); // load response 
                    $('#modal-loader-2').hide();        // hide ajax loader   
                })
                .fail(function(){
                    $('#dynamic-content-2').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                    $('#modal-loader-2').hide();
                });    
            });
        });
</script>