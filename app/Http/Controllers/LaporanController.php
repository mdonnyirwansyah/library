<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Kelas;
use App\Models\Peminjaman;
use App\Models\Periode;
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
            $anggota = DB::table('anggota')->join('kelas', 'anggota.kelas_id', '=', 'kelas.id')->where('anggota.kelas_id', '=', $request->kelas_id)->select(['anggota.nis as nis', 'anggota.nama as nama', 'kelas.nama as kelas']);
        } else {
            $anggota = DB::table('anggota')->join('kelas', 'anggota.kelas_id', '=', 'kelas.id')->select(['anggota.nis as nis', 'anggota.nama as nama', 'kelas.nama as kelas']);
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
        $periode = Periode::all();

        return view('app.laporan.peminjaman', compact('kelas', 'periode'));
    }

    public function getPeminjamanData(Request $request)
    {
        if ($request->kelas_id || $request->periode_id) {
            $peminjaman = Peminjaman::whereRelation(
                'anggota', 'kelas_id', $request->kelas_id
            )
            ->where('periode_id', $request->periode_id)
            ->get();
        } else {
            $peminjaman = Peminjaman::all();
        }

        return DataTables::of($peminjaman)
        ->addIndexColumn()
        ->addColumn('periode', function ($peminjaman) {
            return $peminjaman->periode->nama;
        })
        ->addColumn('nis', function ($peminjaman) {
            return $peminjaman->anggota->nis;
        })
        ->addColumn('anggota', function ($peminjaman) {
            return $peminjaman->anggota->nama;
        })
        ->addColumn('kelas', function ($peminjaman) {
            return $peminjaman->anggota->kelas->nama;
        })
        ->addColumn('buku', function ($peminjaman) {
            $map = $peminjaman->buku->map(function ($item) {
                return ['judul' => $item->judul.' '.$item->kategori->nama];
            });

            return $map->implode('judul', ', ');
        })
        ->editColumn('tanggal', function ($peminjaman) {
            return $peminjaman->created_at->format('Y-m-d');
        })
        ->make(true);
    }

    public function pengembalian()
    {
        return view('app.laporan.pengembalian');
    }
}
