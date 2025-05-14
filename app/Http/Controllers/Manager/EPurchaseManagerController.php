<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Haruncpi\LaravelIdGenerator\IdGenerator;

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

        $data = DB::table('pr')
            ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->where('employee.emp_division', '=', $division)
            ->where('pr.deleted_at', '=', NULL)
            ->orderBy('pr.created_at', 'desc')
            ->groupBy('pr.pr_no')->get();
        $count_data = $data->count();
        // dd($count_data);
        return view('manager.includes.ePurchase.index_pr', compact('data', 'count_data'));
        // dd($id_users);
    }

    public function approve_pr_manager_checkbox(Request $request){
        if ($request->ck_pr_no == null) {
            Alert::warning('Warning', 'Please Select Data');
            return redirect()->route('index_pr_manager');
        } else {
            $total_datas = count($request->ck_pr_no);
            $row_data[] = $request->total_data;
            for ($i = 0; $i < count($request->ck_pr_no); $i++){
                $array_data[] = array(
                    'pr_no' => $request->ck_pr_no[$i],
                );        
            }
            print_r($array_data);
        }
        
        
        
        $pr_approval    = $request->btn_approval;
        $pr_no          = $request->txt_pr_no;
        // $count_data     = $request->total_data;
        // $rows[]         = $count_data;

        if ($pr_approval == "approve_pr") {
                $status = "Approved";
                for ($j=0; $j < $total_datas; $j++) { 
                    $flag = DB::table('pr')->where('pr_no', '=', $request->ck_pr_no[$j])->get();
                    foreach ($flag as $item) {
                        $flag_data = $item->pr_status;
                    }
                    if ($flag_data == 4) {
                        Alert::warning('Warning', 'PR Already Approved');
                        return redirect()->route('index_pr_manager');
                    } else {
                        $pr_data = PurchaseRequest::where('pr_no', '=', $request->ck_pr_no[$j])->update([
                            'pr_status'     => '8',
                            'updated_at'    => date('Y-m-d h:i:s')
                        ]);
                    }
                    return $this->SendMailPRAction($pr_no, $status);
                }
                Alert::success('Success', 'Successfully Approve PR');
                return redirect()->route('index_pr_manager');
            // try {
                
            // } catch (\Exception $ex) {
            //     return response()->json([
            //         'status'    => false,
            //         'message'   => 'Error : ',
            //         'errors'    => $ex
            //     ], 401);
            //     Alert::success('Danger', 'Failed Approve Request');
            //     return redirect()->route('index_pr_manager');
            // }
        } else if ($pr_approval == "reject_pr") {
            try {
                $status = "Rejected";
                for ($j=0; $j < $total_datas; $j++) { 
                    $flag = DB::table('pr')->where('pr_no', '=', $request->ck_pr_no[$j])->get();
                    foreach ($flag as $item) {
                        $flag_data = $item->pr_status;
                    }
                    if ($flag_data == 6) {
                        Alert::warning('Warning', 'PR Already Rejected');
                        return redirect()->route('index_pr_manager');
                    } else {
                    $pr_data = PurchaseRequest::where('pr_no', '=', $request->ck_pr_no[$j])->update([
                        'pr_status'     => '6',
                        'updated_at'    => date('Y-m-d h:i:s')
                    ]);
                    return $this->SendMailPRAction($pr_no, $status);
                    }
                }
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
    public function approve_pr_manager(Request $request)
    {   
        // if ($request->ck_pr_no == null) {
        //     Alert::warning('Warning', 'Please Select Data');
        //     return redirect()->route('index_pr_manager');
        // } else {
        //     $total_datas = count($request->ck_pr_no);
        //     $row_data[] = $request->total_data;
        //     for ($i = 0; $i < count($request->ck_pr_no); $i++){
        //         $array_data[] = array(
        //             'pr_no' => $request->ck_pr_no[$i],
        //         );        
        //     }
        //     print_r($array_data);
        // }
        
        
        // $total_datas = count($request->ck_pr_no);
        $pr_approval    = $request->btn_approval;
        $pr_no          = $request->txt_pr_no;
        // $count_data     = $request->total_data;
        // $rows[]         = $count_data;

        if ($pr_approval == "approve_pr") {
            
            try {
                $status = "Approved";
                $pr_data = PurchaseRequest::where('pr_no', '=', $request->txt_pr_no)->update([
                    'pr_status'     => '4',
                    'updated_at'    => date('Y-m-d h:i:s')
                ]);
                // return $this->SendMailPRAction($pr_no, $status);
                // Alert::success('Success', 'Successfully Approve PR');
                // return redirect()->route('index_pr_manager');
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error : ',
                    'errors'    => $ex
                ], 401);
                Alert::success('Danger', 'Failed Approve Request');
                return redirect()->route('index_pr_manager');
            }
        } else if ($pr_approval == "reject_pr") {
            try {
                $status = "Rejected";
                $pr_data = PurchaseRequest::where('pr_no', '=', $request->txt_pr_no)->update([
                    'pr_status'     => '6',
                    'updated_at'    => date('Y-m-d h:i:s')
                ]);
                // return $this->SendMailPRAction($pr_no, $status);
                // Alert::success('Danger', 'PR Rejected !!!');
                // return redirect()->route('index_pr_manager');
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

    public function print_pr_manager(Request $request)
    {
        $pr_no = $request->txt_pr_no;
        $data = ['pr_no' => $pr_no];
        $pdf = Pdf::loadView('components.pdf.pr_print', $data);
        // $pdf->loadHTML($pr_no);
        return $pdf->stream("$pr_no.pdf");
    }

    public function print_po_manager(Request $request)
    {
        $po_no = $request->txt_po_no;
        $data = ['po_no' => $po_no];
        $pdf = Pdf::loadView('components.pdf.po_print', $data);
        // $pdf->loadHTML($po_no);
        return $pdf->stream("$po_no.pdf");
    }

    public function index_po()
    {

        $get_po_data = DB::table('pr')->select('*', 'pr.pr_no as pr_no_1')
            ->leftJoin('po', 'po.id_pr', '=', 'pr.id_pr')
            ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->where('pr.deleted_at', '=', NULL)
            ->orderBy('pr.created_at', 'desc')
            ->groupBy('pr.pr_no')->get();
        return view('manager.includes.ePurchase.index_po', ['data' => $get_po_data]);
    }

    public function approve_po_manager(Request $request)
    {
        $po_approval = $request->btn_approval;
        $po_no = $request->txt_po_no;
        $pr_no = $request->txt_pr_no;
        if ($po_approval == "approve_po") {

            try {
                $status = "Approved";
                $po_data = PurchaseOrder::where('po_no', '=', $po_no)->update([
                    'po_status'     => '1',
                    'updated_at'    => date('Y-m-d h:i:s')
                ]);

                $pr_data = PurchaseRequest::where('pr_no', '=', $pr_no)->update([
                    'pr_status'     => '1',
                    'updated_at'    => date('Y-m-d h:i:s')
                ]);
                //  Mail Data
                $emp_data = DB::table('po')
                    ->join('pr', 'pr.id_pr', '=', 'po.id_pr')
                    ->join('vendor', 'vendor.id_vendor', '=', 'po.id_vendor')
                    ->join('users', 'users.id', '=', 'pr.id_employee')->get();
                foreach ($emp_data as $emp) {
                    $emp_name = $emp->name;
                }
                $mng_data = DB::table('po')
                    ->join('pr', 'pr.id_pr', '=', 'po.id_pr')
                    ->join('vendor', 'vendor.id_vendor', '=', 'po.id_vendor')
                    ->join('users', 'users.id', '=', 'pr.id_manager')->get();
                foreach ($mng_data as $mng) {
                    $mng_name = $mng->name;
                }
                $po_data = DB::table('po')
                    ->join('pr', 'pr.id_pr', '=', 'po.id_pr')
                    ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
                    ->join('users', 'users.id', '=', 'employee.id_users')
                    ->where('po.po_no', '=', $po_no)->get();

                foreach ($po_data as $data_po) {
                    $disc = $data_po->po_disc;
                    $tax = $data_po->po_tax;
                }

                $sub_total = DB::table('po')->selectRaw('SUM(total_price) as sub_total')->where('po_no', '=', $po_no)->get();
                foreach ($sub_total as $subs) {
                    $sub = $subs->sub_total;
                }

                $a_disc = ($disc / 100) * $sub;
                $a_tax = ($tax / 100) * $sub;

                $grand_total = $sub - $a_disc + $a_tax;

                return $this->SendMailPOAction($emp_name, $mng_name, $po_data, $a_disc, $a_tax, $sub, $grand_total, $status);
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error : ',
                    'errors'    => $ex
                ], 401);
                Alert::success('Danger', 'Failed Approve Request');
                return redirect()->route('index_po_manager');
            }
        } else if ($po_approval == "reject_po") {
            try {
                $status = "Rejected";
                $po_data = PurchaseOrder::where('po_no', '=', $po_no)->update([
                    'po_status'     => '7',
                    'updated_at'    => date('Y-m-d h:i:s')
                ]);

                $pr_data = PurchaseRequest::where('pr_no', '=', $pr_no)->update([
                    'pr_status'     => '7',
                    'updated_at'    => date('Y-m-d h:i:s')
                ]);
                //  Mail Data
                $emp_data = DB::table('po')
                    ->join('pr', 'pr.id_pr', '=', 'po.id_pr')
                    ->join('vendor', 'vendor.id_vendor', '=', 'po.id_vendor')
                    ->join('users', 'users.id', '=', 'pr.id_employee')->get();
                foreach ($emp_data as $emp) {
                    $emp_name = $emp->name;
                }
                $mng_data = DB::table('po')
                    ->join('pr', 'pr.id_pr', '=', 'po.id_pr')
                    ->join('vendor', 'vendor.id_vendor', '=', 'po.id_vendor')
                    ->join('users', 'users.id', '=', 'pr.id_manager')->get();
                foreach ($mng_data as $mng) {
                    $mng_name = $mng->name;
                }
                $po_data = DB::table('po')
                    ->join('pr', 'pr.id_pr', '=', 'po.id_pr')
                    ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
                    ->join('users', 'users.id', '=', 'employee.id_users')
                    ->where('po.po_no', '=', $po_no)->get();

                foreach ($po_data as $data_po) {
                    $disc = $data_po->po_disc;
                    $tax = $data_po->po_tax;
                }

                $sub_total = DB::table('po')->selectRaw('SUM(total_price) as sub_total')->where('po_no', '=', $po_no)->get();
                foreach ($sub_total as $subs) {
                    $sub = $subs->sub_total;
                }

                $a_disc = ($disc / 100) * $sub;
                $a_tax = ($tax / 100) * $sub;

                $grand_total = $sub - $a_disc + $a_tax;

                return $this->SendMailPOAction($emp_name, $mng_name, $po_data, $a_disc, $a_tax, $sub, $grand_total, $status);
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error : ',
                    'errors'    => $ex
                ], 401);
                Alert::success('Danger', 'Failed Approve Request');
                return redirect()->route('index_po_manager');
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
    public function show_modal_po_price_manager(string $id)
    {
        $data_po = DB::table('po')
            ->join('pr', 'pr.id_pr', '=', 'po.id_pr')
            ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->where('po.po_no', '=', $id)->get();
        // $pr_data = DB::table('pr')->where('pr_no', '=', $id)->get();
        $total_prices = DB::table('po')->selectRaw('SUM(total_price) as grand_total')->where('po_no', '=', $id)->get();
        return view('components.modals.po_price_manager', compact('data_po', 'total_prices'));
    }
    public function show_modal_po_price_manager_comp(string $id)
    {
        $data_po = DB::table('po')
            ->join('pr', 'pr.id_pr', '=', 'po.id_pr')
            ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->join('vendor', 'vendor.id_vendor', '=', 'po.id_vendor')
            ->where('po.po_no', '=', $id)->get();
        // $pr_data = DB::table('pr')->where('pr_no', '=', $id)->get();
        foreach ($data_po as $po_datas) {
            $disc = $po_datas->po_disc;
            $tax = $po_datas->po_tax;
        }
        $sub_total = DB::table('po')->selectRaw('SUM(total_price) as sub_total')->where('po_no', '=', $id)->get();
        foreach ($sub_total as $subs) {
            $sub = $subs->sub_total;
        }

        $a_disc = ($disc / 100) * $sub;
        $a_tax = ($tax / 100) * $sub;

        $grand_total = $sub - $a_disc + $a_tax;
        return view('components.modals.po_price_manager_comp', compact('data_po', 'sub', 'grand_total', 'disc', 'tax'));
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
            $emp_data = DB::table('pr')
                ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
                ->join('users', 'users.id', '=', 'employee.id_users')
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
            ], function ($mail) use ($pr_no) {
                $id_users = Auth::user()->id;
                $emp_data   = DB::table('employee')
                    ->join('users', 'users.id', '=', 'employee.id_users')
                    ->where('id_users', '=', $id_users)->get();
                foreach ($emp_data as $item_emp) {
                    $emp_div = $item_emp->emp_division;
                    
                }

                 $emp_data2 = DB::table('pr')->selectRaw('* ,pr.id_employee as id_emp')
                    ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
                    ->join('users', 'users.id', '=', 'employee.id_users')
                    // ->where('employee.emp_position', '=', "Staff")
                    ->where('pr.pr_no', '=', $pr_no)->get();
                foreach ($emp_data2 as $item_emp2) {
                    $emp_mail2 = $item_emp2->email;
                    // dd($emp_mail2);
                }

                $manager_data = DB::table('employee')
                    ->join('users', 'users.id', '=', 'employee.id_users')
                    ->where('emp_division', '=', $emp_div)
                    ->where('emp_position', '=', "Manager")->get();
                foreach ($manager_data as $manager) {
                    $manager_email = $manager->email;
                }

                $ga_data = DB::table('users')
                    ->where('user_level', '=', '4')
                    ->where('deleted_at', '=', NULL)->get();
                foreach ($ga_data as $data_ga) {
                    $GA_email = $data_ga->email;
                }
                // $mail->to($manager_email);
                $mail->to($emp_mail2);
                $mail->to($GA_email);
                $mail->cc('sulis.nugroho@inlingua.co.id');
                $mail->from(config('mail.from.name'));
                $mail->subject('SATUPINTU - APP | Purchase Request Order');
                
            });
            if ($status == "Approved") {
                dd($status);
                Alert::success('Success', 'PR Submitted Successfully');
                return redirect()->route('index_pr_manager');
            } elseif ($status == "Rejected") {
                Alert::danger('Warning', 'PR Rejected');
                return redirect()->route('index_pr_manager');
            }
    }

    public function SendMailPOAction($emp_name, $mng_name, $po_data, $a_disc, $a_tax, $sub, $grand_total, $status)
    {

        // return view('emails.po_send_manager', [
        //     'fullname'      => $emp_name,
        //     'manager'       => $mng_name,
        //     'ga'            => $ga_name,
        //     'po_data'       => $po_data,
        //     'disc'          => $a_disc,
        //     'tax'           => $a_tax,
        //     'sub_total'     => $sub,
        //     'grand_total'   => $grand_total,
        //     'status'        => $status
        // ]);
        $get_ga = DB::table('users')->where('user_level', '=', '4')->get();
        foreach ($get_ga as $ga_data) {
            $ga_name = $ga_data->name;
        }
        Mail::send('emails.po_send_manager', [
            'fullname'      => $emp_name,
            'manager'       => $mng_name,
            'ga'            => $ga_name,
            'po_data'       => $po_data,
            'disc'          => $a_disc,
            'tax'           => $a_tax,
            'sub_total'     => $sub,
            'grand_total'   => $grand_total,
            'status'        => $status
        ], function ($mail) {
            $get_ga = DB::table('users')->where('user_level', '=', '4')->get();
            foreach ($get_ga as $ga_data) {
                $ga_mail = $ga_data->email;
            }

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
            // $mail->to($ga_mail);
            $mail->to('sulis.nugroho@inlingua.co.id ');
            $mail->from(config('mail.from.name'));
            $mail->subject('SATUPINTU - APP | Purchase Order Approval');
        });
        Alert::success('Success', 'Successfully');
        return redirect()->route('index_po_manager');
    }
}
