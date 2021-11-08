<div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="kode">Kode</label>
  <div class="col-sm-12 col-md-7">
      <input type="text" class="form-control" name="kode" id="kode" @isset($buku) value="{{ $buku->kode }}" @endisset />
      <small class="invalid-feedback nis_err"></small>
  </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="judul">Judul</label>
    <div class="col-sm-12 col-md-7">
        <input type="text" class="form-control" name="judul" id="judul" @isset($buku) value="{{ $buku->judul }}" @endisset />
        <small class="invalid-feedback judul_err"></small>
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="kategori_id">Kategori</label>
    <div class="col-sm-12 col-md-7">
      <select class="form-control select2" style="width: 100%" name="kategori_id" id="kategori_id">
        @isset($buku)
        @else
        <option value="" selected>Pilih Kategori</option>
        @endisset
        @foreach ($kategori as $item)
        <option value="{{ $item->id }}" @isset($buku) @if ($buku->kategori_id == $item->id) selected @endif @endisset>{{ $item->nama }}</option>
        @endforeach
      </select>
      <small class="invalid-feedback kategori_id_err"></small>
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="pengarang">Pengarang</label>
    <div class="col-sm-12 col-md-7">
        <input type="text" class="form-control" name="pengarang" id="pengarang" @isset($buku) value="{{ $buku->pengarang }}" @endisset />
        <small class="invalid-feedback pengarang_err"></small>
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="penerbit">Penerbit</label>
    <div class="col-sm-12 col-md-7">
        <input type="text" class="form-control" name="penerbit" id="penerbit" @isset($buku) value="{{ $buku->penerbit }}" @endisset />
        <small class="invalid-feedback penerbit_err"></small>
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="tahun">Tahun</label>
    <div class="col-sm-12 col-md-7">
        <input type="number" class="form-control" name="tahun" id="tahun" @isset($buku) value="{{ $buku->tahun }}" @endisset />
        <small class="invalid-feedback tahun_err"></small>
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="stok">Stok</label>
    <div class="col-sm-12 col-md-7">
        <input type="number" class="form-control" name="stok" id="stok" @isset($buku) value="{{ $buku->stok }}" @endisset />
        <small class="invalid-feedback stok_err"></small>
    </div>
</div>

<div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
  <div class="col-sm-12 col-md-7">
    <button class="btn btn-primary" id="btn">
      @isset($buku)
        Simpan Perubahan
      @else
        Submit
      @endisset
    </button>
  </div>
</div>
