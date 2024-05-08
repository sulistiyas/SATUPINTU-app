<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\JobNumber;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class JobNumberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
        return view('admin.jobNumber.index', compact('jn_data', 'data_client', 'latest_jn'));
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
                return redirect()->route('index_jn_admin');
            } catch (\Exception $th) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error Store : ',
                    'errors'    => $th
                ], 401);
                // Alert::success('error', 'Failed to Create Data!!');
                // return redirect()->route('index_jn_admin');
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
        $jn_data = JobNumber::find($id);
        return response()->json($jn_data);
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
}
