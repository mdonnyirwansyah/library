<div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="tahun">Tahun</label>
  <div class="col-sm-12 col-md-7">
      <input type="text" class="form-control" name="tahun" id="tahun" @isset($tahun_pelajaran) value="{{ $tahun_pelajaran->tahun }}" @endisset />
      <small class="invalid-feedback tahun_err"></small>
  </div>
</div>

<div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
  <div class="col-sm-12 col-md-7">
    <button class="btn btn-primary" id="btn">
      @isset($tahun_pelajaran)
        Simpan Perubahan
      @else
        Submit
      @endisset
    </button>
  </div>
</div>
