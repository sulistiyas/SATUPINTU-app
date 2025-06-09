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
        $rows       = $request->rows;
        $pr_title   = $request->txt_pr_title;
        $desc       = $request->description;
        $qty        = $request->quantity;
        $unit       = $request->unit;
        $pr_no      = $request->txt_pr_number;
        $jn_first   = $request->txt_jn;
        $idusers    = Auth::user()->id;

        if ($jn_first == "Operational Office" || $jn_first == "I-Link" || $jn_first == "WSCC" || $jn_first == "WSCE") {
            $jn = $request->txt_jn;
        } else {
            $get_jn = DB::table('jobnumber')
            ->where('id_jn', '=', $jn_first)
            ->where('deleted_at', '=', NULL)->get();
            foreach ($get_jn as $item_jn) {
                $jn = $item_jn->job_number;
            }
        }
        
        
        $division   = DB::table('employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->where('id_users', '=', $idusers)->get();
        foreach ($division as $item_div) {
            $emp_div = $item_div->emp_division;
            $emp_name = $item_div->name;
        }

        $id_employee = DB::table('employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->where('users.id', '=', $idusers)->get();
        foreach ($id_employee as $item_emp) {
            $emp_id = $item_emp->id_employee;
        }

        $id_manager = DB::table('employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->where('emp_division', '=', $emp_div)
            ->where('emp_position', '=', "Manager")->get();
        foreach ($id_manager as $manager) {
            $manager_id = $manager->id;
            $manager_name = $manager->name;
        }
        if ($rows == null) {
            Alert::error('Error', 'PR Item Empty!!');
            return redirect()->route('create_pr_users');
        } else {
            foreach ($rows as $key => $value) {
                if ($desc[$key]=="") {
                    Alert::error('Error', 'PR Item Description Empty!!');
                    return redirect()->route('create_pr_admin');
                } else {
                    if ($qty[$key]=="") {
                        Alert::error('Error', 'PR Item Quantity Empty!!');
                        return redirect()->route('create_pr_admin');
                    } else {
                        if ($unit[$key] == "Select Unit Type") {
                            Alert::error('Error', 'PR Item Unit Empty!!');
                            return redirect()->route('create_pr_admin');
                        } else {
                            $array_data[] = array(
                                'pr_no'                 => $pr_no,
                                'job_number'            => $jn,
                                'id_employee'           => $emp_id,
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
                        
                        
                    }
                    
                }
            }
            PurchaseRequest::insert($array_data);
            return $this->SendMailPR($idusers, $manager_id, $array_data, $pr_no, $jn);
            Alert::success('Success', 'PR Submitted Successfully');
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
        return view('components.modals.admin_modals.e_purchase.pr.pr_admin_show', ['data_pr' => $pr_data]);
    }

    public function show_modal_pr_users_edit($id)
    {
        // 
        $pr_data = DB::table('pr')
            ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->where('pr.pr_no', '=', $id)->get();
        // $pr_data = DB::table('pr')->where('pr_no', '=', $id)->get();
        return view('components.modals.admin_modals.e_purchase.pr.pr_admin_show_edit', ['data_pr' => $pr_data]);
    }

    public function update_pr_users(Request $request)
    {
        $pr_title   = $request->txt_pr_title;
        $id_pr      = $request->txt_id_pr;
        $desc       = $request->txt_desc;
        $qty        = $request->txt_pr_qty;
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

        $id_employee = DB::table('employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->where('users.id', '=', $idusers)->get();
        foreach ($id_employee as $item_emp) {
            $emp_id = $item_emp->id_employee;
        }

        $count_data = DB::table('pr')->where('pr_no', '=', $pr_no)->count();
        $pr_data = PurchaseRequest::where('pr_no', '=', $pr_no)->first();
        $rows[]       = $count_data;
        foreach ($rows as $key => $value) {
            $array_data[] = array(
                'pr_no'                 => $pr_no,
                'job_number'            => $jn,
                'id_employee'           => $emp_id,
                'pr_title'              => $pr_title,
                'pr_desc'               => $desc[$key],
                'pr_qty'                => $qty[$key],
                'pr_unit'               => $unit[$key],
                'pr_status'             => 5,
                'pr_date'               => date('Y-m-d'),
                'id_manager'            => $manager_id,
            );
            // dd($array_data);
            // $pr_data->update($array_data);
            for ($i = 0; $i < $count_data; $i++) {
                $values = PurchaseRequest::where('id_pr', '=', $id_pr[$i])->update(
                    [
                        'pr_desc'       => $desc[$i],
                        'pr_qty'        => $qty[$i],
                        'pr_unit'       => $unit[$i],
                        'updated_at'    => date('Y-m-d H:i:s'),
                    ]
                );
            }
        }
        // return $this->SendMailPR($idusers, $manager_id, $array_data, $pr_no, $jn);
        Alert::success('Success', 'PR Updated Successfully');
        return redirect()->route('index_pr_users');
    }

    public function show_modal_pr_users_add($id)
    {
        // 
        $pr_data = DB::table('pr')
            ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->where('pr.pr_no', '=', $id)->get();
        // $pr_data = DB::table('pr')->where('pr_no', '=', $id)->get();
        return view('components.modals.admin_modals.e_purchase.pr.pr_admin_show_add', ['data_pr' => $pr_data]);
    }

    public function update_item_pr_users(Request $request)
    {
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

        $id_employee = DB::table('employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->where('users.id', '=', $idusers)->get();
        foreach ($id_employee as $item_emp) {
            $emp_id = $item_emp->id_employee;
        }
        foreach ($rows as $key => $value) {
            $array_data[] = array(
                'pr_no'                 => $pr_no,
                'job_number'            => $jn,
                'id_employee'           => $emp_id,
                'pr_title'              => $pr_title,
                'pr_desc'               => $desc[$key],
                'pr_qty'                => $qty[$key],
                'pr_unit'               => $unit[$key],
                'pr_status'             => 5,
                'pr_date'               => date('Y-m-d'),
                'id_manager'            => $manager_id,
                'created_at'            => date('Y-m-d H:i:s'),
                'updated_at'            => date('Y-m-d H:i:s'),
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
        Alert::success('Success', 'PR ReSubmitted Successfully');
        return redirect()->route('index_pr_users');
    }

    public function show_modal_po_pirce_users($id)
    {
        $data_po = DB::table('po')
            ->join('pr', 'pr.id_pr', '=', 'po.id_pr')
            ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->leftJoin('vendor', 'vendor.id_vendor', '=', 'po.id_vendor')
            ->where('po.po_no', '=', $id)->get();
        // $pr_data = DB::table('pr')->where('pr_no', '=', $id)->get();
        $total_prices = DB::table('po')->selectRaw('SUM(total_price) as grand_total')->where('po_no', '=', $id)->get();
        $vendor_data = DB::table('vendor')->where('deleted_at', '=', NULL)->orderBy('vendor', 'asc')->get();
        return view('components.modals.admin_modals.e_purchase.po.po_admin', compact('data_po', 'total_prices', 'vendor_data'));
    }

    public function show_modal_po_un_users($id)
    {
        $data_po = DB::table('po')
            ->join('pr', 'pr.id_pr', '=', 'po.id_pr')
            ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->leftJoin('vendor', 'vendor.id_vendor', '=', 'po.id_vendor')
            ->where('po.po_no', '=', $id)->get();
        // $pr_data = DB::table('pr')->where('pr_no', '=', $id)->get();
        $total_prices = DB::table('po')->selectRaw('SUM(total_price) as grand_total')->where('po_no', '=', $id)->get();
        $vendor_data = DB::table('vendor')->where('deleted_at', '=', NULL)->orderBy('vendor', 'asc')->get();
        return view('components.modals.admin_modals.e_purchase.po.po_admin', compact('data_po', 'total_prices', 'vendor_data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit_pr_users(string $id)
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
                // $mail->to($manager_email);
                // $mail->cc('sulis.nugroho@inlingua.co.id');
                $mail->to('sulis.nugroho@inlingua.co.id');
                // $mail->cc($GA_email);
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

    public function print_po_users(Request $request)
    {
        $po_no = $request->txt_po_no;
        $data = ['po_no' => $po_no];
        // return view('components.pdf.po_print',$data);
        $pdf = Pdf::loadView('components.pdf.po_print', $data);
        // $pdf->loadHTML($po_no);
        return $pdf->stream("$po_no.pdf");
    }

    // ATK
    public function index_atk()
    {
        return view('users.atk.index');
    }
}
