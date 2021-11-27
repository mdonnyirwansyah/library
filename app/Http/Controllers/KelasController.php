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
            'kelas' => 'required|unique:kelas',
        ]);

        if ($validator->passes()) {
            $kelas = new Kelas();
            $kelas->kelas = $request->kelas;
            $kelas->slug = Str::slug($request->kelas);
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
            'kelas' => 'required|unique:kelas,kelas,' .$kelas->id,
        ]);

        if ($validator->passes()) {
            $kelas->kelas = $request->kelas;
            $kelas->slug = Str::slug($request->kelas);
            $kelas->save();

            return response()->json(['success' => 'Data berhasil diperbarui!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function destroy(Kelas $kelas)
    {
        if (count($kelas->anggota) > 0) {
            return response()->json(['failed' => 'Data gagal dihapus!, silahkan hapus data anggota dahulu']);
        } else {
            $kelas->delete();

            return response()->json(['success' => 'Data berhasil dihapus!']);
        }
    }
}
