<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\PurchaseRequest;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use RealRashid\SweetAlert\Facades\Alert;

class EPurchaseManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id_users = Auth::user()->id;
        $get_div = DB::table('employee')->where('id_users', '=', $id_users)->where('deleted_at', '=', NULL)->get();
        foreach ($get_div as $item) {
            $division = $item->emp_division;
        }
        $get_pr_data = DB::table('pr')
            ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->where('employee.emp_division', '=', $division)
            ->where('pr.deleted_at', '=', NULL)
            ->groupBy('pr.pr_no')->get();
        return view('manager.includes.ePurchase.index_pr', ['data' => $get_pr_data]);
    }

    public function approve_pr_manager(Request $request)
    {
        $pr_approval = $request->btn_approval;
        $pr_no = $request->txt_pr_no;

        if ($pr_approval == "approve_pr") {
            try {
                $status = "Approved";
                $pr_data = PurchaseRequest::where('pr_no', '=', $pr_no)->update([
                    'pr_status'     => '3',
                    'updated_at'    => date('Y-m-d h:i:s')
                ]);
                return $this->SendMailPRAction($pr_no, $status);

                Alert::success('Success', 'Successfully Approve PR');
                return redirect()->route('index_pr_manager');
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error : ',
                    'errors'    => $ex
                ], 401);
                // Alert::success('Danger', 'Failed Approve Request');
                // return redirect()->route('index_pr_manager');
            }
        } else if ($pr_approval == "reject_pr") {
            try {
                $status = "Rejected";
                $pr_data = PurchaseRequest::where('pr_no', '=', $pr_no)->update([
                    'pr_status'     => '5',
                    'updated_at'    => date('Y-m-d h:i:s')
                ]);
                return $this->SendMailPRAction($pr_no, $status);
                Alert::success('Danger', 'PR Rejected !!!');
                return redirect()->route('index_pr_manager');
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error : ',
                    'errors'    => $ex
                ], 401);
                Alert::success('Danger', 'Failed Approve Request');
                return redirect()->route('index_pr_manager');
            }
        }
    }

    public function reject_pr_manager(Request $request)
    {
        // 
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
    public function show_modal_pr_manager(string $id)
    {
        $pr_data = DB::table('pr')
            ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->where('pr.pr_no', '=', $id)->get();
        return view('components.modals.pr_manager_show', ['data_pr' => $pr_data]);
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

    public function SendMailPRAction($pr_no, $status)
    {
        try {

            $emp_data = DB::table('pr')
                ->join('users', 'users.id', '=', 'pr.id_employee')
                ->where('pr.pr_no', '=', $pr_no)->get();
            foreach ($emp_data as $item_emp) {
                $emp_name = $item_emp->name;
            }

            $manager_data = DB::table('pr')
                ->join('users', 'users.id', '=', 'pr.id_manager')
                ->where('pr.pr_no', '=', $pr_no)->get();
            foreach ($manager_data as $item_mng) {
                $manager_name = $item_mng->name;
            }

            $data_request = DB::table('pr')->where('pr.pr_no', '=', $pr_no)->get();
            Mail::send('emails.pr_send_manager', [
                'fullname'      => $emp_name,
                'manager'       => $manager_name,
                'data'          => $data_request,
                'pr_no'         => $pr_no,
                'status'        => $status
            ], function ($mail) {
                $id_users = Auth::user()->id;
                $emp_data   = DB::table('employee')
                    ->join('users', 'users.id', '=', 'employee.id_users')
                    ->where('id_users', '=', $id_users)->get();
                foreach ($emp_data as $item_emp) {
                    $emp_div = $item_emp->emp_division;
                }

                $manager_data = DB::table('employee')
                    ->join('users', 'users.id', '=', 'employee.id_users')
                    ->where('emp_division', '=', $emp_div)
                    ->where('emp_position', '=', "Manager")->get();
                foreach ($manager_data as $manager) {
                    $manager_email = $manager->email;
                }

                $ga_data = DB::table('users')
                    ->where('user_level', '=', '0')
                    ->where('deleted_at', '=', NULL)->get();
                foreach ($ga_data as $data_ga) {
                    $GA_email = $data_ga->email;
                }
                // $mail->to($manager_email);
                $mail->to('sulis.nugroho@inlingua.co.id');
                // $mail->cc($GA_email);
                $mail->cc('sulis.nugroho@inlingua.co.id');
                $mail->from(config('mail.from.name'));
                $mail->subject('SATUPINTU - APP | Purchase Request Order');
            });
            if ($status == "Approved") {
                Alert::success('Success', 'PR Submitted Successfully');
                return redirect()->route('index_pr_manager');
            } elseif ($status == "Rejected") {
                Alert::danger('Warning', 'PR Rejected');
                return redirect()->route('index_pr_manager');
            }
        } catch (\Exception $th) {
            return response()->json([
                'status'    => false,
                'message'   => 'Error Send mail : ',
                'errors'    => $th
            ], 401);
            Alert::error('error', 'Failed to Create Data!!');
            return redirect()->route('index_pr_manager');
        }
    }
}
