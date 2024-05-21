<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_level = Auth::user()->user_level;
        // 0 = Admin / GA
        // 1 = Director
        // 2 = Manager
        // 3 = Employee

        if ($user_level == "0") {
            return view('admin.dashboard');
        } elseif ($user_level == "1") {
            // return view('layouts.director.home');
        } elseif ($user_level == "2") {
            return view('manager.dashboard');
        } elseif ($user_level == "3") {
            // return view('layouts.employee.home');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
