<?php

namespace App\Http\Controllers\OldData;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OldJNController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index_jn_2018()
    {
        $jn_data = DB::table('tbl_jn2018')
            ->join('client', 'tbl_jn2018.id_client', '=', 'client.id_client')
            ->orderBy('tbl_jn2018.id_jn', 'desc')->get();
        $data_client = DB::table('client')->where('client.deleted_at', '=', NULL)->orderBy('client.id_client', 'asc')->get();
        return view('layouts.old_data.jobnumber.2018', ['jn_data' => $jn_data]);
    }

    public function index_jn_2019()
    {
        $jn_data = DB::table('tbl_jn2019')
            ->join('client', 'tbl_jn2019.id_client', '=', 'client.id_client')
            ->orderBy('tbl_jn2019.id_jn', 'desc')->get();
        $data_client = DB::table('client')->where('client.deleted_at', '=', NULL)->orderBy('client.id_client', 'asc')->get();
        return view('layouts.old_data.jobnumber.2019', ['jn_data' => $jn_data]);
    }

    public function index_jn_2020()
    {
        $jn_data = DB::table('tbl_jn2020')
            ->join('client', 'tbl_jn2020.id_client', '=', 'client.id_client')
            ->orderBy('tbl_jn2020.id_jn', 'desc')->get();
        $data_client = DB::table('client')->where('client.deleted_at', '=', NULL)->orderBy('client.id_client', 'asc')->get();
        return view('layouts.old_data.jobnumber.2020', ['jn_data' => $jn_data]);
    }

    public function index_jn_2021()
    {
        $jn_data = DB::table('tbl_jn2021')
            ->join('client', 'tbl_jn2021.id_client', '=', 'client.id_client')
            ->orderBy('tbl_jn2021.id_jn', 'desc')->get();
        $data_client = DB::table('client')->where('client.deleted_at', '=', NULL)->orderBy('client.id_client', 'asc')->get();
        return view('layouts.old_data.jobnumber.2021', ['jn_data' => $jn_data]);
    }

    public function index_jn_2022()
    {
        $jn_data = DB::table('tbl_jn2022')
            ->join('client', 'tbl_jn2022.id_client', '=', 'client.id_client')
            ->orderBy('tbl_jn2022.id_jn', 'desc')->get();
        $data_client = DB::table('client')->where('client.deleted_at', '=', NULL)->orderBy('client.id_client', 'asc')->get();
        return view('layouts.old_data.jobnumber.2022', ['jn_data' => $jn_data]);
    }

    public function index_jn_2023()
    {
        $jn_data = DB::table('tbl_jn2023')
            ->join('client', 'tbl_jn2023.id_client', '=', 'client.id_client')
            ->orderBy('tbl_jn2023.id_jn', 'desc')->get();
        $data_client = DB::table('client')->where('client.deleted_at', '=', NULL)->orderBy('client.id_client', 'asc')->get();
        return view('layouts.old_data.jobnumber.2023', ['jn_data' => $jn_data]);
    }

    public function index_jn_2024()
    {
        $jn_data = DB::table('tbl_jn2024')
            ->join('client', 'tbl_jn2024.id_client', '=', 'client.id_client')
            ->orderBy('tbl_jn2024.id_jn', 'desc')->get();
        $data_client = DB::table('client')->where('client.deleted_at', '=', NULL)->orderBy('client.id_client', 'asc')->get();
        return view('layouts.old_data.jobnumber.2024', ['jn_data' => $jn_data]);
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
