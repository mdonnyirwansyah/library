<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="kode">Kode Peminjaman</label>
    <div class="col-sm-12 col-md-7">
        <input type="text" class="form-control" name="kode" id="kode" @isset($pengembalian) value="{{ $pengembalian->kode }}" readonly @endisset />
        <small class="invalid-feedback kode_err"></small><small class="valid-feedback kode_valid"></small>
    </div>
</div>

<div id="view-form-buku" style="display: none"></div>
@isset($pengembalian)
<input type="hidden" name="peminjaman_id" value="{{ $pengembalian->peminjaman_id }}">
@foreach ($pengembalian->buku as $item)
<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ $item->judul }}</label>
    <input type="hidden" name="pengembalian[buku][{{ $item->id }}][id]" value="{{ $item->id }}">
    <div class="col-sm-12 col-md-7">
        <div class="custom-control custom-radio custom-control-inline mt-1">
            <input type="radio" id="{{ $item->judul.'1' }}" name="pengembalian[buku][{{ $item->id }}][status]" class="custom-control-input" value="1" @if ($item->pivot->status == 1) checked @endif>
            <label class="custom-control-label" for="{{ $item->judul.'1' }}">Sudah</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="{{ $item->judul.'0' }}" name="pengembalian[buku][{{ $item->id }}][status]" class="custom-control-input" value="0" @if ($item->pivot->status == 0) checked @endif>
            <label class="custom-control-label" for="{{ $item->judul.'0' }}">Belum</label>
        </div>
    </div>
</div>
@endforeach
@endisset

<div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
  <div class="col-sm-12 col-md-7">
    <button class="btn btn-primary" id="btn">
      @isset($pengembalian)
        Simpan Perubahan
      @else
        Submit
      @endisset
    </button>
  </div>
</div>
