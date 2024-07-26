<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@foreach ($data_legalitas as $item_legalitas)
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="txt_no_legalitas">Nomor</label>
                <input type="text" name="txt_no_legalitas" id="txt_no_legalitas" class="form-control" value="{{old('no_legalitas', $item_legalitas->no_legalitas)}}" required>
                <input type="hidden" name="txt_id_legalitas" id="txt_id_legalitas" class="form-control" value="{{old('id_legalitas', $item_legalitas->id_legalitas)}}" required>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="txt_dokumen">Dokumen</label>
                <input type="text" name="txt_dokumen" id="txt_dokumen" class="form-control" value="{{old('dokumen', $item_legalitas->dokumen)}}" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="txt_comp"> Company </label>
                <select name="txt_comp" id="txt_comp" class="form-control select2bs4">
                    <option value="PT. Inlingua International Indonesia" {{$item_legalitas->nama_perusahaan == "PT. Inlingua International Indonesia"  ? 'selected' : ''}}>PT. Inlingua International Indonesia</option>
                    <option value="PT. i-Link" {{$item_legalitas->nama_perusahaan == "PT. i-Link"  ? 'selected' : ''}}>PT. i-Link</option>
                    <option value="PT. Jakarta International College (JIC)" {{$item_legalitas->nama_perusahaan == "PT. Jakarta International College (JIC)"  ? 'selected' : ''}}>PT. Jakarta International College (JIC)</option>
                    <option value="PT. Multi Sarana Edukasi (MSE)" {{$item_legalitas->nama_perusahaan == "PT. Multi Sarana Edukasi (MSE)"  ? 'selected' : ''}}>PT. Multi Sarana Edukasi (MSE)</option>
                    <option value="PT. Sinergy Informasi Pratama (SIP)" {{$item_legalitas->nama_perusahaan == "PT. Sinergy Informasi Pratama (SIP)"  ? 'selected' : ''}}>PT. Sinergy Informasi Pratama (SIP)</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <label for="txt_issued">Issued</label>
            <div class="input-group input-group-lg">
                <input type="date" class="form-control datetimepicker-input" id="txt_issued" name="txt_issued" data-toggle="datetimepicker" data-target="#txt_issued" placeholder="YYYY/MM/DD" value="{{old('terbit', $item_legalitas->terbit)}}" required/>
            </div>
        </div>
        <div class="col-6">
            <label for="txt_expiry">Expiry</label>
            <div class="input-group input-group-lg">
                <input type="date" class="form-control datetimepicker-input" id="txt_expiry" name="txt_expiry" data-toggle="datetimepicker" data-target="#txt_expiry" placeholder="YYYY/MM/DD" value="{{old('berakhir', $item_legalitas->berakhir)}}" required/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <label for="txt_status">Status</label>
            <select name="txt_status" id="txt_status" class="form-control select2bs4">
                <option value="1" {{$item_legalitas->status == "1"  ? 'selected' : ''}}>Ok</option>
                <option value="2" {{$item_legalitas->status == "2"  ? 'selected' : ''}}>Proses</option>
                <option value="3" {{$item_legalitas->status == "3"  ? 'selected' : ''}}>Expired</option>
                <option value="4" {{$item_legalitas->status == "4"  ? 'selected' : ''}}>Not Used</option>
            </select>
        </div>
    </div>
@endforeach
<!-- Select2 -->
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()
      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })
      })
</script>
