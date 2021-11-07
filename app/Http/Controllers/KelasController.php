<?php

namespace App\Http\Controllers;

use App\DataTables\KelasDataTable;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class KelasController extends Controller
{
    public function index(KelasDataTable $dataTable)
    {
        return $dataTable->render('app.kelas.index');
    }

    public function create()
    {
        return view('app.kelas.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:kelas',
        ]);

        if ($validator->passes()) {
            $kelas = new Kelas();
            $kelas->nama = $request->nama;
            $kelas->slug = Str::slug($request->nama);
            $kelas->save();

            return response()->json(['success' => 'Data baru berhasil ditambah!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function edit(Kelas $kelas)
    {
        return view('app.kelas.edit', compact('kelas'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:kelas,nama,' .$kelas->id,
        ]);

        if ($validator->passes()) {
            $kelas->nama = $request->nama;
            $kelas->slug = Str::slug($request->nama);
            $kelas->save();

            return response()->json(['success' => 'Data berhasil diperbarui!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function destroy(Kelas $kelas)
    {
        $kelas->delete();

        return response()->json(['success' => 'Data berhasil dihapus!']);
    }
}
