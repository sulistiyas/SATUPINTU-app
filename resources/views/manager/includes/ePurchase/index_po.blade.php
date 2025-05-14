@include('manager.includes.header')
@include('manager.includes.sidebar')
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
                          <form onsubmit="return confirm('Are you sure you want to APPROVE this request ?');" action="{{ route('approve_po_manager_checkbox') }}" method="POST">
                            @csrf
                            {{-- <input type="hidden" name="total_data" id="total_data" value="{{ $count_data }}"> --}}
                            <table id="tbl_po" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>PR Number</th>
                                        <th>PO Number</th>
                                        <th>Status</th>
                                        <th><i class="fas fa-cog"></i></th>
                                    </tr>
                                    <tr>
                                      @foreach ($data as $item_pr_top)
                                      @endforeach
                                      <th colspan="4">
                                        <div class="icheck-primary d-inline">
                                          <input type="checkbox" id="checkAll" name="checkAll" class="item-checkbox" onclick="toogleAllCheckbox()">
                                          <label for="checkAll">
                                            Select All
                                          </label>
                                        </div>
                                      </th>
                                      <th>
                                        <button type="submit" name="btn_approval" id="btn_approval" value="approve_pr" class="btn bg-success" title="Approve PO"><i class="fas fa-check"></i>&nbsp; Approve Checked</button>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <button type="submit" name="btn_approval" id="btn_approval" value="reject_pr" class="btn bg-danger" title="Reject PO"><i class="fas fa-times"></i>&nbsp; Reject Checked</button>&nbsp;&nbsp;&nbsp;&nbsp;      
                                      </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item_pr)
                                        <tr>
                                          <td>
                                            {{ $loop->iteration }}
                                            @if ( $item_pr->po_status  == 2)
                                              <div class="icheck-primary d-inline">
                                                <input type="checkbox" id="ck_po_no_{{ $loop->iteration }}" name="ck_po_no[]" value="{{ $item_pr->po_no }}" class="item-checkbox" onclick="toogleSingleCheckbox()">
                                                <label for="ck_po_no_{{ $loop->iteration }}">
                                                </label>
                                              </div>
                                            @else
                                            @endif
                                          </td>
                                          <td><b>{{ $item_pr->pr_no_1 }}</b></td>
                                          <td>
                                            @if ($item_pr->po_no == "")
                                                <p style="color: gray">PO Empty</p>
                                            @else
                                                <p style="color: rgb(0, 0, 238)"><b>{{ $item_pr->po_no }}</b></p>
                                            @endif
                                          </td>
                                          <td>
                                            @if ( $item_pr->pr_status  == 5)
                                              Waiting Manager Approval
                                            @elseif ( $item_pr->pr_status == 4)
                                              PR Approved
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
                                                  <div class="col-12">
                                                    <button type="button" class="btn btn-outline-primary" title="Show Data" data-toggle="modal" data-target="#modal_pr_show_manager" id="getPR" data-url="{{ route('show_modal_pr_manager',['id'=>$item_pr->pr_no_1])}}"><i class="fas fa-eye">&nbsp;View Data</i></button>
                                                  </div>
                                                @elseif ($item_pr->pr_status  == 4)
                                                  <div class="col-7">
                                                    <button type="button" class="btn btn-outline-primary" title="Show Data" data-toggle="modal" data-target="#modal_pr_show_manager" id="getPR" data-url="{{ route('show_modal_pr_manager',['id'=>$item_pr->pr_no_1])}}"><i class="fas fa-eye">&nbsp;View Data</i></button>
                                                  </div>
                                                  <div class="col-6">
                                                    <form action="{{ route('print_pr_manager') }}" method="POST">
                                                      @csrf
                                                      <input type="hidden" name="txt_pr_no" id="txt_pr_no" value="{{ $item_pr->pr_no }}">
                                                      <button type="submit" class="btn btn-outline-success" id="print_pr"><i class="fas fa-print">&nbsp;Print PR</i></button>
                                                    </form>
                                                  </div>
                                                @elseif ( $item_pr->pr_status  == 3)
                                                  <div class="col-7">
                                                    <button type="button" class="btn btn-outline-primary" title="Show Data" data-toggle="modal" data-target="#modal_show_price_manager" id="getPOPrice" data-url="{{ route('show_modal_po_price_manager',['id'=>$item_pr->po_no])}}"><i class="fas fa-eye">&nbsp;View Data</i></button>
                                                  </div>
                                                  <div class="col-6">
                                                    <form action="{{ route('print_pr_manager') }}" method="POST">
                                                      @csrf
                                                      <input type="hidden" name="txt_pr_no" id="txt_pr_no" value="{{ $item_pr->pr_no }}">
                                                      <button type="submit" class="btn btn-outline-success" id="print_pr"><i class="fas fa-print">&nbsp;Print PR</i></button>
                                                    </form>
                                                  </div>
                                                @elseif ( $item_pr->pr_status == 2)
                                                  <div class="col-5">
                                                    <button type="button" class="btn btn-outline-primary" title="Show Data" data-toggle="modal" data-target="#modal_show_price_manager_comp" id="getPOPrice_comp" data-url="{{ route('show_modal_po_price_manager_comp',['id'=>$item_pr->po_no])}}"><i class="fas fa-eye">&nbsp;View Data</i></button>
                                                  </div>
                                                  <div class="col-5">
                                                    <form onsubmit="return confirm('Are you sure you want to APPROVE this request ?');" action="{{ route('approve_po_manager') }}" method="POST">
                                                      @csrf
                                                        <input type="hidden" name="txt_po_no" id="txt_po_no" value="{{ $item_pr->po_no }}" readonly>
                                                        <input type="hidden" name="txt_pr_no" id="txt_pr_no" value="{{ $item_pr->pr_no }}" readonly>
                                                        <button type="submit" name="btn_approval" id="btn_approval" value="approve_po" class="btn btn-outline-success" title="Approve PO"><i class="fas fa-check"></i>&nbsp; Approve</i></button>
                                                    </form>
                                                  </div>
                                                  <div class="col-4">
                                                    <form onsubmit="return confirm('Are you sure you want to REJECT this request ?');" action="{{ route('approve_po_manager') }}" method="POST">
                                                      @csrf
                                                          <input type="hidden" name="txt_po_no" id="txt_po_no" value="{{ $item_pr->po_no }}" readonly>
                                                          <input type="hidden" name="txt_pr_no" id="txt_pr_no" value="{{ $item_pr->pr_no }}" readonly>
                                                          <button type="submit" name="btn_approval" id="btn_approval" value="reject_po" class="btn btn-outline-danger" title="Reject PO"><i class="fas fa-times">&nbsp; Reject</i></button>
                                                    </form>
                                                  </div>
                                                @elseif ( $item_pr->pr_status == 1)
                                                  <div class="col-7">
                                                    <button type="button" class="btn btn-outline-primary" title="Show Data" data-toggle="modal" data-target="#modal_pr_show_manager" id="getPR" data-url="{{ route('show_modal_pr_manager',['id'=>$item_pr->pr_no_1])}}"><i class="fas fa-eye">&nbsp;View Data</i></button>
                                                  </div>
                                                  <div class="col-6">
                                                    <form action="{{ route('print_po_manager') }}" method="POST">
                                                      @csrf
                                                      <input type="hidden" name="txt_po_no" id="txt_po_no" value="{{ $item_pr->po_no }}">
                                                      <button type="submit" class="btn btn-block btn-outline-success" title="Print PO"><i class="fas fa-print">&nbsp;Print PO</i></button>
                                                    </form>
                                                  </div>
                                                @else
                                                  <div class="col-12">
                                                    <button type="button" class="btn btn-outline-primary" title="Show Data" data-toggle="modal" data-target="#modal_pr_show_manager" id="getPR" data-url="{{ route('show_modal_pr_manager',['id'=>$item_pr->pr_no_1])}}"><i class="fas fa-eye">&nbsp;View Data</i></button>
                                                  </div>
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
    <form action="{{ route('store_po_admin') }}" method="POST" enctype="multipart/form-data" id="po" name="po">
      @csrf
      <div class="modal fade" id="modal_po_add">
          <div class="modal-dialog modal-lg">
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
                  <table class="table">
                    <tr>
                      <th><Label for="txt_disc">Discount</Label></th>
                      <th><input type="number" name="txt_disc" id="txt_disc" required class="form-control"></th>
                    </tr>
                    <tr>
                      <th><label for="txt_tax">Tax</label></th>
                      <th>
                        <div class="custom-control custom-radio">
                          <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="radio" id="txt_tax" name="txt_tax" value="11">
                          <label for="txt_tax" class="custom-control-label">Ppn</label>
                        </div>
                        <div class="custom-control custom-radio">
                          <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="radio" id="txt_tax_1" name="txt_tax" value="0" checked>
                          <label for="txt_tax_1" class="custom-control-label">No Ppn</label>
                        </div>
                      </th>
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
    {{-- @include('components.modals.pr_admin_show',['pr_data' => $item_pr->pr_no]) --}}
    <div class="modal fade" id="modal_pr_show_manager">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="overlay" id="modal-loader">
            <i class="fas fa-2x fa-sync fa-spin"></i>
          </div>
          <div class="modal-header">
              <h4 class="modal-title">PO Detail</h4>
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
    {{-- Modal Price --}}
    <div class="modal fade" id="modal_show_price_manager">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="overlay" id="modal-loader_1">
            <i class="fas fa-2x fa-sync fa-spin"></i>
          </div>
          <div class="modal-header">
              <h4 class="modal-title">PO Detail</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
             <div id="dynamic-content_1"></div>
             
          </div>
          <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    
    {{-- Modal Price Complete --}}
    <div class="modal fade" id="modal_show_price_manager_comp">
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
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
</div>
@include('manager.includes.footer')
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
  
        $(document).on('click', '#getPOPrice', function(e){
    
            e.preventDefault();
    
            var url = $(this).data('url');
    
            $('#dynamic-content_1').html(''); // leave it blank before ajax call
            $('#modal-loader_1').show();      // load ajax loader
    
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'html'
            })
            .done(function(data){
                console.log(data);  
                $('#dynamic-content_1').html('');    
                $('#dynamic-content_1').html(data); // load response 
                $('#modal-loader_1').hide();        // hide ajax loader   
            })
            .fail(function(){
                $('#dynamic-content_1').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                $('#modal-loader_1').hide();
            });
    
        });
  
    });
</script>
<script>
  $(document).ready(function(){

      $(document).on('click', '#getPOPrice_comp', function(e){
  
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
  function toogleAllCheckbox() {
    var checkboxes = document.querySelectorAll(".item-checkbox");
    var total_datas = document.querySelectorAll(".item-checkbox").length;
    
    for (var checkbox of checkboxes) {
      if (document.getElementById("checkAll").checked == true) {
        checkbox.checked = true;
      } else if(document.getElementById("checkAll").checked == false){
        checkbox.checked = false;
      }
      
    }
  }
</script>