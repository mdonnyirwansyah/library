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
        $req = $request->all();

        $validator = Validator::make($request->all(), [
            'peminjaman_id' => 'required|unique:pengembalian',
        ]);

        if ($validator->passes()) {
            $data_buku = $req['pengembalian'];

            $buku = collect($data_buku['buku'])->map(function ($item) {
                return ['buku_id' => $item['id'], 'status' => $item['status']];
            });

            DB::transaction(function() use ($request, $buku) {
                $pengembalian = new Pengembalian();
                $pengembalian->peminjaman_id = $request->peminjaman_id;
                $pengembalian->save();

                if ($pengembalian) {
                    $pengembalian->buku()->sync($buku);
                }

                foreach ($buku as $item) {
                    $bukuDikembalikan = Buku::find($item['buku_id']);
                    $bukuDikembalikan->stok = $bukuDikembalikan->stok + $item['status'];
                    $bukuDikembalikan->save();
                }
            });

            return response()->json(['success' => 'Data baru berhasil ditambah!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function edit(Pengembalian $pengembalian)
    {
        return view('app.pengembalian.edit', compact('pengembalian'));
    }

    public function update(Request $request, Pengembalian $pengembalian)
    {
        $req = $request->all();
        $data_buku = $req['pengembalian'];

        $validator = Validator::make($request->all(), [
            'peminjaman_id' => 'required|unique:pengembalian,peminjaman_id,' .$pengembalian->id,
        ]);

        if ($validator->passes()) {
            $buku = collect($data_buku['buku'])->map(function ($item) {
                return ['buku_id' => $item['id'], 'status' => $item['status']];
            });

            DB::transaction(function() use ($request, $buku, $pengembalian) {
                foreach ($pengembalian->buku as $item) {
                    $bukuDikembalikan = Buku::find($item->id);
                    $bukuDikembalikan->stok = $bukuDikembalikan->stok - $item->pivot->status;
                    $bukuDikembalikan->save();
                }

                $pengembalian->peminjaman_id = $request->peminjaman_id;
                $pengembalian->save();

                $pengembalian->buku()->sync($buku);

                foreach ($buku as $item) {
                    $bukuDikembalikan = Buku::find($item['buku_id']);
                    $bukuDikembalikan->stok = $bukuDikembalikan->stok + $item['status'];
                    $bukuDikembalikan->save();
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
                $bukuDikembalikan->stok = $bukuDikembalikan->stok - $item->pivot->status;
                $bukuDikembalikan->save();
            }
            $pengembalian->delete();
        });

        return response()->json(['success' => 'Data berhasil dihapus!']);
    }
}
