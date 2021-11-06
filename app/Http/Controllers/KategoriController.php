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
            'nama' => 'required|unique:kategori',
        ]);

        if ($validator->passes()) {
            $kategori = new Kategori();
            $kategori->nama = $request->nama;
            $kategori->slug = Str::slug($request->nama);
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
            'nama' => 'required|unique:kategori,nama,' .$kategori->id,
        ]);

        if ($validator->passes()) {
            $kategori->nama = $request->nama;
            $kategori->slug = Str::slug($request->nama);
            $kategori->save();

            return response()->json(['success' => 'Data berhasil diperbarui!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return response()->json(['success' => 'Data berhasil dihapus!']);
    }
}
