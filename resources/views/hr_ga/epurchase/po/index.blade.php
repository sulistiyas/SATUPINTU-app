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
              <li class="breadcrumb-item active">PO Table</li>
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
                            <table id="tbl_po" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>PR Number</th>
                                        <th>PO Number</th>
                                        <th>Status</th>
                                        <th><i class="fas fa-cog"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item_pr)
                                        <tr>
                                          <td>{{ $loop->iteration }}</td>
                                          <td>{{ $item_pr->pr_no_1 }}</td>
                                          <td>
                                            @if ($item_pr->po_no == "")
                                                <p style="color: gray">PO Empty</p>
                                            @else
                                                {{ $item_pr->po_no }}
                                            @endif
                                          </td>
                                          <td>
                                            @if ( $item_pr->pr_status  == 5)
                                              Waiting Manager/HR-GA Approval
                                            @elseif ( $item_pr->pr_status == 4)
                                              PR Approved - Please Add Price
                                            @elseif ( $item_pr->pr_status == 3)
                                              PR Approved - PO Submitting
                                            @elseif ( $item_pr->pr_status == 2)
                                              PR Approved - PO Submitting
                                            @elseif ( $item_pr->pr_status == 1)
                                              PR PO Completed
                                            @elseif ( $item_pr->pr_status == 6)
                                              PR Rejected
                                            @elseif ( $item_pr->pr_status == 7)
                                              PO Rejected
                                            @endif
                                          </td>
                                          <td>
                                            <div class="btn-group">
                                                
                                                @if ( $item_pr->pr_status  == 5)
                                                  
                                                    <button type="button" class="btn bg-info" title="Show Detail" data-toggle="modal" data-target="#modal_pr_show_hr_ga" id="getPR" data-url="{{ route('show_modal_pr_hr_ga',['id'=>$item_pr->pr_no_1])}}"><i class="far fa-eye"></i></button>&nbsp;
                                                    <button class="btn bg-secondary toastrDefaultError" title="Print PR"><i class="fas fa-print"></i></i></button>&nbsp;
                                                  
                                                @elseif ($item_pr->pr_status  == 4)
                                                  
                                                    <button type="button" class="btn bg-success" title="Add Price" data-toggle="modal" data-target="#modal_price_add" id="getPrice" data-url="{{ route('show_modal_price_hr_ga',['id'=>$item_pr->pr_no_1])}}"><i class="fas fa-plus"></i> Price</button>&nbsp;
                                                    <button type="button" class="btn bg-info" title="Show Detail" data-toggle="modal" data-target="#modal_pr_show_hr_ga" id="getPR" data-url="{{ route('show_modal_pr_hr_ga',['id'=>$item_pr->pr_no_1])}}"><i class="far fa-eye"></i></button>&nbsp;
                                                    <form action="{{ route('print_pr_hr_ga') }}" method="POST">
                                                      @csrf
                                                      <input type="hidden" name="txt_pr_no" id="txt_pr_no" value="{{ $item_pr->pr_no_1 }}">
                                                      <button type="submit" id="print_pr" class="btn bg-secondary" title="Print PR"><i class="fas fa-print"></i></i></button>&nbsp;
                                                    </form>
                                                  
                                                @endif
                                                @if ( $item_pr->pr_status  == 3)
                                                  {{-- <div class="col-7">
                                                    <button type="button" class="btn btn-block btn-outline-primary" title="Show Data" data-toggle="modal" data-target="#modal_po_show_hr_ga" id="showPO" data-url="{{ route('show_modal_po_hr_ga',['id'=>$item_pr->po_no])}}"><i class="fas fa-eye">&nbsp;View Data</i></button>
                                                  </div>
                                                  <div class="col-8">
                                                    <button type="button" class="btn btn-block btn-outline-success" title="Add PO" data-toggle="modal" data-target="#modal_po_add" id="getPO" data-url="{{ route('show_modal_create_po_hr_ga',['id'=>$item_pr->po_no])}}"><i class="fas fa-plus">&nbsp;Submit PO</i></button>
                                                  </div> --}}
                                                  
                                                    <button type="button" class="btn bg-success" title="Add PO" data-toggle="modal" data-target="#modal_po_add" id="getPO" data-url="{{ route('show_modal_create_po_hr_ga',['id'=>$item_pr->po_no])}}"><i class="fas fa-plus"></i> PO</button>&nbsp;
                                                    <button type="button" class="btn bg-info" title="Show Detail" data-toggle="modal" data-target="#modal_po_show_hr_ga_po" id="showPO" data-url="{{ route('show_modal_po_hr_ga',['id'=>$item_pr->po_no])}}"><i class="far fa-eye"></i></button>&nbsp;
                                                    <form action="{{ route('print_pr_hr_ga') }}" method="POST">
                                                      @csrf
                                                      <input type="hidden" name="txt_pr_no" id="txt_pr_no" value="{{ $item_pr->pr_no_1 }}">
                                                      <button type="submit" id="print_pr" class="btn bg-secondary" title="Print PR"><i class="fas fa-print"></i></i></button>&nbsp;
                                                    </form>
                                                  
                                                @elseif ( $item_pr->pr_status == 2)
                                                  
                                                    <button type="button" class="btn bg-info" title="Show Detail" data-toggle="modal" data-target="#modal_po_show_hr_ga_po" id="showPO" data-url="{{ route('show_modal_po_hr_ga',['id'=>$item_pr->po_no])}}"><i class="far fa-eye"></i></button>&nbsp;
                                                    <button class="btn bg-secondary toastrDefaultError2" title="Print PO"><i class="fas fa-print"></i></i></button>&nbsp;
                                                    {{-- <button type="button" class="btn btn-block btn-outline-primary" title="Show Data" data-toggle="modal" data-target="#modal_po_show_hr_ga" id="showPO" data-url="{{ route('show_modal_po_hr_ga',['id'=>$item_pr->po_no])}}"><i class="fas fa-eye">&nbsp;View Data</i></button> --}}
                                                  
                                                @elseif ( $item_pr->pr_status == 1)
                                                  
                                                    <form action="{{ route('print_po_hr_ga') }}" method="POST">
                                                      @csrf
                                                      <input type="hidden" name="txt_po_no" id="txt_po_no" value="{{ $item_pr->po_no }}">
                                                      <button type="submit" class="btn btn-block btn-outline-success" title="Print PO"><i class="fas fa-print">&nbsp;Print PO</i></button>
                                                    </form>
                                                  
                                                @elseif( $item_pr->pr_status == 6)
                                                  
                                                    <button type="button" class="btn bg-info" title="Show Detail" data-toggle="modal" data-target="#modal_pr_show_hr_ga" id="getPR" data-url="{{ route('show_modal_pr_hr_ga',['id'=>$item_pr->pr_no_1])}}"><i class="far fa-eye"></i></button>&nbsp;
                                                  
                                                  {{-- <button class="btn bg-secondary toastrDefaultError" title="Print PR"><i class="fas fa-print"></i></i></button>&nbsp; --}}
                                                @endif
                                                
                                            </div>
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
    <!-- /.content -->
    {{-- End Content --}}
    {{-- Create Modal --}}
    <form action="{{ route('store_price_hr_ga') }}" method="POST" enctype="multipart/form-data" id="pr" name="pr">
        @csrf
          <div class="modal fade" id="modal_price_add">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="overlay" id="modal-loader_2">
                  <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
                <div class="modal-header">
                    <h4 class="modal-title">PO Detail</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   <div id="dynamic-content_2"></div>
                </div>
                <div class="modal-footer justify-content-between">
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-warning" data-dismiss="modal">Close</button>&nbsp;
                        <button type="submit" class="btn btn-outline-primary">Submit</button>
                    </div>
                </div>
              </div>
            </div>
          </div>
    </form>
    {{-- End Create --}}
    {{-- Create Modal --}}
    <form action="{{ route('store_po_hr_ga') }}" method="POST" enctype="multipart/form-data" id="po" name="po">
      @csrf
      <div class="modal fade" id="modal_po_add">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="overlay" id="modal-loader_3">
                <i class="fas fa-2x fa-sync fa-spin"></i>
              </div>
              <div class="modal-header">
                  <h4 class="modal-title">PO Detail</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <div id="dynamic-content_3"></div>
                  <br>
                  <table class="table">
                    <tr>
                      <th><label for="txt_tax">Tax</label></th>
                      <th>
                        <div class="custom-control custom-radio">
                          <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="radio" id="txt_tax" name="txt_tax" value="11">
                          <label for="txt_tax" class="custom-control-label">11% Ppn</label>
                        </div>
                        <div class="custom-control custom-radio">
                          <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="radio" id="txt_tax_1" name="txt_tax" value="10">
                          <label for="txt_tax_1" class="custom-control-label">10% Ppn</label>
                        </div>
                        <div class="custom-control custom-radio">
                          <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="radio" id="txt_tax_2" name="txt_tax" value="0" checked>
                          <label for="txt_tax_2" class="custom-control-label">No Ppn</label>
                        </div>
                      </th>
                      <th><Label for="txt_disc">Discount</Label></th>
                      <th><input type="number" name="txt_disc" id="txt_disc" class="form-control"></th>
                    </tr>
                    <tr>
                      <th><Label for="txt_service_charge">Service Charge</Label></th>
                      <th><input type="number" name="txt_service_charge" id="txt_service_charge" class="form-control" placeholder="Optional"></th>
                      <th><Label for="txt_delivery_fee">Delivery Charge</Label></th>
                      <th><input type="number" name="txt_delivery_fee" id="txt_delivery_fee" class="form-control" placeholder="Optional"></th>
                      <th><Label for="txt_delivery_fee">Additional Charge</Label></th>
                      <th><input type="number" name="txt_adds_charge" id="txt_adds_charge" class="form-control" placeholder="Optional"></th>
                    </tr>
                  </table>
              </div>
              <div class="modal-footer justify-content-between">
                  <div class="btn-group">
                      <button type="button" class="btn btn-outline-warning" data-dismiss="modal">Close</button>&nbsp;
                      <button type="submit" class="btn btn-outline-primary">Submit</button>
                  </div>
              </div>
            </div>
          </div>
        </div>
    </form>
  {{-- End Create --}}
    {{-- View Modal --}}
    {{-- @include('components.modals.pr_hr_ga_show',['pr_data' => $item_pr->pr_no]) --}}
    <div class="modal fade" id="modal_pr_show_hr_ga">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="overlay" id="modal-loader">
            <i class="fas fa-2x fa-sync fa-spin"></i>
          </div>
          <div class="modal-header">
              <h4 class="modal-title">PR Detail</h4>
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
    {{-- End View --}}
    {{-- Modal Show PO --}}
    <div class="modal fade" id="modal_po_show_hr_ga_po">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="overlay" id="modal-loader_4">
            <i class="fas fa-2x fa-sync fa-spin"></i>
          </div>
          <div class="modal-header">
              <h4 class="modal-title">PO Detail</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
             <div id="dynamic-content_4"></div>
             
          </div>
          <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
