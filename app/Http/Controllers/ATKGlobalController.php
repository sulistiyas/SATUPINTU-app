<?php

namespace App\Http\Controllers;

use App\Models\ATK_Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ATKGlobalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $atk_list = DB::table('atk_master')->orderBy('atk_name', 'ASC')->get();
        return view('users.atk.index', ['atk_list' => $atk_list]);
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
        $atk_data = ATK_Master::find($id);
        return response()->json($atk_data);
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
