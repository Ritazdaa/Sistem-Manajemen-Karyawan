<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $userData = User::select(DB::raw("COUNT(*) as count"))
                        ->whereYear('created_at', date('Y'))
                        ->groupBy(DB::raw("MONTH(created_at)"))
                        ->pluck('count');

        return view('dashboard', compact('userData'));
    }

    public function showDataPengguna()
    {
        $users = User::all();
        return view('data_pengguna', compact('users'));
    }
}