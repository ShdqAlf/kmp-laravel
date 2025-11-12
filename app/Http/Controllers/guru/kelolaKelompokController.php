<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelompok;
use App\Models\User;

class kelolaKelompokController extends Controller
{
    public function kelolaKelompok()
    {
        $kelompokList = Kelompok::with('users')->get();
        $users = User::where('role', 'siswa')->get();
        return view('guru.kelolakelompok', compact('kelompokList', 'users'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'course' => 'required|string|max:255',
            'anggota' => 'required|array|min:1', // Minimal satu anggota dipilih
            'anggota.*' => 'exists:users,id', // Pastikan anggota yang dipilih ada di database
        ]);

        // Membuat Kelompok baru
        $kelompok = Kelompok::create([
            'nama_kelompok' => $validated['course'],
        ]);

        // Mengaitkan anggota (users) ke kelompok
        $kelompok->users()->attach($validated['anggota']);

        return redirect()->route('kelolakelompok')->with('success', 'Kelompok berhasil disimpan!');
    }
}
