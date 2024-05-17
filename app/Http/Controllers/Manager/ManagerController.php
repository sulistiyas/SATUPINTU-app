<?php

namespace App\Http\Controllers\Manager;

use Carbon\Carbon;
use App\Models\Client;
use App\Models\JobNumber;
use App\Models\OldJobnumber;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
        return view('manager.index_jn', compact('jn_data', 'data_client', 'latest_jn'));
    }

    public function index_old_jn()
    {
        $jn_data = DB::table('old_jobnumber')
            ->join('client', 'old_jobnumber.id_client', '=', 'client.id_client')
            ->where('old_jobnumber.deleted_at', '=', NULL)
            ->orderBy('old_jobnumber.id_jn', 'desc')->get();
        $data_client = DB::table('client')->where('client.deleted_at', '=', NULL)->orderBy('client.id_client', 'asc')->get();
        return view('manager.index_old_jn', ['jn_data' => $jn_data]);
    }

    public function show_jn_old_manager(string $id)
    {
        // $old_jn_data = OldJobnumber::find($id);
        // return response()->json($old_jn_data);
        $old_jn_data = DB::table('old_jobnumber')
            ->join('client', 'client.id_client', '=', 'old_jobnumber.id_client')
            ->where('old_jobnumber.id_jn', '=', $id)->get();
        return $old_jn_data[0];
    }

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
                // dd($request->txt_jn);
                Alert::success('Success', 'Data Created Successfully');
                return redirect()->route('index_jn_manager');
            } catch (\Exception $th) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error Store : ',
                    'errors'    => $th
                ], 401);
                Alert::success('error', 'Failed to Create Data!!');
                return redirect()->route('index_jn_manager');
            }
        }
    }

    public function refresh_jn()
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

    public function index_client()
    {
        $client_data = DB::table('client')->where('deleted_at', '=', NULL)->get();
        return view('manager.index_client', ['client_data' => $client_data]);
    }

    public function show_client(string $id)
    {
        $client_data = Client::find($id);
        return response()->json($client_data);
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
                return redirect()->route('index_client_manager');
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error Delete data : ',
                    'errors'    => $ex
                ], 401);

                Alert::warning('Warning', 'Failed to add new Client !!');
                return redirect()->route('index_client_manager');
            }
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