</div>
@include('hr_ga.includes.footer')
<script>
    // Datatables
    $(function () {
      $("#tbl_po").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#tbl_po_wrapper .col-md-6:eq(0)');
    });
</script>
<script>
    $(document).ready(function(){
  
        $(document).on('click', '#getPR', function(e){
    
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
  
    });
</script>
{{-- Price --}}
<script>
    $(document).ready(function(){
  
        $(document).on('click', '#getPrice', function(e){
    
            e.preventDefault();
    
            var url = $(this).data('url');
    
            $('#dynamic-content_2').html(''); // leave it blank before ajax call
            $('#modal-loader_2').show();      // load ajax loader
    
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'html'
            })
            .done(function(data){
                console.log(data);  
                $('#dynamic-content_2').html('');    
                $('#dynamic-content_2').html(data); // load response 
                $('#modal-loader_2').hide();        // hide ajax loader   
            })
            .fail(function(){
                $('#dynamic-content_2').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                $('#modal-loader_2').hide();
            });
    
        });
  
    });
</script>
{{-- PO --}}
<script>
  $(document).ready(function(){

      $(document).on('click', '#getPO', function(e){
  
          e.preventDefault();
  
          var url = $(this).data('url');
  
          $('#dynamic-content_3').html(''); // leave it blank before ajax call
          $('#modal-loader_3').show();      // load ajax loader
  
          $.ajax({
              url: url,
              type: 'GET',
              dataType: 'html'
          })
          .done(function(data){
              console.log(data);  
              $('#dynamic-content_3').html('');    
              $('#dynamic-content_3').html(data); // load response 
              $('#modal-loader_3').hide();        // hide ajax loader   
          })
          .fail(function(){
              $('#dynamic-content_3').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
              $('#modal-loader_3').hide();
          });
  
      });

  });
</script>
<script>
  $(document).ready(function(){

      $(document).on('click', '#showPO', function(e){
  
          e.preventDefault();
  
          var url = $(this).data('url');
  
          $('#dynamic-content_4').html(''); // leave it blank before ajax call
          $('#modal-loader_4').show();      // load ajax loader
  
          $.ajax({
              url: url,
              type: 'GET',
              dataType: 'html'
          })
          .done(function(data){
              console.log(data);  
              $('#dynamic-content_4').html('');    
              $('#dynamic-content_4').html(data); // load response 
              $('#modal-loader_4').hide();        // hide ajax loader   
          })
          .fail(function(){
              $('#dynamic-content_4').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
              $('#modal-loader_4').hide();
          });
  
      });

  });
</script>
<!-- SweetAlert2 -->
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Toastr -->
<script src="{{ asset('assets/plugins/toastr/toastr.min.js')}}"></script>
<script>
  $(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    $('.toastrDefaultError').click(function() {
      toastr.error('PR NOT APPROVED by MANAGER or GA.')
    });
    $('.toastrDefaultError2').click(function() {
      toastr.error('PO NOT APPROVED by MANAGER.')
    });
  });
</script>