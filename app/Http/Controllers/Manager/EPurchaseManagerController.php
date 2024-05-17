<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use RealRashid\SweetAlert\Facades\Alert;

class EPurchaseManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id_users = Auth::user()->id;
        $get_div = DB::table('employee')->where('id_users', '=', $id_users)->where('deleted_at', '=', NULL)->get();
        foreach ($get_div as $item) {
            $division = $item->emp_division;
        }
        $get_pr_data = DB::table('pr')
            ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->where('employee.emp_division', '=', $division)
            ->where('pr.deleted_at', '=', NULL)
            ->groupBy('pr.pr_no')->get();
        return view('manager.includes.ePurchase.index_pr', ['data' => $get_pr_data]);
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
