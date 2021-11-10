<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="peminjaman_id">ID Peminjaman</label>
    <div class="col-sm-12 col-md-7">
        <input type="text" class="form-control" name="peminjaman_id" id="peminjaman_id" @isset($pengembalian) value="{{ $pengembalian->peminjaman_id }}" @endisset />
        <small class="invalid-feedback peminjaman_id_err"></small><small class="valid-feedback peminjaman_id_valid"></small>
    </div>
</div>

<div id="view-form-buku" style="display: none"></div>

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
