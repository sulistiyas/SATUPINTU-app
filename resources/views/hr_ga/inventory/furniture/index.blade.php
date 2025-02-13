@include('hr_ga.includes.header')
@include('hr_ga.includes.sidebar')
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
                    <li class="breadcrumb-item active">Furniture</li>
                  </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Furniture Table</h3>
                            <button class="float-sm-right btn btn-primary" data-toggle="modal" data-target="#modal_furniture">
                                <i class="fas fa-plus">&nbsp;Add Data</i>
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="furniture_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Condition</th>
                                        <th>Location</th>
                                        <th>Images</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($furnitures as $furniture)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $furniture->item_name }}</td>
                                        <td>{{ $furniture->quantity }}</td>
                                        <td>{{ $furniture->condition }}</td>
                                        <td><img src="{{ Storage::url($furniture->furniture_image) }}" alt="" srcset="" width="100px" height="100px"> </td>
                                        <td>
                                            {{-- <button class="btn btn-warning" data-toggle="modal" data-target="#modal_edit_furniture" onclick="editFurniture({{ $furniture->id_furniture }})">
                                                <i class="fas fa-edit"></i>
                                            </button> --}}
                                            <div class="btn-group">
                                                
                                                <form onsubmit="return confirm('Apakah Anda Yakin ingin Menghapus data ?');" action="{{ route('destroy_furniture',[$furniture->id_furniture]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="javascript:void(0)" id="edit-data" data-url="{{ route('edit_furniture',$furniture->id_furniture) }}" class="btn bg-warning">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>&nbsp;&nbsp;
                                                    <input type="hidden" name="id" value="{{ $furniture->id_furniture }}">
                                                    
                                                    <button type="submit" class="btn bg-danger" title="Delete Furniture">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button> &nbsp;&nbsp; 
                                                    <a href="{{ route('generateQR') }}"  target="_blank" class="btn btn-info">
                                                        <i class="fas fa-qrcode"></i>
                                                    </a>
                                                </form>
                                                
                                            </div>
                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Condition</th>
                                        <th>Location</th>
                                        <th>Images</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
{{-- Modals --}}
<div class="modal fade" id="modal_furniture">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Furniture Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('store_furniture') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="item_name">Item Name</label>
                        <input type="text" name="item_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="condition">Condition</label>
                        <select name="condition" id="condition" class="form-control" required>
                            <option value="Good">Good</option>
                            <option value="Bad">Bad</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="furniture_image"> Furniture Image</label>
                        <input type="file" name="furniture_image" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Edit Modals --}}
<div class="modal fade" id="modal-edit-furniture">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Furniture Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('update_furniture') }}" method="POST" enctype="multipart/form-data" id="update_furniture" name="update_furniture">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_furniture" id="edit_id">
                    <div class="form-group">
                        <label for="item_name">Item Name</label>
                        <input type="text" name="item_name" id="edit_item_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" id="edit_quantity" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="condition">Condition</label>
                        <select name="condition" id="edit_condition" class="form-control" required>
                            @if ($furniture->condition == 'Good')
                                <option value="Good" selected>Good</option>
                                <option value="Bad">Bad</option>
                            @else
                                <option value="Good">Good</option>
                                <option value="Bad" selected>Bad</option>
                            @endif
                        </select>
                    </div>
                    
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Edit Modals --}}
@include('hr_ga.includes.footer')
<!-- dropzonejs -->
<script src="{{ asset('assets/plugins/dropzone/min/dropzone.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#furniture_table').DataTable();
    });

    $(document).ready(function () {
      /* When click show Client */
      $('body').on('click', '#edit-data', function () {
          var userURL = $(this).data('url');
          $.get(userURL, function (data) {
              $('#modal-edit-furniture').modal('show');
                $('#edit_id').val(data.id_furniture);
                $('#edit_item_name').val(data.item_name);
                $('#edit_quantity').val(data.quantity);
                $('#edit_condition').val(data.condition);
          })
      });

    });
  // DropzoneJS Demo Code Start
  Dropzone.autoDiscover = false

  // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
  var previewNode = document.querySelector("#template")
  previewNode.id = ""
  var previewTemplate = previewNode.parentNode.innerHTML
  previewNode.parentNode.removeChild(previewNode)

  var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
    url: "/target-url", // Set the url
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    parallelUploads: 20,
    previewTemplate: previewTemplate,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: "#previews", // Define the container to display the previews
    clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
  })

  myDropzone.on("addedfile", function(file) {
    // Hookup the start button
    file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
  })

  // Update the total progress bar
  myDropzone.on("totaluploadprogress", function(progress) {
    document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
  })

  myDropzone.on("sending", function(file) {
    // Show the total progress bar when upload starts
    document.querySelector("#total-progress").style.opacity = "1"
    // And disable the start button
    file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
  })

  // Hide the total progress bar when nothing's uploading anymore
  myDropzone.on("queuecomplete", function(progress) {
    document.querySelector("#total-progress").style.opacity = "0"
  })

  // Setup the buttons for all transfers
  // The "add files" button doesn't need to be setup because the config
  // `clickable` has already been specified.
  document.querySelector("#actions .start").onclick = function() {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
  }
  document.querySelector("#actions .cancel").onclick = function() {
    myDropzone.removeAllFiles(true)
  }
  // DropzoneJS Demo Code End
</script>