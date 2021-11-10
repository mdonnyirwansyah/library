@foreach ($peminjaman->buku as $item)
<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ $item->judul }}</label>
    <div class="col-sm-12 col-md-7">
        <div class="custom-control custom-radio custom-control-inline mt-1">
            <input type="radio" id="sejarah" name="sejarah" class="custom-control-input" value=1 checked>
            <label class="custom-control-label" for="sejarah">Ya</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="sejarah2" name="sejarah" class="custom-control-input" value=0 checked>
            <label class="custom-control-label" for="sejarah2">Tidak</label>
        </div>
    </div>
</div>
@endforeach
