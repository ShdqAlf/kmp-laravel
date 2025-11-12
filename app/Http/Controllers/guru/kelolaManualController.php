<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\manualBook;

class kelolaManualController extends Controller
{
    public function kelolaManual()
    {
        // Ambil semua course untuk ditampilkan di dropdown
        $courses = manualBook::all();

        // Tampilkan halaman pemilihan course
        return view('guru.kelolamanualbook', compact('courses'));
    }
}
