<?php

namespace App\Http\Controllers;

use App\Models\RiwayatAbsen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RiwayatAbsenController extends Controller
{
    public function index()
    {
        $riwayatAbsens = RiwayatAbsen::all();
        return view('riwayat_absen.index', compact('riwayatAbsens'));
    }

    public function terima($id)
    {
        try {
            $riwayatAbsen = RiwayatAbsen::findOrFail($id);
            $riwayatAbsen->status = 'Diterima';
            $riwayatAbsen->save();

            return redirect()->back()->with('success', 'Absen telah diterima.');
        } catch (\Exception $e) {
            Log::error('Error accepting absence: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memproses permintaan.');
        }
    }

    public function tolak($id)
    {
        try {
            $riwayatAbsen = RiwayatAbsen::findOrFail($id);
            $riwayatAbsen->status = 'Ditolak';
            $riwayatAbsen->save();

            return redirect()->back()->with('success', 'Absen telah ditolak.');
        } catch (\Exception $e) {
            Log::error('Error rejecting absence: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memproses permintaan.');
        }
    }


}
