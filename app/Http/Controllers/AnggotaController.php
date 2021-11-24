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
            'jenis_kelamin' => 'required',
            'kelas' => 'required',
        ]);

        if ($validator->passes()) {
            $anggota = new Anggota();
            $anggota->nis = $request->nis;
            $anggota->nama = $request->nama;
            $anggota->jenis_kelamin= $request->jenis_kelamin;
            $anggota->kelas_id = $request->kelas;
            $anggota->slug = Str::slug($request->nama);
            $anggota->save();

            return response()->json(['success' => 'Data baru berhasil ditambah!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function find(Request $request)
    {
        $anggota = Anggota::where('nis', $request->nis)->first();

        if ($anggota) {
            return response()->json(['success' => $anggota->nama]);
        }

        return response()->json(['error' => 'NIS tidak terdaftar!']);
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
            'jenis_kelamin' => 'required',
            'kelas' => 'required',
        ]);

        if ($validator->passes()) {
            $anggota->nis = $request->nis;
            $anggota->nama = $request->nama;
            $anggota->jenis_kelamin = $request->jenis_kelamin;
            $anggota->kelas_id = $request->kelas;
            $anggota->slug = Str::slug($request->nama);
            $anggota->save();

            return response()->json(['success' => 'Data berhasil diperbarui!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function destroy(Anggota $anggota)
    {
        if (count($anggota->peminjaman) > 0) {
            return response()->json(['failed' => 'Data gagal dihapus!, silahkan hapus data peminjaman dahulu']);
        } else {
            $anggota->delete();

            return response()->json(['success' => 'Data berhasil dihapus!']);
        }
    }
}
