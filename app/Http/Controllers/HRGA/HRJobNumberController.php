<?php

namespace App\Http\Controllers\HRGA;

use Carbon\Carbon;
use App\Models\Client;
use App\Models\JobNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class HRJobNumberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index_client()
    {
        $client_data = DB::table('client')->where('deleted_at', '=', NULL)->get();
        return view('hr_ga.jobnumber.index_client', ['client_data' => $client_data]);
    }

    public function store_client(Request $request)
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
                return redirect()->route('index_client_hr_ga');
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error Delete data : ',
                    'errors'    => $ex
                ], 401);

                Alert::warning('Warning', 'Failed to add new Client !!');
                return redirect()->route('index_client_hr_ga');
            }
        }
    }

    public function edit_client(string $id)
    {
        $client_data = Client::find($id);
        return response()->json($client_data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_client(Request $request, string $id)
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
                return redirect()->route('index_client_hr_ga');
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error : ',
                    'errors'    => $ex
                ], 401);
                Alert::error('Error', 'Error Update Client Data');
                return redirect()->route('index_client_hr_ga');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy_client(string $id)
    {
        $client_data = Client::where('id_client', '=', $id)->first();
        try {
            $client_data->delete();
            Alert::success('Success', 'Delete Data Successfully');
            return redirect()->route('index_client_hr_ga');
        } catch (\Exception $th) {
            return response()->json([
                'status'    => false,
                'message'   => 'Error Delete : ',
                'errors'    => $th
            ], 401);
            Alert::error('error', 'Failed to Delete Data!!');
            return redirect()->route('index_client_hr_ga');
        }
    }

    public function index_jn()
    {
        $jn_data = DB::table('jobnumber')
            ->join('client', 'jobnumber.id_client', '=', 'client.id_client')
            ->where('jobnumber.deleted_at', '=', NULL)
            ->orderBy('jobnumber.id_jn', 'desc')->get();
        $data_client = DB::table('client')->where('client.deleted_at', '=', NULL)->orderBy('client.id_client', 'asc')->get();
        $latest_jn = DB::table('jobnumber')
            ->join('client', 'jobnumber.id_client', '=', 'client.id_client')
            ->where('jobnumber.deleted_at', '=', NULL)
            ->orderBy('jobnumber.id_jn', 'desc')->limit(1)->get();
        return view('hr_ga.jobnumber.index_jn', compact('jn_data', 'data_client', 'latest_jn'));
    }

    public function index_old_jn()
    {
        $jn_data = DB::table('old_jobnumber')
            ->join('client', 'old_jobnumber.id_client', '=', 'client.id_client')
            ->where('old_jobnumber.deleted_at', '=', NULL)
            ->orderBy('old_jobnumber.id_jn', 'desc')->get();
        $data_client = DB::table('client')->where('client.deleted_at', '=', NULL)->orderBy('client.id_client', 'asc')->get();
        return view('admin.jobNumber.index_old', ['jn_data' => $jn_data]);
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
    public function store_jn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'txt_jn'      => 'required',
            'txt_pic'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validator->errors()
            ], 401);
        } else {
            try {
                JobNumber::create([
                    'id_client'         => $request->txt_comp,
                    'bulan'             => Carbon::now()->month,
                    'job_number'        => $request->txt_jn,
                    'contract_no'       => $request->txt_contract,
                    'amount'            => $request->txt_amount,
                    'program'           => $request->txt_program_name,
                    'c_p'               => $request->txt_cp,
                    'hours'             => $request->txt_hours,
                    'pic'               => $request->txt_pic,
                    'instructor'        => $request->txt_instructor,
                    'day_training'      => $request->txt_day_start,
                    'day_training2'     => $request->txt_day_end,
                    'starting_date'     => $request->txt_start_date,
                    'ending_date'       => $request->txt_end_date,
                    'teacher_comp'      => $request->txt_teacher_comp,
                    'total_manday'      => $request->txt_total_day,
                    'remarks'           => $request->txt_remarks,
                    'username'          => Auth::user()->name,
                ]);
                Alert::success('Success', 'Data Created Successfully');
                return redirect()->route('index_jn_hr_ga');
            } catch (\Exception $th) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error Store : ',
                    'errors'    => $th
                ], 401);
                // Alert::success('error', 'Failed to Create Data!!');
                // return redirect()->route('index_jn_hr_ga');
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

    public function refresh_jn_hr_ga()
    {
        $latest_jn = DB::table('jobnumber')->where('jobnumber.deleted_at', '=', NULL)->orderBy('jobnumber.id_jn', 'desc')->limit(1)->get();
        foreach ($latest_jn as $data) {
            $id_jn = $data->id_jn;
        }
        // $find_lates = JobNumber::find($id_jn);
        $find_lates = JobNumber::find($id_jn);
        // dd(['latest_jn' => $latest_jn]);
        return response()->json($find_lates);
    }
}
