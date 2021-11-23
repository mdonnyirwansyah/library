<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $totalUsers = User::count();
        $totalAnggota = Anggota::count();
        $totalKelas = Kelas::count();
        $totalBuku = Buku::count();

        return view('app.dashboard', compact('totalUsers', 'totalAnggota', 'totalKelas', 'totalBuku'));
    }
}
