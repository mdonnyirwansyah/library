<?php

namespace App\Http\Controllers;

use App\DataTables\PeriodeDataTable;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PeriodeController extends Controller
{
    public function index(PeriodeDataTable $dataTable)
    {
        return $dataTable->render('app.periode.index');
    }

    public function create()
    {
        return view('app.periode.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:periode',
        ]);

        if ($validator->passes()) {
            $periode = new Periode();
            $periode->nama = $request->nama;
            $periode->slug = Str::slug($request->nama);
            $periode->save();

            return response()->json(['success' => 'Data baru berhasil ditambah!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function edit(Periode $periode)
    {
        return view('app.periode.edit', compact('periode'));
    }

    public function update(Request $request, Periode $periode)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:periode,nama,' .$periode->id,
        ]);

        if ($validator->passes()) {
            $periode->nama = $request->nama;
            $periode->slug = Str::slug($request->nama);
            $periode->save();

            return response()->json(['success' => 'Data berhasil diperbarui!']);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function destroy(Periode $periode)
    {
        $periode->delete();

        return response()->json(['success' => 'Data berhasil dihapus!']);
    }
}
