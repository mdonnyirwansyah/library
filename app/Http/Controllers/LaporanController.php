<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Kategori;
use App\Models\Kelas;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class LaporanController extends Controller
{
    public function anggota()
    {
        $kelas = Kelas::all();

        return view('app.laporan.anggota', compact('kelas'));
    }

    public function getAnggota(Request $request)
    {
        if ($request->kelas) {
            $anggota = Anggota::where('kelas_id', $request->kelas)->get();
        } else {
            $anggota = Anggota::all();
        }

        return DataTables::of($anggota)
        ->addIndexColumn()
        ->addColumn('kelas', function ($anggota) {
            return $anggota->kelas->kelas;
        })
        ->make(true);
    }

    public function printAnggota(Request $request)
    {
        Validator::make($request->all(), [
            'kelas' => 'required',
        ])->validate();

        $anggota = Anggota::where('kelas_id', $request->kelas)->get();

        $pdf = PDF::loadView('app.laporan.print-anggota', compact('anggota'));

        return $pdf->stream('laporan-anggota-perpustakaan.pdf');
    }

    public function buku()
    {
        $kategori = Kategori::all();

        return view('app.laporan.buku', compact('kategori'));
    }

    public function getBuku(Request $request)
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

    public function getPeminjaman(Request $request)
    {
        if ($request->kelas || $request->tahun_pelajaran_id) {
            $peminjaman = Peminjaman::whereRelation(
                'anggota', 'kelas', $request->kelas
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

    public function getPengembalian(Request $request)
    {
        if ($request->kelas || $request->tahun_pelajaran_id) {
            $pengembalian = Pengembalian::whereRelation(
                'peminjaman', function ($query) use ($request) {
                    $query->whereRelation('anggota', 'kelas_id', $request->kelas);
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
