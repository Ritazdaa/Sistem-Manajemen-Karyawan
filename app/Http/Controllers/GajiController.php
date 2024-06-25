<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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
        // Ambil data gaji dari tabel gaji
        $salaries = DB::table('gaji')
                        ->select('id', 'nama', 'nip', 'jabatan', 'gaji_pokok', 'tunjangan', 'transport', 'lembur')
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
        // Ambil data gaji berdasarkan ID
        $gaji = DB::table('gaji')
                    ->where('id', $id)
                    ->first();

        if (!$gaji) {
            abort(404, 'Data gaji tidak ditemukan.');
        }

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

        // Update data gaji berdasarkan ID
        DB::table('gaji')
            ->where('id', $id)
            ->update([
                'nama' => $request->nama,
                'nip' => $request->nip,
                'jabatan' => $request->jabatan,
                'gaji_pokok' => $request->gaji_pokok,
                'tunjangan' => $request->tunjangan,
                'transport' => $request->transport,
                'lembur' => $request->lembur,
            ]);

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
        DB::table('gaji')->where('id', $id)->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Menampilkan form edit gaji berdasarkan ID.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $gaji = DB::table('gaji')->where('id', $id)->first();
        if (!$gaji) {
            abort(404, 'Data gaji tidak ditemukan.');
        }
        return view('edit_gaji', compact('gaji'));
    }

    /**
     * Menyimpan data gaji baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'gaji_pokok' => 'required|numeric',
            'tunjangan' => 'nullable|numeric',
            'transport' => 'nullable|numeric',
            'lembur' => 'nullable|numeric',
        ]);

        // Simpan data gaji baru
        DB::table('gaji')->insert([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'gaji_pokok' => $request->gaji_pokok,
            'tunjangan' => $request->tunjangan,
            'transport' => $request->transport,
            'lembur' => $request->lembur,
        ]);

        return redirect()->route('informasi.gaji')->with('success', 'Data gaji berhasil ditambahkan.');
    }
}