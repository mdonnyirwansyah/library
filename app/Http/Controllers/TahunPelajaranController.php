<?php

namespace App\Http\Controllers;

use App\DataTables\TahunPelajaranDataTable;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TahunPelajaranController extends Controller
{
    public function index(TahunPelajaranDataTable $dataTable)
    {
        return $dataTable->render('app.tahun-pelajaran.index');
    }

    public function create()
    {
        return view('app.tahun-pelajaran.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tahun' => 'required|unique:tahun_pelajaran',
        ]);

        if ($validator->passes()) {
            $tahun_pelajaran = new TahunPelajaran();
            $tahun_pelajaran->tahun = $request->tahun;
            $tahun_pelajaran->slug = Str::slug($request->tahun);
            $tahun_pelajaran->save();

            return response()->json(['success' => 'Data baru berhasil ditambah!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function edit(TahunPelajaran $tahun_pelajaran)
    {
        return view('app.tahun-pelajaran.edit', compact('tahun_pelajaran'));
    }

    public function update(Request $request, TahunPelajaran $tahun_pelajaran)
    {
        $validator = Validator::make($request->all(), [
            'tahun' => 'required|unique:tahun_pelajaran,tahun,' .$tahun_pelajaran->id,
        ]);

        if ($validator->passes()) {
            $tahun_pelajaran->tahun = $request->tahun;
            $tahun_pelajaran->slug = Str::slug($request->tahun);
            $tahun_pelajaran->save();

            return response()->json(['success' => 'Data berhasil diperbarui!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function destroy(TahunPelajaran $tahun_pelajaran)
    {
        if (count($tahun_pelajaran->peminjaman) > 0) {
            return response()->json(['failed' => 'Data gagal dihapus!, silahkan hapus data peminjaman dahulu']);
        } else {
            $tahun_pelajaran->delete();

            return response()->json(['success' => 'Data berhasil dihapus!']);
        }
    }
}
