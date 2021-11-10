<?php

namespace App\Http\Controllers;

use App\DataTables\PengembalianDataTable;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PengembalianController extends Controller
{
    public function index(PengembalianDataTable $dataTable)
    {
        return $dataTable->render('app.pengembalian.index');
    }

    public function create()
    {
        return view('app.pengembalian.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'peminjaman_id' => 'required|unique:pengembalian',
        ]);

        if ($validator->passes()) {
            $pengembalian = Peminjaman::find($request->peminjaman_id);
            $buku = collect($request->input('buku', []))->map(function ($item) {
                return ['buku_id' => $item, 'jumlah' => 1];
            });
            DB::transaction(function() use ($pengembalian, $buku) {
                $pengembalian = new Pengembalian();
                $pengembalian->peminjaman_id = $pengembalian->id;
                $pengembalian->save();
                if ($pengembalian) {
                    $pengembalian->buku()->sync($buku);
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

    public function edit(Pengembalian $pengembalian)
    {
        return view('app.pengembalian.edit', compact('Pengembalian'));
    }

    public function update(Request $request, Peminjaman $pengembalian)
    {
        $validator = Validator::make($request->all(), [
            'peminjaman_id' => 'required',
        ]);

        if ($validator->passes()) {
            $buku = collect($request->input('buku', []))->map(function ($item) {
                return ['buku_id' => $item, 'jumlah' => 1];
            });

            DB::transaction(function() use ($buku, $pengembalian) {
                foreach ($pengembalian->buku as $item) {
                    $bukuDikembalikan = Buku::find($item->id);
                    $bukuDikembalikan->stok = $bukuDikembalikan->stok + $item->pivot->jumlah;
                    $bukuDikembalikan->save();
                }

                $pengembalian->peminjaman_id = $pengembalian->id;
                $pengembalian->save();

                $pengembalian->buku()->sync($buku);
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

    public function destroy(Pengembalian $pengembalian)
    {
        DB::transaction(function() use ($pengembalian) {
            foreach ($pengembalian->buku as $item) {
                $bukuDikembalikan = Buku::find($item->id);
                $bukuDikembalikan->stok = $bukuDikembalikan->stok + $item->pivot->jumlah;
                $bukuDikembalikan->save();
            }
            $pengembalian->delete();
        });
        return response()->json(['success' => 'Data berhasil dihapus!']);
    }
}
