<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Models\PurchaseRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class EPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index_pr_users()
    {
        $id_usr = Auth::user()->id;
        $get_data = DB::table('pr')
            ->leftJoin('po', 'po.id_pr', '=', 'pr.id_pr')
            ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->where('users.id', '=', $id_usr)
            ->where('pr.deleted_at', '=', NULL)
            ->groupBy('pr.pr_no')->get();
        return view('users.epurchase.index_pr_users', ['data' => $get_data]);
    }

    public function refresh_pr_users()
    {
        $id_pr = IdGenerator::generate(['table' => 'pr', 'field' => 'pr_no', 'length' => 13, 'prefix' => 'PR' . +date('Ymd')]);
        return view('components.modals.e-purchase.refresh_pr', ['id_pr' => $id_pr]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create_pr_users()
    {
        $id = IdGenerator::generate(['table' => 'pr', 'field' => 'pr_no', 'length' => 13, 'prefix' => 'PR' . +date('Ymd')]);
        $data = DB::table('jobnumber')->where('deleted_at', '=', NULL)->orderBy('id_jn', 'DESC')->get();
        return view('users.epurchase.create_pr_users', compact('id', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store_pr_users(Request $request)
    {
        try {
            $rows       = $request->rows;
            $pr_title   = $request->txt_pr_title;
            $desc       = $request->description;
            $qty        = $request->quantity;
            $unit       = $request->unit;
            $pr_no      = $request->txt_pr_number;
            $jn         = $request->txt_jn;
            $idusers    = Auth::user()->id;
            $division   = DB::table('employee')
                ->join('users', 'users.id', '=', 'employee.id_users')
                ->where('id_users', '=', $idusers)->get();
            foreach ($division as $item_div) {
                $emp_div = $item_div->emp_division;
                $emp_name = $item_div->name;
            }

            $id_manager = DB::table('employee')
                ->join('users', 'users.id', '=', 'employee.id_users')
                ->where('emp_division', '=', $emp_div)
                ->where('emp_position', '=', "Manager")->get();
            foreach ($id_manager as $manager) {
                $manager_id = $manager->id;
                $manager_name = $manager->name;
            }
            foreach ($rows as $key => $value) {
                $array_data[] = array(
                    'pr_no'                 => $pr_no,
                    'job_number'            => $jn,
                    'id_employee'           => $idusers,
                    'pr_title'              => $pr_title,
                    'pr_desc'               => $desc[$key],
                    'pr_qty'                => $qty[$key],
                    'pr_unit'               => $unit[$key],
                    'pr_status'             => 5,
                    'pr_date'               => date('Y-m-d'),
                    'id_manager'            => $manager_id,
                    'created_at'            => date('Y-m-d h:i:s'),
                );
            }
            // return view('emails.pr_send', [
            //     'fullname'      => $emp_name,
            //     'manager'       => $manager_name,
            //     'data'          => $array_data,
            //     'pr_no'         => $request->txt_pr_number,
            //     'job_number'    => $request->txt_jn,
            // ]);

            PurchaseRequest::insert($array_data);
            return $this->SendMailPR($idusers, $manager_id, $array_data, $pr_no, $jn);
            Alert::success('Success', 'PR Submitted Successfully');
            return redirect()->route('index_pr_users');
        } catch (\Exception $th) {
            return response()->json([
                'status'    => false,
                'message'   => 'Error Send mail : ',
                'errors'    => $th
            ], 401);
            Alert::error('error', 'Failed to Create Data!!');
            return redirect()->route('create_pr_users');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show_modal_pr_users($id)
    {
        // 
        $pr_data = DB::table('pr')
            ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->where('pr.pr_no', '=', $id)->get();
        // $pr_data = DB::table('pr')->where('pr_no', '=', $id)->get();
        return view('components.modals.pr_admin_show', ['data_pr' => $pr_data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit_pr_users(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_pr_users(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy_pr_users(string $id)
    {
        //
    }

    public function print_pr_users(Request $request)
    {
        $pr_no = $request->txt_pr_no;
        $data = ['pr_no' => $pr_no];
        $pdf = Pdf::loadView('components.pdf.pr_print', $data);
        // $pdf->loadHTML($pr_no);
        return $pdf->stream("$pr_no.pdf");
    }

    public function SendMailPR($idusers, $manager_id, $array_data, $pr_no, $jn)
    {
        try {
            $emp_data   = DB::table('employee')
                ->join('users', 'users.id', '=', 'employee.id_users')
                ->where('id_users', '=', $idusers)->get();
            foreach ($emp_data as $item_emp) {
                $emp_div = $item_emp->emp_division;
                $emp_name = $item_emp->name;
            }

            $manager_data = DB::table('employee')
                ->join('users', 'users.id', '=', 'employee.id_users')
                ->where('emp_division', '=', $emp_div)
                ->where('emp_position', '=', "Manager")->get();
            foreach ($manager_data as $manager) {
                $manager_name = $manager->name;
            }

            $ga_data = DB::table('users')
                ->where('user_level', '=', '4')
                ->where('deleted_at', '=', NULL)->get();
            foreach ($ga_data as $data_ga) {
                $GA_email = $data_ga->email;
                $GA_name = $data_ga->name;
            }
            Mail::send('emails.pr_send', [
                'fullname'      => $emp_name,
                'manager'       => $manager_name,
                'hr_ga'         => $GA_name,
                'data'          => $array_data,
                'pr_no'         => $pr_no,
                'job_number'    => $jn,
            ], function ($mail) {
                $id_users = Auth::user()->id;
                $emp_data   = DB::table('employee')
                    ->join('users', 'users.id', '=', 'employee.id_users')
                    ->where('id_users', '=', $id_users)->get();
                foreach ($emp_data as $item_emp) {
                    $emp_div = $item_emp->emp_division;
                }

                $ga_data = DB::table('users')
                    ->where('user_level', '=', '4')
                    ->where('deleted_at', '=', NULL)->get();
                foreach ($ga_data as $data_ga) {
                    $GA_email = $data_ga->email;
                }

                $manager_data = DB::table('employee')
                    ->join('users', 'users.id', '=', 'employee.id_users')
                    ->where('emp_division', '=', $emp_div)
                    ->where('emp_position', '=', "Manager")->get();
                foreach ($manager_data as $manager) {
                    $manager_email = $manager->email;
                }
                $mail->to($GA_email);
                $mail->cc('sulis.nugroho@inlingua.co.id');
                $mail->cc($manager_email);
                $mail->from(config('mail.from.name'));
                $mail->subject('SATUPINTU - APP | Purchase Request Order');
            });
            Alert::success('Success', 'PR Submitted Successfully');
            return redirect()->route('index_pr_users');
        } catch (\Exception $th) {
            return response()->json([
                'status'    => false,
                'message'   => 'Error Send mail : ',
                'errors'    => $th
            ], 401);
            Alert::error('error', 'Failed to Create Data!!');
            return redirect()->route('create_pr_users');
        }
    }
}
