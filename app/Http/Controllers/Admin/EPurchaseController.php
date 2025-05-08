<?php

namespace App\Http\Controllers\Admin;

use Error;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Models\PurchaseRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\JobNumber;
use App\Models\OldPR;
use App\Models\PurchaseOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Adapter\PDFLib;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Yajra\DataTables\Facades\DataTables;

use function PHPUnit\Framework\isEmpty;

class EPurchaseController extends Controller
{
    // Purchase Request Section Start
    public function index_pr()
    {
        $id_usr = Auth::user()->id;
        $get_data = DB::table('pr')
            ->leftJoin('po', 'po.id_pr', '=', 'pr.id_pr')
            ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            // ->where('users.id', '=', $id_usr)
            ->where('pr.deleted_at', '=', NULL)
            ->orderBy('pr.created_at', 'desc')
            ->groupBy('pr.pr_no')->get();
        return view('admin.ePurchase.purchase_request.index', ['data' => $get_data]);
    }

    public function refresh_pr()
    {
        $id_pr = IdGenerator::generate(['table' => 'pr', 'field' => 'pr_no', 'length' => 13, 'prefix' => 'PR' . +date('Ymd')]);
        return view('components.modals.e-purchase.refresh_pr', ['id_pr' => $id_pr]);
    }


    public function create_pr()
    {
        $id = IdGenerator::generate(['table' => 'pr', 'field' => 'pr_no', 'length' => 13, 'prefix' => 'PR' . +date('Ymd')]);
        $data = DB::table('jobnumber')->where('deleted_at', '=', NULL)->orderBy('id_jn', 'DESC')->get();
        return view('admin.ePurchase.purchase_request.create', compact('id', 'data'));
    }

