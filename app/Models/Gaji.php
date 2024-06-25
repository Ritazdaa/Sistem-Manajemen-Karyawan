<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gaji; // Import model Gaji
use Illuminate\Support\Facades\DB;

class GajiController extends Controller
{
    /**
     * Menampilkan halaman informasi gaji dengan daftar gaji.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil data gaji dari tabel gajis menggunakan model Eloquent
        $salaries = Gaji::select('id', 'nama', 'nip', 'jabatan', 'gaji_pokok', 'tunjangan', 'transport', 'lembur')
                        ->get();

        return view('informasi', compact('salaries'));
    }

    /**
     * Menampilkan detail gaji berdasarkan ID.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function showDetail($id)
    {
        // Ambil data gaji berdasarkan ID menggunakan model Eloquent
        $gaji = Gaji::findOrFail($id);

        return view('detail_gaji', compact('gaji'));
    }

    /**
     * Mengupdate data gaji berdasarkan ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'nama' => 'required',
            'nip' => 'required',
            'jabatan' => 'required',
            'gaji_pokok' => 'required|numeric',
            'tunjangan' => 'nullable|numeric',
            'transport' => 'nullable|numeric',
            'lembur' => 'nullable|numeric',
        ]);

        // Update data gaji berdasarkan ID menggunakan model Eloquent
        $gaji = Gaji::findOrFail($id);
        $gaji->nama = $request->nama;
        $gaji->nip = $request->nip;
        $gaji->jabatan = $request->jabatan;
        $gaji->gaji_pokok = $request->gaji_pokok;
        $gaji->tunjangan = $request->tunjangan;
        $gaji->transport = $request->transport;
        $gaji->lembur = $request->lembur;
        $gaji->save();

        return redirect()->route('informasi.gaji')->with('success', 'Data gaji berhasil diperbarui');
    }

    /**
     * Menghapus data gaji berdasarkan ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Hapus data gaji berdasarkan ID menggunakan model Eloquent
        $gaji = Gaji::findOrFail($id);
        $gaji->delete();

        return redirect()->route('informasi.gaji')->with('success', 'Data gaji berhasil dihapus');
    }
}