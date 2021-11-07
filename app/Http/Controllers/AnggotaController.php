<?php

namespace App\Http\Controllers;

use App\DataTables\AnggotaDataTable;
use App\Models\Anggota;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AnggotaController extends Controller
{
    public function index(AnggotaDataTable $dataTable)
    {
        return $dataTable->render('app.anggota.index');
    }

    public function create()
    {
        $kelas = Kelas::all();

        return view('app.anggota.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nis' => 'required|unique:anggota',
            'nama' => 'required',
            'kelas_id' => 'required',
        ]);

        if ($validator->passes()) {
            $anggota = new Anggota();
            $anggota->nis = $request->nis;
            $anggota->nama = $request->nama;
            $anggota->kelas_id = $request->kelas_id;
            $anggota->slug = Str::slug($request->nama);
            $anggota->save();

            return response()->json(['success' => 'Data baru berhasil ditambah!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function edit(Anggota $anggota)
    {
        $kelas = Kelas::all();

        return view('app.anggota.edit', compact('anggota', 'kelas'));
    }

    public function update(Request $request, Anggota $anggota)
    {
        $validator = Validator::make($request->all(), [
            'nis' => 'required|unique:anggota,nis,' .$anggota->id,
            'nama' => 'required',
            'kelas_id' => 'required',
        ]);

        if ($validator->passes()) {
            $anggota->nis = $request->nis;
            $anggota->nama = $request->nama;
            $anggota->kelas_id = $request->kelas_id;
            $anggota->slug = Str::slug($request->nama);
            $anggota->save();

            return response()->json(['success' => 'Data berhasil diperbarui!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function destroy(Anggota $anggota)
    {
        $anggota->delete();

        return response()->json(['success' => 'Data berhasil dihapus!']);
    }
}