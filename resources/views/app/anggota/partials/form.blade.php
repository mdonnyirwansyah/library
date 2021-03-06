<div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="nis">NIS</label>
  <div class="col-sm-12 col-md-7">
      <input type="text" class="form-control" name="nis" id="nis" @isset($anggota) value="{{ $anggota->nis }}" @endisset />
      <small class="invalid-feedback nis_err"></small>
  </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="nama">Nama</label>
    <div class="col-sm-12 col-md-7">
        <input type="text" class="form-control" name="nama" id="nama" @isset($anggota) value="{{ $anggota->nama }}" @endisset />
        <small class="invalid-feedback nama_err"></small>
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="jenis_kelamin">Jenis Kelamin</label>
    <div class="col-sm-12 col-md-7">
      <select class="form-control select2" style="width: 100%" name="jenis_kelamin" id="jenis_kelamin">
        @isset($anggota)
        @else
        <option value="" selected>Pilih jenis kelamin</option>
        @endisset
        <option value="Laki-laki" @isset($anggota) @if ($anggota->jenis_kelamin == "Laki-laki") selected @endif @endisset>Laki-laki</option>
        <option value="Perempuan" @isset($anggota) @if ($anggota->jenis_kelamin == "Perempuan") selected @endif @endisset>Perempuan</option>
      </select>
      <small class="invalid-feedback jenis_kelamin_err"></small>
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="kelas">Kelas</label>
    <div class="col-sm-12 col-md-7">
      <select class="form-control select2" style="width: 100%" name="kelas" id="kelas">
        @isset($anggota)
        @if ($anggota->kelas_id === null)
            <option value="" selected>Pilih kelas</option>
        @endif
        @else
        <option value="" selected>Pilih kelas</option>
        @endisset
        @foreach ($kelas as $item)
        <option value="{{ $item->id }}" @isset($anggota) @if ($anggota->kelas_id == $item->id) selected @endif @endisset>{{ $item->kelas }}</option>
        @endforeach
      </select>
      <small class="invalid-feedback kelas_err"></small>
    </div>
</div>

<div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
  <div class="col-sm-12 col-md-7">
    <button class="btn btn-primary" id="btn">
      @isset($anggota)
        Simpan Perubahan
      @else
        Submit
      @endisset
    </button>
  </div>
</div>
