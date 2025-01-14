
<div class="row">
    <div class="col-5">
        <div class="form-group" id="letter">
            <label for="txt_nomor_urut">Number</label>
            <input type="number" name="txt_nomor_urut" id="txt_nomor_urut" class="form-control" value="{{ old('latest_number',$latest_number)}}" readonly required>
        </div>
    </div>
    <div class="col-1">
        <div class="form-group">
            <label for="refresh_number" style="color: transparent">T</label><br>
            <button type="button" class="btn btn-outline-primary" title="Refresh Data" id="refresh_number" data-url="{{ route('refresh_last_number')}}">
                <i class="fas fa-sync"></i>
            </button>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="txt_comp">Company</label>
            <input type="text" name="txt_comp" id="txt_comp" class="form-control" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label for="txt_type">Type</label>
            <select name="txt_type" id="txt_type" class="form-control select2bs4">
                <option value="0" disabled>- Type -</option>
                <option value="LO">LO</option>
                <option value="Prop">Prop</option>
                <option value="Quo">Quo</option>
            </select>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="txt_form">From</label>
            <select name="txt_form" id="txt_form" class="form-control select2bs4">
                <option value="0" disabled>- From -</option>
                <option value="INL">INL</option>
                <option value="WSCC">WSCC</option>
                <option value="i-Link">i-Link</option>
                <option value="K.JIHEC.III">K.JIHEC.III</option>
            </select>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
  
        $(document).on('click', '#refresh_number', function(e){
    
            e.preventDefault();
    
            var url = $(this).data('url');
    
            $('#letter').html(''); // leave it blank before ajax call
            // $('#modal-loader').show();      // load ajax loader
    
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'html'
            })
            .done(function(data){
                console.log(data);  
                $('#letter').html('');    
                $('#letter').html(data); // load response 
                // $('#modal-loader').hide();        // hide ajax loader   
            })
            .fail(function(){
                $('#letter').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                // $('#modal-loader').hide();
            });
    
        });
  
    });
</script>