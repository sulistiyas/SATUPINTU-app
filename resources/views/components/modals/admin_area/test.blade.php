@foreach ($latest_number as $item)
<label for="txt_nomor_urut">Last Number</label>
<input type="number" name="txt_nomor_urut" id="txt_nomor_urut" class="form-control" value="{{ old('latest_number',$item->nomor_urut + 1)}}" readonly required>
@endforeach