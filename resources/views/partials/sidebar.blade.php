<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="">{{ config('app.name') }}</a>
  </div>
  <div class="sidebar-brand sidebar-brand-sm">
    <a href="#">{{ strtoupper(substr(config('app.name'), 0, 2)) }}</a>
  </div>
  <ul class="sidebar-menu">
    <li class="{{ request()->is('/') ? 'active' : '' }}">
      <a class="nav-link" href="{{ url('/') }}">
        <i class="fas fa-chart-pie"></i> <span>Dashboard</span>
      </a>
    </li>

    <li class="{{ request()->is('kelas*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('kelas.index') }}">
          <i class="fas fa-school"></i> <span>Kelas</span>
        </a>
    </li>

    <li class="{{ request()->is('anggota*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('anggota.index') }}">
          <i class="fas fa-users"></i> <span>Anggota</span>
        </a>
    </li>

    <li class="{{ request()->is('kategori*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('kategori.index') }}">
        <i class="fas fa-tags"></i> <span>Kategori</span>
      </a>
    </li>

    <li class="{{ request()->is('buku*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('buku.index') }}">
        <i class="fas fa-book"></i> <span>Buku</span>
      </a>
    </li>

    <li class="{{ request()->is('peminjaman*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('peminjaman.index') }}">
        <i class="fas fa-upload"></i> <span>Peminjaman</span>
      </a>
    </li>

    <li class="{{ request()->is('pengembalian*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('pengembalian.index') }}">
        <i class="fas fa-download"></i> <span>Pengembalian</span>
      </a>
    </li>

    <li class="dropdown {{ request()->is('laporan*') ? 'active' : '' }}">
      <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-file-alt"></i> <span>Laporan</span></a>
      <ul class="dropdown-menu">
        <li class="dropdown {{ request()->is('laporan/anggota') ? 'active' : '' }}"><a class="nav-link" href="{{ route('laporan.anggota') }}">Anggota</a></li>
        <li class="dropdown {{ request()->is('laporan/buku') ? 'active' : '' }}"><a class="nav-link" href="{{ route('laporan.buku') }}">Buku</a></li>
        <li class="dropdown {{ request()->is('laporan/peminjaman') ? 'active' : '' }}"><a class="nav-link" href="{{ route('laporan.peminjaman') }}">Peminjaman</a></li>
        <li class="dropdown {{ request()->is('laporan/pengembalian') ? 'active' : '' }}"><a class="nav-link" href="{{ route('laporan.pengembalian') }}">Pengembalian</a></li>
      </ul>
    </li>

    <li class="{{ request()->is('users') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('users.index') }}">
        <i class="fas fa-users"></i> <span>Users</span>
      </a>
    </li>
  </ul>
</aside>
