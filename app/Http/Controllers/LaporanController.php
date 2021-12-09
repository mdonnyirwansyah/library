<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Kelas;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;
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

        $kelas = Kelas::find($request->kelas);
        $anggota = Anggota::where('kelas_id', $request->kelas)->orderBy('nama', 'ASC')->get();

        $pdf = PDF::loadView('app.laporan.print-anggota', compact('kelas', 'anggota'))
        ->setPaper('a4', 'portrait');

        return $pdf->stream('laporan-anggota-perpustakaan-'.$kelas->kelas.'.pdf');
    }

    public function buku()
    {
        $kategori = Kategori::all();

        return view('app.laporan.buku', compact('kategori'));
    }

    public function getBuku(Request $request)
    {
        if ($request->kategori) {
            $buku = Buku::where('buku.kategori_id', $request->kategori)->get();
        } else {
            $buku = Buku::all();
        }

        return DataTables::of($buku)
        ->addIndexColumn()
        ->addColumn('kategori', function ($buku) {
            return $buku->kategori->kategori;
        })
        ->make(true);
    }

    public function printBuku(Request $request)
    {
        Validator::make($request->all(), [
            'kategori' => 'required',
        ])->validate();

        $kategori = Kategori::find($request->kategori);
        $buku = Buku::where('kategori_id', $request->kategori)->orderBy('judul', 'ASC')->get();

        $pdf = PDF::loadView('app.laporan.print-buku', compact('kategori', 'buku'))
        ->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-buku-perpustakaan-'.$kategori->nama.'.pdf');
    }

    public function peminjaman()
    {
        $kelas = Kelas::all();
        $tahun_pelajaran = TahunPelajaran::all();

        return view('app.laporan.peminjaman', compact('kelas', 'tahun_pelajaran'));
    }

    public function getPeminjaman(Request $request)
    {
        if ($request->kelas || $request->tahun_pelajaran) {
            $peminjaman = Peminjaman::whereRelation(
                'anggota', 'kelas_id', $request->kelas
            )
            ->where('tahun_pelajaran_id', $request->tahun_pelajaran)
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

    public function printPeminjaman(Request $request)
    {
        Validator::make($request->all(), [
            'kelas' => 'required',
            'tahun_pelajaran' => 'required'
        ])->validate();

        $kelas = Kelas::find($request->kelas);
        $tahun_pelajaran = TahunPelajaran::find($request->tahun_pelajaran);
        $peminjaman = Peminjaman::whereRelation(
            'anggota', 'kelas_id', $request->kelas
        )
        ->where('tahun_pelajaran_id', $request->tahun_pelajaran)
        ->get();

        $pdf = PDF::loadView('app.laporan.print-peminjaman', compact('kelas', 'tahun_pelajaran', 'peminjaman'))
        ->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-peminjaman-perpustakaan-'.$kelas->kelas.'-tahun_'.$tahun_pelajaran->tahun.'.pdf');
    }

    public function pengembalian()
    {
        $kelas = Kelas::all();
        $tahun_pelajaran = TahunPelajaran::all();

        return view('app.laporan.pengembalian', compact('kelas', 'tahun_pelajaran'));
    }

    public function getPengembalian(Request $request)
    {
        if ($request->kelas || $request->tahun_pelajaran) {
            $pengembalian = Pengembalian::whereRelation(
                'peminjaman', function ($query) use ($request) {
                    $query->whereRelation('anggota', 'kelas_id', $request->kelas);
                }
            )
            ->whereRelation(
                'peminjaman', 'tahun_pelajaran_id', $request->tahun_pelajaran
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

    public function printPengembalian(Request $request)
    {
        Validator::make($request->all(), [
            'kelas' => 'required',
            'tahun_pelajaran' => 'required'
        ])->validate();

        $kelas = Kelas::find($request->kelas);
        $tahun_pelajaran = TahunPelajaran::find($request->tahun_pelajaran);
        $pengembalian = Pengembalian::whereRelation(
            'peminjaman', function ($query) use ($request) {
                $query->whereRelation('anggota', 'kelas_id', $request->kelas);
            }
        )
        ->whereRelation(
            'peminjaman', 'tahun_pelajaran_id', $request->tahun_pelajaran
        )
        ->get();

        $pdf = PDF::loadView('app.laporan.print-pengembalian', compact('kelas', 'tahun_pelajaran', 'pengembalian'))
        ->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-pengembalian-perpustakaan-'.$kelas->kelas.'-tahun_'.$tahun_pelajaran->tahun.'.pdf');
    }
}
