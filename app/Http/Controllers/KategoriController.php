<?php

namespace App\Http\Controllers;

use App\DataTables\KategoriDataTable;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable)
    {
        return $dataTable->render('app.kategori.index');
    }

    public function create()
    {
        return view('app.kategori.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori' => 'required|unique:kategori',
        ]);

        if ($validator->passes()) {
            $kategori = new Kategori();
            $kategori->kategori = $request->kategori;
            $kategori->slug = Str::slug($request->kategori);
            $kategori->save();

            return response()->json(['success' => 'Data baru berhasil ditambah!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function edit(Kategori $kategori)
    {
        return view('app.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $validator = Validator::make($request->all(), [
            'kategori' => 'required|unique:kategori,kategori,' .$kategori->id,
        ]);

        if ($validator->passes()) {
            $kategori->kategori = $request->kategori;
            $kategori->slug = Str::slug($request->kategori);
            $kategori->save();

            return response()->json(['success' => 'Data berhasil diperbarui!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function destroy(Kategori $kategori)
    {
        if (count($kategori->buku) > 0) {
            return response()->json(['failed' => 'Data gagal dihapus!, silahkan hapus data buku dahulu']);
        } else {
            $kategori->delete();

            return response()->json(['success' => 'Data berhasil dihapus!']);
        }
    }
}
