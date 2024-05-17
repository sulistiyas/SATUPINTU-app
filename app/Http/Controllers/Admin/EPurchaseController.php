<?php

namespace App\Http\Controllers\Admin;

use Error;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Models\PurchaseRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;



class EPurchaseController extends Controller
{
    // Purchase Request Section Start
    public function index_pr()
    {
        $id_usr = Auth::user()->id;
        $get_data = DB::table('pr')
            ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->where('users.id', '=', $id_usr)
            ->where('pr.deleted_at', '=', NULL)
            ->groupBy('pr.pr_no')->get();
        return view('admin.ePurchase.purchase_request.index', ['data' => $get_data]);
    }

    public function create_pr()
    {
        $id = IdGenerator::generate(['table' => 'pr', 'field' => 'pr_no', 'length' => 13, 'prefix' => 'PR' . +date('Ymd')]);
        $data = DB::table('jobnumber')->where('deleted_at', '=', NULL)->orderBy('id_jn', 'DESC')->get();
        return view('admin.ePurchase.purchase_request.create', compact('id', 'data'));
    }

    public function store_pr(Request $request)
    {
        // $idusers = Auth::user()->id;
        // $division = DB::table('employee')->where('id_users', '=', $idusers)->get();
        // foreach ($division as $item_div) {
        //     $emp_div = $item_div->emp_division;
        // }

        // $id_manager = DB::table('employee')
        //     ->join('users', 'users.id', '=', 'employee.id_users')
        //     ->where('emp_division', '=', $emp_div)
        //     ->where('emp_position', '=', "Manager")->get();
        // foreach ($id_manager as $manager) {
        //     $manager_id = $manager->name;
        // }


        try {
            $rows       = $request->rows;
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
                    'pr_desc'               => $desc[$key],
                    'pr_qty'                => $qty[$key],
                    'pr_unit'               => $unit[$key],
                    'pr_status'             => 3,
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
            return redirect()->route('index_pr_admin');
        } catch (\Exception $th) {
            return response()->json([
                'status'    => false,
                'message'   => 'Error Send mail : ',
                'errors'    => $th
            ], 401);
            Alert::error('error', 'Failed to Create Data!!');
            return redirect()->route('create_pr_admin');
        }
    }


    public function show_modal_pr_admin($id)
    {
        // 
        $pr_data = DB::table('pr')
            ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->where('pr.pr_no', '=', $id)->get();
        // $pr_data = DB::table('pr')->where('pr_no', '=', $id)->get();
        return view('components.modals.pr_admin_show', ['data_pr' => $pr_data]);
    }

    public function edit_pr(string $id)
    {
        //
    }

    public function update_pr(Request $request, string $id)
    {
        //
    }

    public function destroy_pr(string $id)
    {
        //
    }
    // Purchase Request Section End
    // Purchase Order Section Start
    public function index_po()
    {
        //
    }

    public function create_po()
    {
        //
    }

    public function store_po(Request $request)
    {
        //
    }

    public function show_po(string $id)
    {
        //
    }

    public function edit_po(string $id)
    {
        //
    }

    public function update_po(Request $request, string $id)
    {
        //
    }

    public function destroy_po(string $id)
    {
        //
    }
    // Purchase Order Section End
    // Vendor Section Start
    public function index_vendor()
    {
        $vendor_data = DB::table('vendor')->where('deleted_at', '=', NULL)->orderBy('id_vendor', 'ASC')->get();
        return view('admin.ePurchase.vendor.index', ['vendor_data' => $vendor_data]);
    }

    public function create_vendor()
    {
        //
    }

    public function store_vendor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'txt_vendor' => 'required',
            'txt_vendor_cp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validator->errors()
            ], 401);
        } else {
            try {
                Vendor::create([
                    'vendor'       => $request->txt_vendor,
                    'vendor_cp'    => $request->txt_vendor_cp,
                    'telepon'      => $request->txt_vendor_phone,
                    'email'        => $request->txt_vendor_mail,
                    'alamat'       => $request->txt_vendor_add,
                    'created_at'   => date('Y-m-d h:i:s'),
                    'updated_at'   => date('Y-m-d h:i:s')
                ]);
                Alert::success('Success', 'New Vendor Added');
                return redirect()->route('index_vendor_admin');
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error insert data : ',
                    'errors'    => $ex
                ], 401);

                Alert::warning('Warning', 'Failed to add new Vendor !!');
                return redirect()->route('index_vendor_admin');
            }
        }
    }

    public function show_vendor(string $id)
    {
        //
    }

    public function edit_vendor(string $id)
    {
        $vendor_data = Vendor::find($id);
        return response()->json($vendor_data);
    }

    public function update_vendor(Request $request, string $id)
    {
        $vendor_data = Vendor::where('id_vendor', '=', $request->update_id_vendor)->first();
        $validator = Validator::make($request->all(), [
            'update_txt_vendor' => 'required',
            'update_txt_vendor_cp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validator->errors()
            ], 401);
        } else {
            try {
                $vendor_data->update([
                    'vendor'       => $request->update_txt_vendor,
                    'vendor_cp'    => $request->update_txt_vendor_cp,
                    'telepon'      => $request->update_txt_vendor_phone,
                    'email'        => $request->update_txt_vendor_mail,
                    'alamat'       => $request->update_txt_vendor_add,
                    'updated_at'        => date('Y-m-d h:i:s')
                ]);
                Alert::success('Success', 'Successfully Update Vendor Data');
                return redirect()->route('index_vendor_admin');
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error update data : ',
                    'errors'    => $ex
                ], 401);

                Alert::warning('Warning', 'Failed to update Vendor !!');
                return redirect()->route('index_vendor_admin');
            }
        }
    }

    public function destroy_vendor(string $id)
    {
        $vendor_data = Vendor::where('id_vendor', '=', $id)->first();
        try {
            $vendor_data->delete();
            Alert::success('Success', 'Delete Data Successfully');
            return redirect()->route('index_vendor_admin');
        } catch (\Exception $th) {
            return response()->json([
                'status'    => false,
                'message'   => 'Error Delete : ',
                'errors'    => $th
            ], 401);
            Alert::error('error', 'Failed to Delete Data!!');
            return redirect()->route('index_vendor_admin');
        }
    }
    // Vendor Section End

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
            Mail::send('emails.pr_send', [
                'fullname'      => $emp_name,
                'manager'       => $manager_name,
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

                $manager_data = DB::table('employee')
                    ->join('users', 'users.id', '=', 'employee.id_users')
                    ->where('emp_division', '=', $emp_div)
                    ->where('emp_position', '=', "Manager")->get();
                foreach ($manager_data as $manager) {
                    $manager_email = $manager->email;
                }
                // $mail->to($manager_email);
                $mail->to('sulis.nugroho@inlingua.co.id');
                $mail->from(config('mail.from.name'));
                $mail->subject('SATUPINTU - APP | Purchase Request Order');
            });
            Alert::success('Success', 'PR Submitted Successfully');
            return redirect()->route('index_pr_admin');
        } catch (\Exception $th) {
            return response()->json([
                'status'    => false,
                'message'   => 'Error Send mail : ',
                'errors'    => $th
            ], 401);
            Alert::error('error', 'Failed to Create Data!!');
            return redirect()->route('create_pr_admin');
        }
    }
}
