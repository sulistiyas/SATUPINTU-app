<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Device_Master;
use App\Http\Controllers\Controller;
use App\Models\Office_Asset;
use RealRashid\SweetAlert\Facades\Alert;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index_device_master()
    {
        $device_master = DB::table('device_master')->where('deleted_at', '=', NULL)->orderBy('device_name', 'asc')->get();
        return view('admin.ePurchase.administration.device_master', ['device_master' => $device_master]);
    }

    public function index_office_asset()
    {
        $office_asset = DB::table('office_asset')
            ->join('device_master', 'device_master.id_device', '=', 'office_asset.id_device')
            ->join('employee', 'employee.id_employee', '=', 'office_asset.id_employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->get();
        $device_master = DB::table('device_master')->where('deleted_at', '=', NULL)->orderBy('device_name', 'asc')->get();
        $user_data = DB::table('users')->join('employee', 'employee.id_users', '=', 'users.id')->get();
        return view('admin.ePurchase.administration.office_asset', compact('office_asset', 'device_master', 'user_data'));
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
    public function store_device_master(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'txt_device_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validator->errors()
            ]);
        } else {
            try {
                Device_Master::create([
                    'device_name'   => $request->txt_device_name,
                    'created_at'        => date('Y-m-d h:i:s'),
                    'updated_at'        => date('Y-m-d h:i:s')
                ]);
                Alert::success('Success', 'New Device Added');
                return redirect()->route('index_device_master');
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error add data : ',
                    'errors'    => $ex
                ], 401);

                Alert::warning('Warning', 'Failed to add new Device !!');
                return redirect()->route('index_device_master');
            }
        }
    }

    public function store_office_asset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'txt_id_device' => 'required',
            'txt_id_device' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validator->errors()
            ]);
        } else {
            try {
                $asset_code = IdGenerator::generate(['table' => 'office_asset', 'field' => 'asset_code', 'length' => 17, 'prefix' => 'INL-AT' . +date('Ymd')]);
                Office_Asset::create([
                    'asset_code'        => $asset_code,
                    'id_device'         => $request->txt_id_device,
                    'qty'               => $request->txt_asset_qty,
                    'brand'             => $request->txt_brand,
                    'model'             => $request->txt_model,
                    'serial_number'     => $request->txt_serial_number,
                    'purchase_date'     => $request->txt_purchase_date,
                    'price'             => $request->txt_price,
                    'kondisi'           => $request->txt_condition,
                    'id_employee'       => $request->txt_id_users,
                    'device_location'   => $request->txt_device_location,
                    'desc'              => $request->txt_desc,
                    'created_at'        => date('Y-m-d h:i:s'),
                    'updated_at'        => date('Y-m-d h:i:s')
                ]);
                Alert::success('Success', 'New Office Asset Added');
                return redirect()->route('index_office_asset');
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error add data : ',
                    'errors'    => $ex
                ], 401);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    public function QR_Code_Generate(Request $request)
    {
        $txt_id_asset = $request->txt_id_asset;
        $fetch_data = DB::table('office_asset')
            ->join('device_master', 'device_master.id_device', '=', 'office_asset.id_device')
            ->join('employee', 'employee.id_employee', '=', 'office_asset.id_employee')
            ->join('users', 'users.id', '=', 'employee.id_users')
            ->where('office_asset.id_asset', '=', $txt_id_asset)
            ->get();
        foreach ($fetch_data as $item_fetch) {
            $device_name = $item_fetch->device_name;
            $device_user = $item_fetch->name;
            $device_location = $item_fetch->device_location;
            $asset_code = $item_fetch->asset_code;
        }

        $string = "Device Name : " . $device_name . " | User : " . $device_user . " | Location : " . $device_location;
        $from = [255, 0, 0];
        $to = [0, 0, 255];
        $img = public_path('assets\dist\img\logo.png');
        $pngImage = QrCode::format('png')
            ->merge($img, 0.3, true)
            ->size(300)
            ->errorCorrection('H')
            ->style('dot')
            ->eye('circle')
            ->gradient($from[0], $from[1], $from[2], $to[0], $to[1], $to[2], 'diagonal')
            ->margin(1)
            ->generate($string);
        $output_file = '/img/qr-code/' . $asset_code . '.png';
        Storage::disk('local')->put($output_file, $pngImage); //storage/app/public/img/qr-code/img-1557309130.png
        // return response($pngImage)->header('Content-type', 'image/png');
        // return response($pngImage)->header('Content-type', 'image/png');
        Alert::success('Success', 'QR Code Created');
        return redirect()->route('index_office_asset');
    }

    public function test_qr()
    {
        // $renderer = new ImageRenderer(
        //     new RendererStyle(400),
        //     new ImagickImageBackEnd()
        // );
        // $writer = new Writer($renderer);
        // $writer->writeFile('Testing', 'qr_code.png');

    }
}
