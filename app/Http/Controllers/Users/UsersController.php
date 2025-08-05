<?php

namespace App\Http\Controllers\Users;

use Carbon\Carbon;
use App\Models\OldPR;
use App\Models\Client;
use App\Models\JobNumber;
use App\Models\LetterNumber;
use App\Models\OldJobnumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class UsersController extends Controller
{
    // Client
    public function index_client_users()
    {
        $client_data = DB::table('client')->where('deleted_at', '=', NULL)->get();
        return view('users.index_client', ['client_data' => $client_data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store_client_users(Request $request)
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
                return redirect()->route('index_client_users');
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error Create data : ',
                    'errors'    => $ex
                ], 401);

                Alert::warning('Warning', 'Failed to add new Client !!');
                return redirect()->route('index_client_users');
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit_client_users(string $id)
    {
        $client_data = Client::find($id);
        return response()->json($client_data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_client_users(Request $request, string $id)
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
    public function destroy_client_users(string $id)
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

    public function index()
    {
        //
    }

    // JobNumber
    public function index_jn_users()
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
        return view('users.index_jn', compact('jn_data', 'data_client', 'latest_jn'));
    }

    public function index_jn_old_users()
    {
        $jn_data = DB::table('old_jobnumber')
            ->join('client', 'old_jobnumber.id_client', '=', 'client.id_client')
            ->where('old_jobnumber.deleted_at', '=', NULL)
            ->orderBy('old_jobnumber.id_jn', 'desc')->get();
        $data_client = DB::table('client')->where('client.deleted_at', '=', NULL)->orderBy('client.id_client', 'asc')->get();
        return view('users.index_old_jn', ['jn_data' => $jn_data]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store_jn_users(Request $request)
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
                return redirect()->route('index_jn_users');
            } catch (\Exception $th) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error Store : ',
                    'errors'    => $th
                ], 401);
                Alert::success('error', 'Failed to Create Data!!');
                return redirect()->route('index_jn_users');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show_jn_users(string $id)
    {
        // $old_jn_data = OldJobnumber::find($id);
        // return response()->json($old_jn_data);
        $jn_data = DB::table('jobnumber')
            ->join('client', 'client.id_client', '=', 'jobnumber.id_client')
            ->where('jobnumber.id_jn', '=', $id)->get();
        return $jn_data[0];
    }
    public function show_jn_old_users(string $id)
    {
        // $old_jn_data = OldJobnumber::find($id);
        // return response()->json($old_jn_data);
        $old_jn_data = DB::table('old_jobnumber')
            ->join('client', 'client.id_client', '=', 'old_jobnumber.id_client')
            ->where('old_jobnumber.id_jn', '=', $id)->get();
        return $old_jn_data[0];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit_jn_users(string $id)
    {
        $jn_data = JobNumber::find($id);
        return response()->json($jn_data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_jn_users(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy_jn_users(string $id)
    {
        //
    }

    public function refresh_jn_users()
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

    // Letter Number
    public function index_letter_users()
    {
        $letter_number = DB::table('letter_number')
            ->join('employee', 'employee.id_employee', '=', 'letter_number.username')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->orderBy('id_letter', 'DESC')->get();
        return view('users.index_letter_users', ['letter_number' => $letter_number]);
    }

    public function store_letter_users(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'txt_nomor_urut' => 'required',
            'txt_comp' => 'required',
            'txt_type' => 'required',
            'txt_form' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validator->errors()
            ]);
        } else {
            try {
                $latest_id = LetterNumber::whereRaw('id_letter = (select max(`id_letter`) from letter_number)')->get();
                foreach ($latest_id as $id) {
                    $last_id = $id->id_letter;
                }
                $latest_number = DB::table('letter_number')->where('id_letter', '=', $last_id)->get();

                foreach ($latest_number as $lat_num) {
                    $nomor_urut = $lat_num->nomor_urut;
                }

                $nomor_urut_plus = $nomor_urut + 1;
                $bln_num = date('n');
                $thn = date('y');
                $get_users = DB::table('employee')->where('id_users', '=', Auth::user()->id)->get();
                foreach ($get_users as $users_id) {
                    $id = $users_id->id_employee;
                }
                $users = $id;
                switch ($bln_num) {
                    case '1':
                        $bln = "I";
                        break;
                    case '2':
                        $bln = "II";
                        break;
                    case '3':
                        $bln = "III";
                        break;
                    case '4':
                        $bln = "IV";
                        break;
                    case '5':
                        $bln = "V";
                        break;
                    case '6':
                        $bln = "VI";
                        break;
                    case '7':
                        $bln = "VII";
                        break;
                    case '8':
                        $bln = "VIII";
                        break;
                    case '9':
                        $bln = "IX";
                        break;
                    case '10':
                        $bln = "X";
                        break;
                    case '11':
                        $bln = "XI";
                        break;
                    case '12':
                        $bln = "XII";
                        break;
                    default:
                        # code...
                        break;
                }
                $nomor_surat = $nomor_urut_plus . "/" . $request->txt_type . "/" . $request->txt_comp . "/" . $bln . "/" . $thn;
                LetterNumber::create([
                    'nomor_surat'       => $nomor_surat,
                    'nomor_urut'        => $nomor_urut_plus,
                    'tipe_srt'          => $request->txt_type,
                    'comp'              => $request->txt_form,
                    'nama_perusahaan'   => $request->txt_comp,
                    'bln'               => $bln,
                    'thn'               => $thn,
                    'username'          => $users,
                    'created_at'        => date('Y-m-d h:i:s'),
                    'updated_at'        => date('Y-m-d h:i:s')
                ]);
                Alert::success('Success', 'New Letter Number Added');
                return redirect()->route('index_letter_number_users');
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error add data : ',
                    'errors'    => $ex
                ], 401);
                Alert::warning('Warning', 'Failed to add Letter Number !!');
                return redirect()->route('index_letter_number_users');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show_letter_users()
    {
        $prefix = "0";
        $latest_number = IdGenerator::generate(['table' => 'letter_number', 'field' => 'nomor_urut', 'length' => 4, 'prefix' => $prefix, 'reset_on_prefix_change' => true]);
        return view('components.modals.letter_number_form', ['latest_number' => $latest_number]);
    }

    public function refresh_last_number_letter_users()
    {
        $latest_id = LetterNumber::whereRaw('id_letter = (select max(`id_letter`) from letter_number)')->get();
        foreach ($latest_id as $id) {
            $last_id = $id->id_letter;
        }
        $latest_number = DB::table('letter_number')->where('id_letter', '=', $last_id)->get();
        return view('components.modals.admin_area.test', ['latest_number' => $latest_number]);
    }

    public function get_old_pr_users()
    {
        return DataTables::of(OldPR::query()->orderBy('id_pr', 'DESC'))->toJson();
    }
    public function index_old_pr_users()
    {
        return view('users.epurchase.old_pr');
        // $get_data = DB::table('tbl_pr')->orderBy('id_pr', 'desc')->get();
        // return view('admin.ePurchase.old_pr', ['old_pr' => $get_data]);
    }

    public function index_office_legalitas_users()
    {
        $office_legalitas = DB::table('legalitas_office')->orderBy('id_legalitas', 'DESC')->get();
        return view('users.index_legalitas', ['office_legalitas' => $office_legalitas]);
    }
}
