<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Kelas;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class LaporanController extends Controller
{
    public function anggota()
    {
        $kelas = Kelas::all();

        return view('app.laporan.anggota', compact('kelas'));
    }

    public function getAnggotaData(Request $request)
    {
        if ($request->kelas_id) {
            $anggota = DB::table('anggota')->join('kelas', 'anggota.kelas_id', '=', 'kelas.id')->where('anggota.kelas_id', '=', $request->kelas_id)->select(['anggota.nis as nis', 'anggota.nama as nama', 'anggota.jenis_kelamin as jenis_kelamin', 'kelas.kelas as kelas']);
        } else {
            $anggota = DB::table('anggota')->join('kelas', 'anggota.kelas_id', '=', 'kelas.id')->select(['anggota.nis as nis', 'anggota.nama as nama', 'anggota.jenis_kelamin as jenis_kelamin', 'kelas.kelas as kelas']);
        }

        return DataTables::of($anggota)
        ->addIndexColumn()
        ->make(true);
    }

    public function buku()
    {
        $kategori = Kategori::all();

        return view('app.laporan.buku', compact('kategori'));
    }

    public function getBukuData(Request $request)
    {
        if ($request->kategori_id) {
            $buku = DB::table('buku')->join('kategori', 'buku.kategori_id', '=', 'kategori.id')->where('buku.kategori_id', '=', $request->kategori_id)->select(['buku.kode as kode', 'buku.judul as judul', 'kategori.nama as kategori']);
        } else {
            $buku = DB::table('buku')->join('kategori', 'buku.kategori_id', '=', 'kategori.id')->select(['buku.kode as kode', 'buku.judul as judul', 'kategori.nama as kategori']);
        }

        return DataTables::of($buku)
        ->addIndexColumn()
        ->make(true);
    }

    public function peminjaman()
    {
        $kelas = Kelas::all();
        $tahun_pelajaran = TahunPelajaran::all();

        return view('app.laporan.peminjaman', compact('kelas', 'tahun_pelajaran'));
    }

    public function getPeminjamanData(Request $request)
    {
        if ($request->kelas_id || $request->tahun_pelajaran_id) {
            $peminjaman = Peminjaman::whereRelation(
                'anggota', 'kelas_id', $request->kelas_id
            )
            ->where('tahun_pelajaran_id', $request->tahun_pelajaran_id)
            ->get();
        } else {
            $peminjaman = Peminjaman::all();
        }

        return DataTables::of($peminjaman)
        ->addIndexColumn()
        ->addColumn('nis', function ($peminjaman) {
            return $peminjaman->anggota->nis;
        })
        ->addColumn('anggota', function ($peminjaman) {
            return $peminjaman->anggota->nama;
        })
        ->addColumn('jenis_kelamin', function ($peminjaman) {
            return $peminjaman->anggota->jenis_kelamin;
        })
        ->addColumn('kelas', function ($peminjaman) {
            return $peminjaman->anggota->kelas->kelas;
        })
        ->addColumn('buku', function ($peminjaman) {
            return $peminjaman->buku->implode('judul', ', ');
        })
        ->editColumn('tanggal', function ($peminjaman) {
            return $peminjaman->created_at->format('Y-m-d');
        })
        ->addColumn('tahun_pelajaran', function ($peminjaman) {
            return $peminjaman->tahun_pelajaran->tahun;
        })
        ->make(true);
    }

    public function pengembalian()
    {
        $kelas = Kelas::all();
        $tahun_pelajaran = TahunPelajaran::all();

        return view('app.laporan.pengembalian', compact('kelas', 'tahun_pelajaran'));
    }

    public function getPengembalianData(Request $request)
    {
        if ($request->kelas_id || $request->tahun_pelajaran_id) {
            $pengembalian = Pengembalian::whereRelation(
                'peminjaman', function ($query) use ($request) {
                    $query->whereRelation('anggota', 'kelas_id', $request->kelas_id);
                }
            )
            ->whereRelation(
                'peminjaman', 'tahun_pelajaran_id', $request->tahun_pelajaran_id
            )
            ->get();
        } else {
            $pengembalian = Pengembalian::all();
        }

        return DataTables::of($pengembalian)
        ->addIndexColumn()
        ->addColumn('tahun_pelajaran', function ($pengembalian) {
            return $pengembalian->peminjaman->tahun_pelajaran->tahun;
        })
        ->addColumn('nis', function ($pengembalian) {
            return $pengembalian->peminjaman->anggota->nis;
        })
        ->addColumn('anggota', function ($pengembalian) {
            return $pengembalian->peminjaman->anggota->nama;
        })
        ->addColumn('jenis_kelamin', function ($pengembalian) {
            return $pengembalian->peminjaman->anggota->jenis_kelamin;
        })
        ->addColumn('kelas', function ($pengembalian) {
            return $pengembalian->peminjaman->anggota->kelas->kelas;
        })
        ->addColumn('sudah', function ($data) {
            $filter = $data->buku->filter(function ($item) {
                return $item->pivot->status == 1;
            });

            if (count($filter) > 0) {
                return $filter->implode('judul', ', ');
            } else {
                return '-';
            }
        })
        ->addColumn('belum', function ($data) {
            $filter = $data->buku->filter(function ($item) {
                return $item->pivot->status == 0;
            });

            if (count($filter) > 0) {
                return $filter->implode('judul', ', ');
            } else {
                return '-';
            }
        })
        ->editColumn('tanggal', function ($pengembalian) {
            return $pengembalian->created_at->format('Y-m-d');
        })
        ->make(true);
    }
}
