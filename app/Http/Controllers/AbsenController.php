<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Absen;

class AbsenController extends Controller
{
    // Tampilkan formulir absen
    public function showForm()
    {
        return view('absen_karyawan');
    }

    // Simpan data absen
    public function store(Request $request)
    {
        // Validasi permintaan
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'location_name' => 'required|string',
        ]);

        try {
            // Simpan catatan absen
            $absen = new Absen();
            $absen->user_id = Auth::id();
            $absen->name = Auth::user()->name;
            $absen->nip = Auth::user()->nip;
            $absen->jabatan = Auth::user()->jabatan;
            $absen->latitude = $request->latitude;
            $absen->longitude = $request->longitude;
            $absen->location_name = $request->location_name;

            // Proses foto yang diunggah
            if ($request->hasFile('photo')) {
                $fileName = time().'.'.$request->photo->extension();
                $request->photo->move(public_path('uploads'), $fileName);
                $absen->photo = $fileName;
            }

            $absen->save();

            // Redirect dengan pesan sukses
            return redirect()->route('dashboard.absenKaryawan')->with('success', 'Anda berhasil absen');
        } catch (\Exception $e) {
            // Tangani error dengan menampilkan pesan kesalahan
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menyimpan data. Silakan coba lagi.']);
        }
    }
    
    // Tampilkan riwayat absen
    public function riwayat()
    {
        // Example logic to fetch and display history of absences
        $absences = Absen::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('absen.riwayat', compact('absences'));
    }
}
