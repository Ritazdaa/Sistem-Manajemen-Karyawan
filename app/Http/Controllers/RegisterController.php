<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RegisterController extends Controller
{
    public function show()
    {
        return view('register');
    }

    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'namaInput' => 'required',
        'emailInput' => 'required|email',
        'nipInput' => 'required|numeric', 
        'jabatanInput' => 'required',
        'passwordInput' => 'required|min:8|confirmed',
    ]);

    // Debugging: log the request data
    \Log::info($request->all());

    $query = User::create([
        'name' => $request->namaInput,
        'email' => $request->emailInput,
        'nip' => $request->nipInput, 
        'jabatan' => $request->jabatanInput,
        'password' => Hash::make($request->passwordInput)
    ]);

    if ($query) {
        return redirect()->route('login');
    } else {
        return redirect()->back();
    }
}}