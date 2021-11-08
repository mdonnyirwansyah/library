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
        $anggota = Anggota::all();
        $buku = Buku::all();

        return view('app.peminjaman.create', compact('anggota', 'buku'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nis' => 'required',
            'buku' => 'required',
        ]);

        if ($validator->passes()) {
            $anggota = Anggota::where('nis', $request->nis)->first();
            $buku = collect($request->input('buku', []))->map(function ($item) {
                return ['buku_id' => $item, 'jumlah' => 1];
            });
            DB::transaction(function() use ($anggota, $buku) {
                $peminjaman = new Peminjaman();
                $peminjaman->anggota_id = $anggota->id;
                $peminjaman->save();
                if ($peminjaman) {
                    $peminjaman->buku()->sync($buku);
                    foreach ($buku as $item) {
                        $bukuDipinjam = Buku::find($item['buku_id']);
                        $bukuDipinjam->stok = $bukuDipinjam->stok - $item['jumlah'];
                        $bukuDipinjam->save();
                    }
                }
            });

            return response()->json(['success' => 'Data baru berhasil ditambah!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function edit(Peminjaman $peminjaman)
    {
        $anggota = Anggota::find($peminjaman->anggota_id);

        $buku = Buku::all();

        return view('app.peminjaman.edit', compact('peminjaman', 'anggota', 'buku'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $validator = Validator::make($request->all(), [
            'nis' => 'required',
            'buku' => 'required',
        ]);

        if ($validator->passes()) {
            $anggota = Anggota::where('nis', $request->nis)->first();
            $buku = collect($request->input('buku', []))->map(function ($item) {
                return ['buku_id' => $item, 'jumlah' => 1];
            });

            DB::transaction(function() use ($anggota, $buku, $peminjaman) {
                foreach ($peminjaman->buku as $item) {
                    $bukuDikembalikan = Buku::find($item->id);
                    $bukuDikembalikan->stok = $bukuDikembalikan->stok + $item->pivot->jumlah;
                    $bukuDikembalikan->save();
                }

                $peminjaman->anggota_id = $anggota->id;
                $peminjaman->save();

                $peminjaman->buku()->sync($buku);
                foreach ($buku as $item) {
                    $bukuDipinjam = Buku::find($item['buku_id']);
                    $bukuDipinjam->stok = $bukuDipinjam->stok - $item['jumlah'];
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
