<?php

namespace App\Http\Controllers\OldData;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OldPRPOController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $old_pr = DB::table('tbl_pr')->orderBy('date', 'DESC')->groupBy('pr_number')->get();
        
        return view('hr_ga.epurchase.old_pr', ['old_pr' => $old_pr]);
    }

    public function showModalPRPO($id){
        $pr_po_data = DB::table('tbl_pr')->where('pr_number', $id)->get();
        $price_data = DB::table('tbl_pr')->where('pr_number', $id)->get();
        foreach($price_data as $price){
            $disc = $price->discount;
            $tax = $price->tax;
        }
        $sub_total = DB::table('tbl_pr')->where('pr_number', $id)->sum('total_price');
        $a_disc = ($sub_total * $disc) / 100;
        $a_tax = ($sub_total * $tax) / 100;

        $grand_total = $sub_total - $a_disc + $a_tax;
        return view('components.modals.e-purchase.old_pr_po', ['pr_po_data' => $pr_po_data, 'sub_total' => $sub_total, 'a_disc' => $a_disc, 'a_tax' => $a_tax, 'grand_total' => $grand_total]);
    }

    public function showModalPR($id){
        $pr_data = DB::table('tbl_pr')->where('pr_number', $id)->get();
        return view('components.modals.e-purchase.old_pr', ['pr_data' => $pr_data]);
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
