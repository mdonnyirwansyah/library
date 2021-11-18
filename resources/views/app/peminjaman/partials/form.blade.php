<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="nis">NIS</label>
    <div class="col-sm-12 col-md-7">
        <input type="text" class="form-control" name="nis" id="nis" @isset($peminjaman) value="{{ $peminjaman->anggota->nis }}" @endisset />
        <small class="invalid-feedback nis_err"></small><small class="valid-feedback nis_valid"></small>
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="periode">Periode</label>
    <div class="col-sm-12 col-md-7">
        <select class="form-select select2" style="width: 100%" name="periode" id="periode">
            @isset($peminjaman)
            @else
            <option value="" selected>Pilih periode</option>
            @endisset
          @foreach ($periode as $item)
          <option value="{{ $item->id }}" @isset($peminjaman) @if($item->id == $peminjaman->periode_id) selected @endif @endisset>{{ $item->nama }}</option>
          @endforeach
        </select>
      <small class="invalid-feedback periode_err"></small>
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="buku">Buku</label>
    <div class="col-sm-12 col-md-7">
        <select class="form-select select2" style="width: 100%" name="buku[]" id="buku" multiple>
          @foreach ($buku as $item)
          <option value="{{ $item->id }}" @isset($peminjaman) @if(in_array($item->id, $peminjaman->buku->pluck('id')->toArray())) selected @endif @endisset>{{ $item->kode.' - '.$item->judul.' '.$item->kategori->nama }}</option>
          @endforeach
        </select>
      <small class="invalid-feedback buku_err"></small>
    </div>
</div>

<div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
  <div class="col-sm-12 col-md-7">
    <button class="btn btn-primary" id="btn">
      @isset($peminjaman)
        Simpan Perubahan
      @else
        Submit
      @endisset
    </button>
  </div>
</div>
