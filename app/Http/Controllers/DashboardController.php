<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $hariini = date("Y-m-d");
        $tahunini = date("Y");
        $bulanini = date("m");
        $nik = Auth::guard('karyawan')->user()->nik;
        $presensiharini = DB::table('presensi')->where('nik',$nik)->where('tgl_presensi',$hariini)->first();
        $historibulanini = DB::table('presensi')
        ->whereRaw('MONTH(tgl_presensi) = ?', [$bulanini])
        ->whereRaw('YEAR(tgl_presensi) = ?', [$tahunini])
        ->orderBy('tgl_presensi')
        ->get();
        return view('dashboard.dashboard', compact('presensiharini','historibulanini'));
    }
}
