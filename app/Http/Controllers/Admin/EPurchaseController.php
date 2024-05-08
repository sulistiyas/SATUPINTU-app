<?php

namespace App\Http\Controllers\Admin;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class EPurchaseController extends Controller
{
    // Purchase Request Section Start
    public function index_pr()
    {
        return view('admin.ePurchase.purchase_request.index');
    }

    public function create_pr()
    {
        //
    }

    public function store_pr(Request $request)
    {
        //
    }

    public function show_pr(string $id)
    {
        //
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
}
