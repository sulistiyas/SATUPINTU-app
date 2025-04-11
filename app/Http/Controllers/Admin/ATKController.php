<?php

namespace App\Http\Controllers\Admin;

use App\Models\ATK_Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ATK_Log;
use Illuminate\Support\Facades\Auth;
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

    public function index_atk_in()
    {
        $atk_in_list = DB::table('atk_master')->orderBy('atk_name', 'ASC')->get();
        $atk_item = DB::table('atk_master')->orderBy('atk_name', 'ASC')->get();
        return view('admin.atk.index_in', compact('atk_in_list', 'atk_item'));
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
                if (Auth::user()->user_level == '0') {
                    return redirect()->route('index_atk_master');
                } elseif (Auth::user()->user_level == '4') {
                    return redirect()->route('index_atk_master_hr_ga');
                }
                
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error add data : ',
                    'errors'    => $ex
                ], 401);

                Alert::warning('Warning', 'Failed to add new ATK !!');
                if (Auth::user()->user_level == '0') {
                    return redirect()->route('index_atk_master');
                } elseif (Auth::user()->user_level == '4') {
                    return redirect()->route('index_atk_master_hr_ga');
                }
                
            }
        }
    }

    public function store_atk_in(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'txt_atk_qty' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validator->errors()
            ]);
        } else {
            $id_atk = $request->txt_atk_id;
            $qty_atk = $request->txt_qty;
            try {
                ATK_Log::create([
                    'log_type'          => "ATK_in",
                    'id_atk'            => $id_atk,
                    'qty_log'           => $qty_atk,
                    'date_log'          => date('Y-m-d'),
                    'time_log'          => date('h:i:s'),
                    'id_employee'       => Auth::user()->id,
                    'created_at'        => date('Y-m-d h:i:s'),
                    'updated_at'        => date('Y-m-d h:i:s')
                ]);

                $atk_data = ATK_Master::where('id_atk', '=', $id_atk)->first();
                $atk_data->update([
                    'atk_stok'      => $qty_atk,
                    'updated_at'    => date('Y-m-d h:i:s')
                ]);
                Alert::success('Success', 'ATK Stock Updated');
                if (Auth::user()->user_level == '0') {
                    return redirect()->route('index_atk_in');
                } elseif (Auth::user()->user_level == '4') {
                    return redirect()->route('index_atk_in_hr_ga');
                }
                
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error add data : ',
                    'errors'    => $ex
                ], 401);

                Alert::warning('Warning', 'Failed to add new ATK !!');
                if (Auth::user()->user_level == '0') {
                    return redirect()->route('index_atk_in');
                } elseif (Auth::user()->user_level == '4') {
                    return redirect()->route('index_atk_in_hr_ga');
                }
                
            }
        }
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
        $atk_data = ATK_Master::find($id);
        return response()->json($atk_data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'edit_atk_name' => 'required',
            'edit_atk_brand' => 'required',
            'edit_atk_stock' => 'required',
            'edit_atk_unit' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validator->errors()
            ]);
        } else {
            ATK_Master::where('id_atk', '=', $request->edit_atk_id)->update([
                'atk_name'          => $request->edit_atk_name,
                'atk_brand'         => $request->edit_atk_brand,
                'atk_stock'         => $request->edit_atk_stock,
                'atk_unit'          => $request->edit_atk_unit,
                'updated_at'        => date('Y-m-d h:i:s')
            ]);
            Alert::success('Success', 'ATK Updated');
            if (Auth::user()->user_level == '0') {
                return redirect()->route('index_atk_master');
            } elseif (Auth::user()->user_level == '4') {
                return redirect()->route('index_atk_master_hr_ga');
            }
            // try {
                
                
            // } catch (\Exception $ex) {
            //     return response()->json([
            //         'status'    => false,
            //         'message'   => 'Error update data : ',
            //         'errors'    => $ex
            //     ], 401);

            //     Alert::warning('Warning', 'Failed to update ATK !!');
            //     if (Auth::user()->user_level == '0') {
            //         return redirect()->route('index_atk_master');
            //     } elseif (Auth::user()->user_level == '4') {
            //         return redirect()->route('index_atk_master_hr_ga');
            //     }
                
            // }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
