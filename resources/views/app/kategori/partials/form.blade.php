<div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="kategori">Kategori</label>
  <div class="col-sm-12 col-md-7">
      <input type="text" class="form-control" name="kategori" id="kategori" @isset($kategori) value="{{ $kategori->kategori }}" @endisset />
      <small class="invalid-feedback kategori_err"></small>
  </div>
</div>

<div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
  <div class="col-sm-12 col-md-7">
    <button class="btn btn-primary" id="btn">
      @isset($kategori)
        Simpan Perubahan
      @else
        Submit
      @endisset
    </button>
  </div>
</div>
