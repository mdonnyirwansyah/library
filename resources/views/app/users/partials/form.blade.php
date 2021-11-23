<div class="form-group row">
  <label for="email" class="col-form-label col-md-3">Email</label>
  <div class="col-md-9">
    <input type="text" class="form-control form-control-sm" id="email" name="email" @isset($user) value="{{ $user->email }}" @endisset />
    <small class="invalid-feedback email_err"></small>
  </div>
</div>
<div class="form-group row">
  <label for="nama" class="col-form-label col-md-3">Nama</label>
  <div class="col-md-9">
    <input type="text" class="form-control form-control-sm" id="nama" name="nama" @isset($user) value="{{ $user->name }}" @endisset />
    <small class="invalid-feedback nama_err"></small>
  </div>
</div>
@isset($user)
@else
<div class="form-group row">
  <label for="password" class="col-form-label col-md-3">Password</label>
  <div class="col-md-9">
    <input type="password" class="form-control form-control-sm" id="password" name="password" />
    <small class="invalid-feedback password_err"></small>
  </div>
</div>
<div class="form-group row">
  <label for="password_confirmation" class="col-form-label col-md-3">Konfirmasi Password</label>
  <div class="col-md-9">
    <input type="password" class="form-control form-control-sm" id="password_confirmation" name="password_confirmation" />
    <small class="invalid-feedback password_confirmation_err"></small>
  </div>
</div>
@endisset
<div class="form-group row">
  <label for="role" class="col-form-label col-md-3">Role</label>
  <div class="col-md-9">
    <select class="form-select select2" style="width: 100%" name="role" id="role">
      <option value="" selected>Pilih role</option>
      @foreach ($roles as $role)
      <option value="{{ $role->id }}" @isset($user) @if($role->id === $user->role_id) selected @endif @endisset>{{ $role->name }}</option>
      @endforeach
    </select>
    <small class="invalid-feedback role_err"></small>
  </div>
</div>
