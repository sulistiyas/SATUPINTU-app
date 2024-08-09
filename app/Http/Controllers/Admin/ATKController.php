<?php

namespace App\Http\Controllers\Admin;

use App\Models\ATK_Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class ATKController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $atk_list = DB::table('atk_master')->orderBy('atk_name', 'ASC')->get();
        return view('admin.atk.index', ['atk_list' => $atk_list]);
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
        $validator = Validator::make($request->all(), [
            'atk_name' => 'required',
            'atk_brand' => 'required',
            'atk_stock' => 'required',
            'atk_unit' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validator->errors()
            ]);
        } else {
            try {
                ATK_Master::create([
                    'atk_name'          => $request->atk_name,
                    'atk_brand'         => $request->atk_brand,
                    'atk_stock'         => $request->atk_stock,
                    'atk_unit'          => $request->atk_unit,
                    'created_at'        => date('Y-m-d h:i:s'),
                    'updated_at'        => date('Y-m-d h:i:s')
                ]);
                Alert::success('Success', 'New ATK Added');
                return redirect()->route('index_atk_master');
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error add data : ',
                    'errors'    => $ex
                ], 401);

                Alert::warning('Warning', 'Failed to add new ATK !!');
                return redirect()->route('index_atk_master');
            }
        }
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
