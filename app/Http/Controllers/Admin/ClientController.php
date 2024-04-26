<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;


class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client_data = DB::table('client')->where('deleted_at', '=', NULL)->get();
        return view('admin.client.index', ['client_data' => $client_data]);
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
            'txt_comp_name' => 'required',
            'txt_comp_add' => 'required',
            'txt_comp_kota' => 'required',
            'txt_comp_name_up' => 'required',
            'txt_phone_comp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validator->errors()
            ], 401);
        } else {
            try {
                Client::create([
                    'nama_perusahaan'   => $request->txt_comp_name,
                    'almt_perusahaan'   => $request->txt_comp_add,
                    'npwp'              => $request->txt_comp_npwp,
                    'almt_npwp'         => $request->txt_comp_npwp_add,
                    'kota'              => $request->txt_comp_kota,
                    'kodepos'           => $request->txt_comp_kode_pos,
                    'nama_up'           => $request->txt_comp_name_up,
                    'jabatan_up'        => $request->txt_jbt_comp_up,
                    'phone'             => $request->txt_phone_comp,
                    'username'          => Auth::user()->name,
                    'created_at'        => date('Y-m-d h:i:s'),
                    'updated_at'        => date('Y-m-d h:i:s')
                ]);
                Alert::success('Success', 'New Client Added');
                return redirect()->route('index_client_admin');
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error Delete data : ',
                    'errors'    => $ex
                ], 401);

                Alert::warning('Warning', 'Failed to add new Client !!');
                return redirect()->route('index_client_admin');
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
        $client_data = Client::find($id);
        return response()->json($client_data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client_data = Client::where('id_client', '=', $request->txt_client_id)->first();
        $validator = Validator::make($request->all(), [
            'update_txt_comp_name' => 'required',
            'update_txt_comp_add' => 'required',
            'update_txt_comp_kota' => 'required',
            'update_txt_comp_name_up' => 'required',
            'update_txt_phone_comp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validator->errors()
            ], 401);
        } else {
            try {
                $client_data->update([
                    'nama_perusahaan'   => $request->update_txt_comp_name,
                    'almt_perusahaan'   => $request->update_txt_comp_add,
                    'npwp'              => $request->update_txt_comp_npwp,
                    'almt_npwp'         => $request->update_txt_comp_npwp_add,
                    'kota'              => $request->update_txt_comp_kota,
                    'kodepos'           => $request->update_txt_comp_kode_pos,
                    'nama_up'           => $request->update_txt_comp_name_up,
                    'jabatan_up'        => $request->update_txt_jbt_comp_up,
                    'phone'             => $request->update_txt_phone_comp,
                    'updated_at'        => date('Y-m-d h:i:s')
                ]);
                Alert::success('Success', 'Successfully Update Client Data');
                return redirect()->route('index_client_admin');
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error : ',
                    'errors'    => $ex
                ], 401);
                Alert::error('Error', 'Error Update Client Data');
                return redirect()->route('index_client_admin');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client_data = Client::where('id_client', '=', $id)->first();
        try {
            $client_data->delete();
            Alert::success('Success', 'Delete Data Successfully');
            return redirect()->route('index_client_admin');
        } catch (\Exception $th) {
            return response()->json([
                'status'    => false,
                'message'   => 'Error Delete : ',
                'errors'    => $th
            ], 401);
            Alert::error('error', 'Failed to Delete Data!!');
            return redirect()->route('index_client_admin');
        }
    }
}
