<?php

namespace App\Http\Controllers;

use App\Models\ATK_Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
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

    public function index_request()
    {   
        $user_id = Auth::user()->id;
        $atk_request_data = DB::table('atk_request_log')
            ->join('users', 'atk_request_log.user_id', '=', 'users.id')
            ->join('atk_master', 'atk_request_log.atk_id', '=', 'atk_master.id_atk')
            ->select('*', 'users.name as user_name')
            ->where('users.id', $user_id)
            ->orderBy('atk_request_log.created_at', 'DESC')
            ->get();
        $atk_master = DB::table('atk_master')->get();

        if ($atk_request_data->isEmpty()) {
            Alert::info('Info', 'No ATK requests found.');
            return view('layouts.atk_request.index',compact('atk_request_data', 'atk_master'));
        }else {
            return view('layouts.atk_request.index',compact('atk_request_data', 'atk_master'));
        }

        
    }

    public function store_atk_request(Request $request)
    {
        if (!$request->has('atk_id') || !$request->has('quantity')) {
            Alert::error('Error', 'Please Select ATK Name and quantity are required.');
            return redirect()->back();
        }else{
            $validator = Validator::make($request->all(), [
                'atk_id' => 'required|exists:atk_master,id_atk',
                'quantity' => 'required|integer|min:1',
                'description' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'errors' => $validator->errors()
                ]);
                Alert::error('Error', 'Validation Error');
                return redirect()->back()->withErrors($validator)->withInput();
            }
            else{
                $user_id = Auth::user()->id;
                $atk_id = $request->atk_id;
                $quantity = $request->quantity;
                $description = $request->description;

                DB::table('atk_request_log')->insert([
                    'user_id' => $user_id,
                    'atk_id' => $atk_id,
                    'quantity' => $quantity,
                    'remarks' => $description,
                    'status' => '0',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                Alert::success('Success', 'ATK request submitted successfully.');
                return redirect()->route('index_atk_request');
            }
            
        }

        
    }
}
