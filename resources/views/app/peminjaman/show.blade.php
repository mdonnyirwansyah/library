@foreach ($peminjaman->buku as $item)
<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ $item->judul }}</label>
    <input type="hidden" name="pengembalian[buku][{{ $item->id }}][id]" value="{{ $item->id }}">
    <div class="col-sm-12 col-md-7">
        <div class="custom-control custom-radio custom-control-inline mt-1">
            <input type="radio" id="{{ $item->judul.'1' }}" name="pengembalian[buku][{{ $item->id }}][status]" class="custom-control-input" value="1">
            <label class="custom-control-label" for="{{ $item->judul.'1' }}">Sudah</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="{{ $item->judul.'0' }}" name="pengembalian[buku][{{ $item->id }}][status]" class="custom-control-input" value="0" checked>
            <label class="custom-control-label" for="{{ $item->judul.'0' }}">Belum</label>
        </div>
    </div>
</div>
@endforeach
