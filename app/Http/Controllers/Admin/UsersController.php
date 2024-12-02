<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users_data = DB::table('users')
            ->join('employee', 'employee.id_users', '=', 'users.id')
            ->whereBetween('users.user_level', [1, 4])
            ->orderBy('users.user_level', 'ASC')->get();
        return view('admin.users_management.index', ['users_data' => $users_data]);
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
            'employee_name'             => 'required',
            'employee_personal_email'   => 'required',
            'epmloyee_work_email'       => 'required',
            'employee_bank_number'      => 'required',
            'employee_phone'            => 'required',
            'employee_address'          => 'required',
            'employee_sex'              => 'required',
            'employee_dob'              => 'required',
            'employee_nik'              => 'required',
            'employee_contract'         => 'required',
            'employee_marriage'         => 'required',
            'employee_email'            => 'required',
            'employee_password'         => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validator->errors()
            ], 401);
            Alert::error('Failed', 'Please Fill The Empty Field !!!');
            return redirect()->route('index_users');
        } else {
            User::create([
                'name'                  => $request->employee_name,
                'email'                 => $request->employee_email,
                'password'              => Hash::make($request->employee_password),
                'user_level'            => $request->employee_level,
                'created_at'            => date('Y-m-d h:i:s'),
                'updated_at'            => date('Y-m-d h:i:s'),
                // 'profile_photo_path'    => $nama_file
            ]);
            $get_id = DB::table('users')->select('id')->orderBy('id', 'asc')->get();
            foreach ($get_id as $items) {
                $id_users = $items->id;
            }
            $level = $request->employee_level;

            switch ($level) {
                case '1':
                    $jabatan = "Director";
                    break;
                case '2':
                    $jabatan = "Manager";
                    break;
                case '3':
                    $jabatan = "Users";
                    break;
                case '4':
                    $jabatan = "HR/GA";
                    break;
                default:
                    break;
            }

            Employee::create([
                'id_users'              => $id_users,
                'personal_email'        => $request->employee_personal_email,
                'emp_position'          => $jabatan,
                'emp_division'          => $request->employee_division,
                'place_birth'           => $request->employee_birth,
                'birth_date'            => $request->employee_dob,
                'sex'                   => $request->employee_sex,
                'nik'                   => $request->employee_nik,
                'npwp'                  => $request->employee_npwp,
                'bank_acc'              => $request->employee_bank_number,
                'bpjs_kes'              => $request->employee_bpjs_kes,
                'bpjs_ket'              => $request->employee_bpjs_tk,
                'date_joined'           => $request->employee_date_join,
                // 'emp_work_email'        => $request->employee_work_email,
                'status_kontrak'        => $request->employee_contract,
                'status_nikah'          => $request->employee_marriage,
                'emp_address'           => $request->employee_address,
                'emp_phone'             => $request->employee_phone,
                'emp_phone_emergency'   => $request->employee_phone,
                'created_at'            => date('Y-m-d h:i:s'),
                'updated_at'            => date('Y-m-d h:i:s'),
            ]);
            Alert::success('Success', 'Insert Data Successfully');
            return redirect()->route('index_users');
            try {

                // }
            } catch (\Exception $th) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error : ',
                    'errors'    => $th
                ], 401);
                Alert::warning('Warning', 'Failed to create Users Data');
                return redirect()->route('index_users');
                $user_delete = User::where('id', '=', $id_users)->first();
                try {
                    $user_delete->delete();
                    Alert::warning('Warning', 'Failed to create Users Data');
                } catch (\Exception $th) {
                    return response()->json([
                        'status'    => false,
                        'message'   => 'Error Deletes : ',
                        'errors'    => $th
                    ], 401);
                }
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data_users = DB::table('users')
            ->join('employee', 'employee.id_users', '=', 'users.id')
            ->where('users.id', '=', $id)->get();
        return view('components.modals.admin_area.users_show', ['data_users' => $data_users]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $edit_users = DB::table('users')
            ->join('employee', 'employee.id_users', '=', 'users.id')
            ->where('users.id', '=', $id)->get();
        return view('components.modals.admin_area.users_update', ['edit_users' => $edit_users]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
    public function update_status_users(string $id)
    {
        $users_data = User::where('id', '=', $id)->get();
        $employee_data = Employee::where('id_users', '=', $id)->get();
        // dd($employee_data);
        $users_data->update([
            'updated_at'        => date('Y-m-d h:i:s'),
            'deleted_at'        => NULL,
        ]);
        $employee_data->update([
            'updated_at'        => date('Y-m-d h:i:s'),
            'deleted_at'        => NULL,
        ]);
        Alert::success('Success', 'Update Data Successfully');
        return redirect()->route('index_users');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $users_data = User::where('id', '=', $id)->first();
        $employee_data = Employee::where('id_users', '=', $id)->first();
        try {
            $users_data->delete();
            $employee_data->delete();
            Alert::success('Success', 'Delete Data Successfully');
            return redirect()->route('index_users');
        } catch (\Exception $th) {
            return response()->json([
                'status'    => false,
                'message'   => 'Error Delete : ',
                'errors'    => $th
            ], 401);
            Alert::error('error', 'Failed to Delete Data!!');
            return redirect()->route('index_users');
        }
    }

    public function sendEmailUsersInformation($id_users)
    {
        $users = $id_users;
        $get_users_data = DB::table('users')
            ->join('employee', 'employee.id_users', '=', 'users.id')
            ->where('users.id', '=', $users)->get();
        foreach ($get_users_data as $users_data) {
            $emp_name = $users_data->name;
            $emp_email = $users_data->email;
            $emp_pass = 'semangat45';
        }
        Mail::send(
            'emails.user_info_send',
            [
                'fullname'  => $emp_name,
                'email'     => $emp_email,
                'passowrd'  => $emp_pass
            ],
            function ($mail, $emp_email) {
                // $mail->to($manager_email);
                $to = $emp_email;
                $mail->to($to);
                $mail->from(config('mail.from.name'));
                $mail->subject('SATUPINTU - APP | Login Information');
            }
        );
    }
}
