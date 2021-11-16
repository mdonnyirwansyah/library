<?php

namespace App\Http\Controllers;

use App\DataTables\PeminjamanDataTable;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PeminjamanController extends Controller
{
    public function index(PeminjamanDataTable $dataTable)
    {
        return $dataTable->render('app.peminjaman.index');
    }

    public function create()
    {
        $buku = Buku::all();

        return view('app.peminjaman.create', compact('buku'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nis' => 'required',
            'buku' => 'required',
        ]);

        if ($validator->passes()) {
            $anggota = Anggota::where('nis', $request->nis)->first();

            DB::transaction(function() use ($anggota, $request) {
                $peminjaman = new Peminjaman();
                $peminjaman->anggota_id = $anggota->id;
                $peminjaman->save();

                if ($peminjaman) {
                    $peminjaman->buku()->sync($request->buku);

                    foreach ($request->buku as $item) {
                        $bukuDipinjam = Buku::find($item);
                        $bukuDipinjam->stok = $bukuDipinjam->stok - 1;
                        $bukuDipinjam->save();
                    }
                }
            });

            return response()->json(['success' => 'Data baru berhasil ditambah!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function find(Request $request)
    {
        $peminjaman = Peminjaman::find($request->peminjaman_id);

        $route = route('peminjaman.show', $peminjaman->id);

        if ($peminjaman) {
            return response()->json(['success' => $peminjaman->anggota->nama, 'route' => $route]);
        }

        return response()->json(['error' => 'ID Peminjaman tidak ditemukan!']);
    }

    public function show(Peminjaman $peminjaman)
    {
        return response()->json(['success' => view('app.peminjaman.show', compact('peminjaman'))->render()]);
    }

    public function edit(Peminjaman $peminjaman)
    {
        $buku = Buku::all();

        return view('app.peminjaman.edit', compact('peminjaman', 'buku'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $validator = Validator::make($request->all(), [
            'nis' => 'required',
            'buku' => 'required',
        ]);

        if ($validator->passes()) {
            $anggota = Anggota::where('nis', $request->nis)->first();

            DB::transaction(function() use ($anggota, $request, $peminjaman) {
                foreach ($peminjaman->buku as $item) {
                    $bukuDikembalikan = Buku::find($item->id);
                    $bukuDikembalikan->stok = $bukuDikembalikan->stok + $item->pivot->jumlah;
                    $bukuDikembalikan->save();
                }

                $peminjaman->anggota_id = $anggota->id;
                $peminjaman->save();

                $peminjaman->buku()->sync($request->buku);
                foreach ($request->buku as $item) {
                    $bukuDipinjam = Buku::find($item);
                    $bukuDipinjam->stok = $bukuDipinjam->stok - 1;
                    $bukuDipinjam->save();
                }
            });
            return response()->json(['success' => 'Data berhasil diperbarui!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function destroy(Peminjaman $peminjaman)
    {
        DB::transaction(function() use ($peminjaman) {
            foreach ($peminjaman->buku as $item) {
                $bukuDikembalikan = Buku::find($item->id);
                $bukuDikembalikan->stok = $bukuDikembalikan->stok + $item->pivot->jumlah;
                $bukuDikembalikan->save();
            }
            $peminjaman->delete();
        });

        return response()->json(['success' => 'Data berhasil dihapus!']);
    }
}
