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
        ->where('nik',$nik)
        ->whereRaw('MONTH(tgl_presensi) = ?', [$bulanini])
        ->whereRaw('YEAR(tgl_presensi) = ?', [$tahunini])
        ->orderBy('tgl_presensi')
        ->get();

        $rekappresensi = DB::table('presensi')->selectRaw('COUNT(nik) as jmlhadir, COUNT(IF(jam_in>"08:00",1,0)) as jmlterlambat')->where('nik',$nik) ->whereRaw('MONTH(tgl_presensi) = ?', [$bulanini])
        ->whereRaw('YEAR(tgl_presensi) = ?', [$tahunini])->first();

        $leaderboard = DB::table('presensi')
        ->join('karyawan','presensi.nik','=','karyawan.nik')
        ->where('tgl_presensi',$hariini)
        ->orderBy('jam_in')
        ->get();

        return view('dashboard.dashboard', compact('presensiharini','historibulanini','rekappresensi','leaderboard'));
    }

    public function dashboardadmin(){
        return view('dashboard.dashboardadmin');
    }
}