    public function store_pr(Request $request)
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
            // $jn_code = DB::table('jobnumber')->where('id_jn', '=', $jn)->get();
            // foreach ($jn_code as $jn_codes) {
            //     $jn_name = $jn_codes->job_number;
            // }
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
                return redirect()->route('create_pr_admin');
            }else{
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
                // dd($rows);
                PurchaseRequest::insert($array_data);
                return $this->SendMailPR($idusers, $manager_id, $array_data, $pr_no, $jn);
                Alert::success('Success', 'PR Submitted Successfully');
                
                
                
            }
    }

    public function print_pr_admin(Request $request)
    {
        $pr_no = $request->txt_pr_no;
        $data = ['pr_no' => $pr_no];
        $pdf = Pdf::loadView('components.pdf.pr_print', $data);
        // $pdf->loadHTML($pr_no);
        return $pdf->stream("$pr_no.pdf");
    }


    public function show_modal_pr_admin($id)
    {
        // 
        $pr_data = DB::table('pr')->select('*','pr.job_number as id_jn_pr', 'jobnumber.job_number as jn')
            ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->join('jobnumber', 'jobnumber.job_number', '=', 'pr.job_number')
            ->where('pr.pr_no', '=', $id)->get();
        // $pr_data = DB::table('pr')->where('pr_no', '=', $id)->get();
        return view('components.modals.admin_modals.e_purchase.pr.pr_admin_show', ['data_pr' => $pr_data]);
    }

    public function show_modal_price_admin($id)
    {
        $po_no = IdGenerator::generate(['table' => 'po', 'field' => 'po_no', 'length' => 13, 'prefix' => 'PO' . +date('Ymd')]);
        $data_pr = DB::table('pr')
            ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->where('pr.pr_no', '=', $id)->get();
        // $pr_data = DB::table('pr')->where('pr_no', '=', $id)->get();
        return view('components.modals.admin_modals.e_purchase.po.price_admin', compact('po_no', 'data_pr'));
    }

    public function show_modal_po_admin($id)
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

    public function show_modal_create_po_admin($id)
    {
        $data_po = DB::table('po')
            ->join('pr', 'pr.id_pr', '=', 'po.id_pr')
            ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->where('po.po_no', '=', $id)->get();
        // $pr_data = DB::table('pr')->where('pr_no', '=', $id)->get();
        $total_prices = DB::table('po')->selectRaw('SUM(total_price) as grand_total')->where('po_no', '=', $id)->get();
        $vendor_data = DB::table('vendor')->where('deleted_at', '=', NULL)->orderBy('vendor', 'asc')->get();
        return view('components.modals.admin_modals.e_purchase.po.po_create_admin', compact('data_po', 'total_prices', 'vendor_data'));
    }

    public function edit_pr(string $id)
    {
        // 
        $pr_data = DB::table('pr')
            ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->where('pr.pr_no', '=', $id)->get();
        // $pr_data = DB::table('pr')->where('pr_no', '=', $id)->get();
        return view('components.modals.admin_modals.e_purchase.pr.pr_admin_show', ['data_pr' => $pr_data]);
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
        $get_pr_data = DB::table('pr')->select('*', 'pr.pr_no as pr_no_1')
            ->leftJoin('po', 'po.id_pr', '=', 'pr.id_pr')
            ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->where('pr.deleted_at', '=', NULL)
            ->orderBy('pr.created_at', 'desc')
            ->groupBy('pr.pr_no')->get();
        // dd($get_pr_data);
        return view('admin.ePurchase.purchase_order.index', ['data' => $get_pr_data]);
    }

    public function create_po()
    {
        //
    }

    public function store_po_2(Request $request)
    {
        $po_no = $request->txt_po_no;
        $po_data = PurchaseOrder::where('po_no', '=', $po_no)->first();
        $po_data->update([
            'updated_at'        => date('Y-m-d h:i:s')
        ]);
    }
    public function store_po(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'txt_tax' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validator->errors()
            ], 401);
        } else {

            try {
                $id_po = $request->txt_id_po;
                $po_no = $request->txt_po_no;
                $pr_no = $request->txt_pr_no;
                $total_price = $request->txt_total_price;
                $disc = $request->txt_disc;
                $tax = $request->txt_tax;
                $service_charge = $request->txt_service_charge;
                $delivery_fee = $request->txt_delivery_fee;
                $vendor = $request->txt_id_vendor;
                $count_data = $request->txt_count_data;


                foreach ($count_data as $key => $value) {
                    // $a_disc = ($disc / 100) * $total_price;
                    // $a_tax = ($tax / 100) * $total_price;

                    // $grand_total = $total_price - $a_disc - $a_tax;

                    $po_array[] = array(
                        ''
                    );
                }
                $po_data = PurchaseOrder::where('po_no', '=', $po_no)->update([
                    'id_vendor'             => $vendor,
                    'po_disc'               => $disc,
                    'po_tax'                => $tax,
                    'po_service_charge'     => $service_charge,
                    'po_delivery_fee'       => $delivery_fee,
                    'po_status'             => '2',
                    'po_rev'                => NULL,
                    'updated_at'            => date('Y-m-d h:i:s')
                ]);
                $pr_data = PurchaseRequest::where('pr_no', '=', $pr_no)->update([
                    'pr_status'     => '2',
                    'updated_at'    => date('Y-m-d h:i:s')
                ]);
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
                    ->where('po.po_no', '=', $po_no)
                    ->where('po.po_status', '=', '2')->get();

                $sub_total = DB::table('po')->selectRaw('SUM(total_price) as sub_total')->where('po_no', '=', $po_no)->get();
                foreach ($sub_total as $subs) {
                    $sub = $subs->sub_total;
                }

                $a_disc = ($disc / 100) * $sub;
                $a_tax = ($tax / 100) * $sub;

                $grand_total = $sub - $a_disc + $a_tax + $service_charge + $delivery_fee;

                return $this->SendMailPO($emp_name, $mng_name, $po_data, $a_disc, $a_tax, $sub, $grand_total);
                Alert::success('Success', 'Successfully Insert PO');
                return redirect()->route('index_po_admin');
                // dd($po_no);
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error : ',
                    'errors'    => $ex
                ], 401);
                Alert::error('Error', 'Error Insert PO');
                return redirect()->route('index_po_admin');
            }
        }
    }

    public function store_price(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'txt_price' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validator->errors()
            ], 401);
        } else {
            try {
                $txt_pr_no = $request->txt_pr_no;
                $txt_po_no = $request->txt_po_no;
                $txt_id_pr = $request->txt_id_pr;
                $currency = $request->txt_currency;
                $price = $request->txt_price;
                $txt_qty = $request->txt_qty_pr;
                $txt_count = $request->txt_count;

                // dd($count);
                foreach ($txt_count as $key => $value) {
                    $price_total_unit = $price[$key] * $txt_qty[$key];
                    $array_data[] = array(
                        'po_no'         => $txt_po_no[$key],
                        'id_pr'         => $txt_id_pr[$key],
                        'currency'      => $currency[$key],
                        'price'         => $price[$key],
                        'total_price'   => $price_total_unit,
                        'po_date'       => date('Y-m-d'),
                        'po_status'     => '3   ',
                        'created_at'    => date('Y-m-d h:i:s'),
                        'updated_at'    => date('Y-m-d h:i:s'),
                    );
                }
                PurchaseOrder::insert($array_data);
                $pr_data = PurchaseRequest::where('pr_no', '=', $txt_pr_no)->update([
                    'pr_status'     => '3',
                    'updated_at'    => date('Y-m-d h:i:s')
                ]);
                // Alert::success('Success', 'Successfully Insert Price');
                // return redirect()->route('index_po_admin');
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error : ',
                    'errors'    => $ex
                ], 401);
                // Alert::error('Error', 'Error Insert Price');
                // return redirect()->route('index_po_admin');
            }
        }
    }

    public function show_po(string $id)
    {
        //
    }
    public function print_po_admin(Request $request)
    {
        $po_no = $request->txt_po_no;
        $data = ['po_no' => $po_no];
        $pdf = Pdf::loadView('components.pdf.po_print', $data);
        // $pdf->loadHTML($po_no);
        return $pdf->stream("$po_no.pdf");
    }
    public function edit_po(string $id)
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

    public function SendMailPR($idusers, $manager_id, $array_data, $pr_no, $jn_name)
    {
        try {
            $emp_data   = DB::table('employee')
                ->join('users', 'users.id', '=', 'employee.id_users')
                ->where('id_users', '=', $idusers)->get();
            foreach ($emp_data as $item_emp) {
                $emp_div = $item_emp->emp_division;
                $emp_name = $item_emp->name;
            }
            $ga_data = DB::table('users')
                ->where('user_level', '=', '4')
                ->where('deleted_at', '=', NULL)->get();
            foreach ($ga_data as $data_ga) {
                $GA_email = $data_ga->email;
                $GA_name = $data_ga->name;
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
                'hr_ga'         => $GA_name,
                'data'          => $array_data,
                'pr_no'         => $pr_no,
                'job_number'    => $jn_name,
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

    public function SendMailPO($emp_name, $mng_name, $po_data, $a_disc, $a_tax, $sub, $grand_total)
    {
        try {
            // return view('emails.po_send', [
            //     'fullname'      => $emp_name,
            //     'manager'       => $mng_name,
            //     'ga'            => Auth::user()->name,
            //     'po_data'       => $po_data,
            //     'disc'          => $a_disc,
            //     'tax'           => $a_tax,
            //     'sub_total'     => $sub,
            //     'grand_total'   => $grand_total
            // ]);
            Mail::send('emails.po_send', [
                'fullname'      => $emp_name,
                'manager'       => $mng_name,
                'ga'            => Auth::user()->name,
                'po_data'       => $po_data,
                'disc'          => $a_disc,
                'tax'           => $a_tax,
                'sub_total'     => $sub,
                'grand_total'   => $grand_total
            ], function ($mail) {
                $ga_mail = Auth::user()->email;
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
                $mail->subject('SATUPINTU - APP | Purchase Order Approval');
            });
            Alert::success('Success', 'PO Submitted Successfully');
            return redirect()->route('index_po_admin');
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

    public function search_epurchase_admin()
    {
        return view('admin.ePurchase.report.index');
    }

    public function search_epurchase_admin_result(Request $request)
    {
        // 
        // $pr_data = DB::table('pr')
        //     ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
        //     ->join('users', 'users.id', '=', 'employee.id_users')
        //     ->where('pr.pr_no', '=', $id)->get();
        // $pr_data = DB::table('pr')->where('pr_no', '=', $id)->get();
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validator->errors()
            ], 401);
        } else {
            $date_start = $request->txt_date_start;
            $date_end = $request->txt_date_end;

            $get_report = DB::table('pr')
                ->leftJoin('po', 'pr.id_pr', '=', 'po.id_pr')
                ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
                ->join('users', 'users.id', '=', 'employee.id_users')
                ->whereBetween('pr.pr_date', [$date_start, $date_end])
                ->groupBy('pr.pr_no')
                ->get();
        }
        return view('components.show_report', ['data_pr' => $get_report]);
    }

    public function print_pr_epurchase_admin($id)
    {
        $pr_no = $id;
        $data = ['pr_no' => $pr_no];
        $pdf = Pdf::loadView('components.pdf.pr_print', $data);
        // $pdf->loadHTML($pr_no);
        return $pdf->stream("$pr_no.pdf");
    }
    public function print_po_epurchase_admin($id)
    {
        $po_no = $id;
        $data = ['po_no' => $po_no];
        $pdf = Pdf::loadView('components.pdf.po_print', $data);
        // $pdf->loadHTML($po_no);
        return $pdf->stream("$po_no.pdf");
    }

    public function get_old_pr()
    {
        return DataTables::of(OldPR::query()->orderBy('id_pr', 'DESC'))->toJson();
    }
    public function index_old_pr()
    {
        return view('admin.ePurchase.old_pr');
        // $get_data = DB::table('tbl_pr')->orderBy('id_pr', 'desc')->get();
        // return view('admin.ePurchase.old_pr', ['old_pr' => $get_data]);
    }

    public function update_po(string $po_number)
    {
        $get_data = DB::table('po')
            ->leftJoin('pr', 'pr.id_pr', '=', 'po.id_pr')
            ->where('po.po_number', '=', $po_number);
    }
}
