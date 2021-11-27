<?php

namespace App\Http\Controllers;

use App\DataTables\BukuDataTable;
use App\Imports\BukuImport;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class BukuController extends Controller
{
    public function index(BukuDataTable $dataTable)
    {
        return $dataTable->render('app.buku.index');
    }

    public function create()
    {
        $kategori = Kategori::all();

        return view('app.buku.create', compact('kategori'));
    }

    public function import()
    {
        return view('app.buku.import');
    }

    public function store(Request $request)
    {
        if ($request->import) {
            $validator = Validator::make($request->all(), [
                'file' => 'required',
            ]);

            if ($validator->passes()) {
                Excel::import(new BukuImport(), $request->file('file'));

                return response()->json(['success' => 'Data baru berhasil diimport!']);
            }

            return response()->json(['error' => $validator->errors()]);
        } else {
            $validator = Validator::make($request->all(), [
                'kode' => 'required|unique:buku',
                'judul' => 'required',
                'kategori_id' => 'required',
                'pengarang' => 'required',
                'penerbit' => 'required',
                'tahun' => 'required',
                'stok' => 'required',
            ]);

            if ($validator->passes()) {
                $buku = new Buku();
                $buku->kode = $request->kode;
                $buku->judul = $request->judul;
                $buku->kategori_id = $request->kategori_id;
                $buku->pengarang = $request->pengarang;
                $buku->penerbit = $request->penerbit;
                $buku->tahun = $request->tahun;
                $buku->stok = $request->stok;
                $buku->slug = Str::slug($request->judul);
                $buku->save();

                return response()->json(['success' => 'Data baru berhasil ditambah!']);
            }

            return response()->json(['error' => $validator->errors()]);
        }
    }

    public function edit(Buku $buku)
    {
        $kategori = Kategori::all();

        return view('app.buku.edit', compact('buku', 'kategori'));
    }

    public function update(Request $request, Buku $buku)
    {
        $validator = Validator::make($request->all(), [
            'kode' => 'required|unique:buku,kode,' .$buku->id,
            'judul' => 'required',
            'kategori_id' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun' => 'required',
            'stok' => 'required',
        ]);

        if ($validator->passes()) {
            $buku->kode = $request->kode;
            $buku->judul = $request->judul;
            $buku->kategori_id = $request->kategori_id;
            $buku->pengarang = $request->pengarang;
            $buku->penerbit = $request->penerbit;
            $buku->tahun = $request->tahun;
            $buku->stok = $request->stok;
            $buku->slug = Str::slug($request->judul);
            $buku->save();

            return response()->json(['success' => 'Data berhasil diperbarui!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function destroy(Buku $buku)
    {
        if (count($buku->peminjaman) > 0) {
            return response()->json(['failed' => 'Data gagal dihapus!, silahkan hapus data peminjaman dahulu']);
        } else {
            $buku->delete();

            return response()->json(['success' => 'Data berhasil dihapus!']);
        }
    }
}
