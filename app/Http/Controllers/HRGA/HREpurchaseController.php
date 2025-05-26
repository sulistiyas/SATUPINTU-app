<?php

namespace App\Http\Controllers\HRGA;

use App\Models\OldPR;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class HREpurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
                return redirect()->route('index_vendor_hr_ga');
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error insert data : ',
                    'errors'    => $ex
                ], 401);

                Alert::warning('Warning', 'Failed to add new Vendor !!');
                return redirect()->route('index_vendor_hr_ga');
            }
        }
    }
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
        return view('hr_ga.epurchase.pr.index', ['data' => $get_data]);
    }

    public function refresh_pr_hr_ga()
    {
        $id_pr = IdGenerator::generate(['table' => 'pr', 'field' => 'pr_no', 'length' => 13, 'prefix' => 'PR' . +date('Ymd')]);
        return view('components.modals.e-purchase.refresh_pr', ['id_pr' => $id_pr]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create_pr_hr_ga()
    {
        $id = IdGenerator::generate(['table' => 'pr', 'field' => 'pr_no', 'length' => 13, 'prefix' => 'PR' . +date('Ymd')]);
        $data = DB::table('jobnumber')->where('deleted_at', '=', NULL)->orderBy('id_jn', 'DESC')->get();
        return view('hr_ga.epurchase.pr.create', compact('id', 'data'));
    }
    
    public function store_pr(Request $request)
    {

        $rows       = $request->rows;
        $pr_title   = $request->txt_pr_title;
        $desc       = $request->description;
        $qty        = $request->quantity;
        $unit       = $request->unit;
        $pr_no      = $request->txt_pr_number;
        $jn         = $request->txt_jn;
        $idusers    = Auth::user()->id;
        $jn_code = DB::table('jobnumber')->where('id_jn', '=', $jn)->get();
            foreach ($jn_code as $jn_codes) {
                $jn_name = $jn_codes->job_number;
            }
        $division   = DB::table('employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->where('users.id', '=', $idusers)->get();
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
        }if ($rows == null) {
            Alert::error('Error', 'PR Item Empty!!');
            return redirect()->route('create_pr_hr_ga');
        } else {
            foreach ($rows as $key => $value) {
                if ($desc[$key]=="") {
                    Alert::error('Error', 'PR Item Description Empty!!');
                    return redirect()->route('create_pr_hr_ga');
                } else {
                    if ($qty[$key]=="") {
                        Alert::error('Error', 'PR Item Quantity Empty!!');
                        return redirect()->route('create_pr_hr_ga');
                    } else {
                        if ($unit[$key] == "Select Unit Type") {
                            Alert::error('Error', 'PR Item Unit Empty!!');
                            return redirect()->route('create_pr_hr_ga');
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
    public function get_pr_hr_ga($pr_no){
        $pr_data = PurchaseRequest::firstWhere('pr_no', '=', $pr_no);
        // dd($pr_data);
        return response()->json($pr_data);
    }
    public function approve_final_pr(Request $request){
        $status_approval = $request->btn_approval;
        $pr_no = $request->txt_pr_no;
        if ($status_approval == "approve_final_pr"){
            $update_pr = PurchaseRequest::where('pr_no', '=', $pr_no)->update([
                'pr_status'     => '4',
                'updated_at'    => date('Y-m-d h:i:s')
            ]);
            Alert::success('Success', 'Successfully Approve Request');
            return redirect()->route('index_pr_hr_ga');
        }else {
            Alert::error('Error', 'Failed Approve Request');
            return redirect()->route('index_pr_hr_ga');
        }
    }

    public function reject_final_pr(Request $request){
        $status_approval = $request->btn_approval;
        $pr_no = $request->app_txt_pr_no;
        if ($status_approval == "reject_final_pr"){
            $update_pr = PurchaseRequest::where('pr_no', '=', $pr_no)->update([
                'pr_status'     => '6',
                'pr_reason'    => $request->txt_pr_reject_reason,
                'updated_at'    => date('Y-m-d h:i:s')
            ]);
            Alert::success('Success', 'Successfully Reject   Request');
            return redirect()->route('index_pr_hr_ga');
        }else {
            Alert::error('Error', 'Failed Reject Request');
            return redirect()->route('index_pr_hr_ga');
        }
        
    }
    public function print_pr_hr_ga(Request $request)
    {
        $pr_no = $request->txt_pr_no;
        $data = ['pr_no' => $pr_no];
        $pdf = Pdf::loadView('components.pdf.pr_print', $data);
        // $pdf->loadHTML($pr_no);
        return $pdf->stream("$pr_no.pdf");
    }

    /**
     * Display the specified resource.
     */
    public function show_modal_pr_hr_ga($id)
    {
        // 
        $pr_data = DB::table('pr')
            ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->where('pr.pr_no', '=', $id)->get();
        // $pr_data = DB::table('pr')->where('pr_no', '=', $id)->get();
        return view('components.modals.admin_modals.e_purchase.pr.pr_admin_show', ['data_pr' => $pr_data]);
    }

    public function show_modal_price_hr_ga($id)
    {
        $po_no = IdGenerator::generate(['table' => 'po', 'field' => 'po_no', 'length' => 13, 'prefix' => 'PO' . +date('Ymd')]);
        $data_pr = DB::table('pr')
            ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->where('pr.pr_no', '=', $id)->get();
        // $pr_data = DB::table('pr')->where('pr_no', '=', $id)->get();
        return view('components.modals.admin_modals.e_purchase.po.price_admin', compact('po_no', 'data_pr'));
    }

    public function show_modal_po_hr_ga($id)
    {
        $data_po = DB::table('po')
            ->join('pr', 'pr.id_pr', '=', 'po.id_pr')
            ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->leftJoin('vendor', 'vendor.id_vendor', '=', 'po.id_vendor')
            ->where('po.po_no', '=', $id)->get();
        // $pr_data = DB::table('pr')->where('pr_no', '=', $id)->get();
        $sub_total = DB::table('po')->selectRaw('SUM(total_price) as sub_total')->where('po_no', '=', $id)->get();
        foreach ($sub_total as $subs) {
            $sub = $subs->sub_total;
        }
        foreach ($data_po as $item) {
            $disc_type = $item->po_disc_type;
            $disc = $item->po_disc;
            $tax = $item->po_tax;
            $service_charge = $item->po_service_charge;
            $delivery_fee = $item->po_delivery_fee;
            $addtional_charge = $item->po_additional_charge;
        }
        if($disc_type == "diskon"){
            $a_disc = ($disc / 100) * $sub;
            $total_disc = $sub - $a_disc ;
            $a_tax = ($tax / 100) * $total_disc;
            $grand_total = $total_disc + $a_tax + $service_charge + $delivery_fee + $addtional_charge;
            $total_prices = DB::table('po')->selectRaw('SUM(total_price) as grand_total')->where('po_no', '=', $id)->get();
        $vendor_data = DB::table('vendor')->where('deleted_at', '=', NULL)->orderBy('vendor', 'asc')->get();
        return view('components.modals.admin_modals.e_purchase.po.po_admin', compact('data_po', 'total_prices', 'vendor_data','sub','a_disc','a_tax','grand_total','service_charge','delivery_fee','addtional_charge'));
        }else if($disc_type == "harga_normal"){
            $total_disc = $sub - $disc ;
            $a_tax = ($tax / 100) * $total_disc;
            $grand_total = $total_disc + $a_tax + $service_charge + $delivery_fee + $addtional_charge;
            $total_prices = DB::table('po')->selectRaw('SUM(total_price) as grand_total')->where('po_no', '=', $id)->get();
        $vendor_data = DB::table('vendor')->where('deleted_at', '=', NULL)->orderBy('vendor', 'asc')->get();
        return view('components.modals.admin_modals.e_purchase.po.po_admin', compact('data_po', 'total_prices', 'vendor_data','sub','disc','a_tax','grand_total','service_charge','delivery_fee','addtional_charge'));
        }
        
    }

    public function show_modal_create_po_hr_ga($id)
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
    public function approve_pr_hr_ga(Request $request)
    {
        $pr_approval = $request->btn_approval;
        $pr_no = $request->txt_pr_no;

        if ($pr_approval == "approve_pr") {
            try {
                $status = "Approved";
                $pr_data = PurchaseRequest::where('pr_no', '=', $pr_no)->update([
                    'pr_status'     => '4',
                    'updated_at'    => date('Y-m-d h:i:s')
                ]);
                // return $this->SendMailPRAction($pr_no, $status);

                Alert::success('Success', 'Successfully Approve PR');
                return redirect()->route('index_pr_hr_ga');
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error : ',
                    'errors'    => $ex
                ], 401);
                Alert::success('Danger', 'Failed Approve Request');
                return redirect()->route('index_pr_hr_ga');
            }
        } else if ($pr_approval == "reject_pr") {
            try {
                $status = "Rejected";
                $pr_data = PurchaseRequest::where('pr_no', '=', $pr_no)->update([
                    'pr_status'     => '6',
                    'updated_at'    => date('Y-m-d h:i:s')
                ]);
                // return $this->SendMailPRAction($pr_no, $status);
                Alert::success('Danger', 'PR Rejected !!!');
                return redirect()->route('index_pr_hr_ga');
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error : ',
                    'errors'    => $ex
                ], 401);
                Alert::success('Danger', 'Failed Approve Request');
                return redirect()->route('index_pr_hr_ga');
            }
        }
    }
    // Purchase Request Section End
    // Purchase Order Section Start
    /**
     * Show the form for editing the specified resource.
     */
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
        return view('hr_ga.epurchase.po.index', ['data' => $get_pr_data]);
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
            $id_po = $request->txt_id_po;
            $po_no = $request->txt_po_no;
            $pr_no = $request->txt_pr_no;
            $total_price = $request->txt_total_price;
            $disc_type = $request->diskon_type;
            // $disc = $request->txt_disc;
            $tax = $request->txt_tax;
            $service_charge = $request->txt_service_charge;
            $delivery_fee = $request->txt_delivery_fee;
            $vendor = $request->txt_id_vendor;
            $count_data = $request->txt_count_data;
            $addtional_charge = $request->txt_adds_charge;

            if($disc_type == "diskon"){
                $disc = $request->txt_disc;
            }else if($disc_type == "harga_normal"){
                $disc = $request->txt_harga_normal;
            }else if($disc_type == null){
                $disc = 0;
            }

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
                'po_disc_type'          => $disc_type,
                'po_disc'               => $disc,
                'po_tax'                => $tax,
                'po_service_charge'     => $service_charge,
                'po_delivery_fee'       => $delivery_fee,
                'po_additional_charge'  => $addtional_charge,
                'po_status'             => '2',
                'po_notes'              => $request->txt_po_notes,
                'updated_at'            => date('Y-m-d h:i:s')
            ]);
            $pr_data = PurchaseRequest::where('pr_no', '=', $pr_no)->update([
                'pr_status'     => '2',
                'updated_at'    => date('Y-m-d h:i:s')
            ]);
            $emp_data = DB::table('po')
                ->join('pr', 'pr.id_pr', '=', 'po.id_pr')
                ->join('vendor', 'vendor.id_vendor', '=', 'po.id_vendor')
                ->join('employee', 'employee.id_employee', '=', 'pr.id_employee')
                ->join('users','users.id','=','employee.id_users')->get();
            foreach ($emp_data as $emp) {
                $emp_name = $emp->name;
            }
            $mng_data = DB::table('po')
                ->join('pr', 'pr.id_pr', '=', 'po.id_pr')
                ->join('vendor', 'vendor.id_vendor', '=', 'po.id_vendor')
                ->join('users', 'users.id', '=', 'pr.id_manager')->get();
            foreach ($mng_data as $mng) {
                $mng_name = "Christina Marlina";
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

            if($disc_type == "diskon"){
                $a_disc = ($disc / 100) * $sub;
                $total_disc = $sub - $a_disc ;
                $a_tax = ($tax / 100) * $total_disc;
                $grand_total = $total_disc + $a_tax + $service_charge + $delivery_fee + $addtional_charge; 
                return $this->SendMailPO($emp_name, $mng_name, $po_data, $a_disc, $a_tax, $sub, $grand_total, $service_charge, $delivery_fee, $addtional_charge);
            }else if($disc_type == "harga_normal"){
                $total_disc = $sub - $disc ;
                $a_tax = ($tax / 100) * $total_disc;
                $grand_total = $total_disc + $a_tax + $service_charge + $delivery_fee + $addtional_charge; 
                return $this->SendMailPO($emp_name, $mng_name, $po_data, $disc, $a_tax, $sub, $grand_total, $service_charge, $delivery_fee, $addtional_charge);
            }else if($disc_type == null){
                $total_disc = $sub - $disc ;
                $a_tax = ($tax / 100) * $total_disc;
                $grand_total = $total_disc + $a_tax + $service_charge + $delivery_fee + $addtional_charge; 
                return $this->SendMailPO($emp_name, $mng_name, $po_data, $disc, $a_tax, $sub, $grand_total, $service_charge, $delivery_fee, $addtional_charge);
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
                $txt_pr_no = $request->txt_pr_no;
                $txt_po_no = $request->txt_po_no;
                $txt_id_pr = $request->txt_id_pr;
                $currency = $request->txt_currency;
                $price = $request->txt_price;
                $txt_qty = $request->txt_qty_pr;
                $txt_count = $request->txt_count;

                // dd($txt_count);
                foreach ($txt_count as $key => $value) {
                    $price_total_unit = $price[$key] * $txt_qty[$key];
                    $array_data[] = array(
                        'po_no'         => $txt_po_no[$key],
                        'id_pr'         => $txt_id_pr[$key],
                        'currency'      => $currency,
                        'price'         => $price[$key],
                        'total_price'   => $price_total_unit,
                        'po_date'       => date('Y-m-d'),
                        'po_status'     => '3',
                        'created_at'    => date('Y-m-d h:i:s'),
                        'updated_at'    => date('Y-m-d h:i:s'),
                    );
                }
                // dd($array_data);
                PurchaseOrder::insert($array_data);
                $pr_data = PurchaseRequest::where('pr_no', '=', $txt_pr_no)->update([
                    'pr_status'     => '3',
                    'updated_at'    => date('Y-m-d h:i:s')
                ]);
                Alert::success('Success', 'Successfully Insert Price');
                return redirect()->route('index_po_hr_ga');
            try {
                
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error : ',
                    'errors'    => $ex
                ], 401);
                Alert::error('Error', 'Error Insert Price');
                return redirect()->route('index_po_hr_ga');
            }
        }
    }

    public function show_po(string $id)
    {
        //
    }
    public function print_po_hr_ga(Request $request)
    {
        $po_no = $request->txt_po_no;
        $data = ['po_no' => $po_no];
        // return view('components.pdf.po_print',$data);
        $pdf = Pdf::loadView('components.pdf.po_print', $data);
        // $pdf->loadHTML($po_no);
        return $pdf->stream("$po_no.pdf");
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

    public function SendMailPR($idusers, $manager_id, $array_data, $pr_no, $jn)
    {
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
            return redirect()->route('index_pr_hr_ga');
        // try {
            
        // } catch (\Exception $th) {
        //     return response()->json([
        //         'status'    => false,
        //         'message'   => 'Error Send mail : ',
        //         'errors'    => $th
        //     ], 401);
        //     Alert::error('error', 'Failed to Create Data!!');
        //     return redirect()->route('create_pr_hr_ga');
        // }
    }

    public function SendMailPO($emp_name, $mng_name, $po_data, $a_disc, $a_tax, $sub, $grand_total, $service_charge, $delivery_fee, $addtional_charge)
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
                'fullname'              => $emp_name,
                'manager'               => $mng_name,
                'ga'                    => Auth::user()->name,
                'po_data'               => $po_data,
                'disc'                  => $a_disc,
                'tax'                   => $a_tax,
                'sub_total'             => $sub,
                'grand_total'           => $grand_total,
                'service_charge'        => $service_charge,
                'delivery_fee'          => $delivery_fee,
                'addtional_charge'      => $addtional_charge
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
                // Email Manager Ops
                $mail->to('marlina.pasaribu@inlingua.co.id');
                $mail->cc('sulis.nugroho@inlingua.co.id');
                $mail->from(config('mail.from.name'));
                $mail->subject('SATUPINTU - APP | Purchase Order Approval');
            });
            Alert::success('Success', 'PO Submitted Successfully');
            return redirect()->route('index_po_hr_ga');
        } catch (\Exception $th) {
            return response()->json([
                'status'    => false,
                'message'   => 'Error Send mail : ',
                'errors'    => $th
            ], 401);
            // Alert::error('error', 'Failed to Create Data!!');
            // return redirect()->route('create_pr_admin');
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

    public function index_vendor_hr_ga()
    {
        $vendor_data = DB::table('vendor')->where('deleted_at', '=', NULL)->orderBy('id_vendor', 'ASC')->get();
        return view('hr_ga.epurchase.index_vendor', ['vendor_data' => $vendor_data]);
    }
}
