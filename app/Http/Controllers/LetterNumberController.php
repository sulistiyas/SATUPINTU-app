<?php

namespace App\Http\Controllers;

use App\Models\LetterNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class LetterNumberController extends Controller
{
    public function index_letter_number()
    {
        $letter_number = DB::table('letter_number')
            ->join('employee', 'employee.id_employee', '=', 'letter_number.username')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->orderBy('id_letter', 'DESC')->get();
        return view('layouts.letter_number.index', ['letter_number' => $letter_number]);
    }

    public function store_letter_number(Request $request)
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
                $latest_id = LetterNumber::whereRaw('id_letter = (select max(`id_letter`) from letter_number)')->get();
                if ($latest_id->isEmpty()) {
                    $last_id = 0;
                } else {
                    $last_id = $latest_id->first()->id_letter;
                }
                
                // foreach ($latest_id as $id) {
                //     $last_id = $id->id_letter;
                // }
                
                $latest_number = DB::table('letter_number')->where('id_letter', '=', $last_id)->get();
                if ($latest_number->isEmpty()) {
                    $nomor_urut = 0;
                } else {
                    $nomor_urut = $latest_number->first()->nomor_urut;
                }
                // foreach ($latest_number as $lat_num) {
                //     $nomor_urut = $lat_num->nomor_urut;
                // }

                

                // $nomor_urut_plus = $nomor_urut + 1;
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
                $nomor_surat = $request->txt_nomor_urut . "/" . $request->txt_type . "/" . $request->txt_comp . "/" . $bln . "/" . $thn;
                LetterNumber::create([
                    'nomor_surat'       => $nomor_surat,
                    'nomor_urut'        => $request->txt_nomor_urut,
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
                return redirect()->route('index_letter_number');
            try {
                
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error add data : ',
                    'errors'    => $ex
                ], 401);
                Alert::warning('Warning', 'Failed to add Letter Number !!');
                return redirect()->route('index_letter_number');
            }
        }
    }
    public function show_modal_create_letter_number()
    {
        $prefix = "0";
        $latest_number = IdGenerator::generate(['table' => 'letter_number', 'field' => 'nomor_urut', 'length' => 4, 'prefix' => $prefix]);
        return view('components.modals.letter_number_form', ['latest_number' => $latest_number]);
    }

    public function refresh_last_number()
    {
        $prefix = "0";
        $latest_number = IdGenerator::generate(['table' => 'letter_number', 'field' => 'nomor_urut', 'length' => 4, 'prefix' => $prefix]);

        return view('components.modals.admin_area.test', ['latest_number' => $latest_number]);
    }
}
