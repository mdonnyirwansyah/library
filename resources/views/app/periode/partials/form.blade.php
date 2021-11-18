<div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="nama">Nama</label>
  <div class="col-sm-12 col-md-7">
      <input type="text" class="form-control" name="nama" id="nama" @isset($periode) value="{{ $periode->nama }}" @endisset />
      <small class="invalid-feedback nama_err"></small>
  </div>
</div>

<div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
  <div class="col-sm-12 col-md-7">
    <button class="btn btn-primary" id="btn">
      @isset($periode)
        Simpan Perubahan
      @else
        Submit
      @endisset
    </button>
  </div>
</div>
