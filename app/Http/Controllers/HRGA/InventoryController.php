<?php

namespace App\Http\Controllers\HRGA;

use App\Http\Controllers\Controller;
use App\Models\Furniture;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index_furniture()
    {
        $furnitures = \App\Models\Furniture::all();
        return view('hr_ga.inventory.furniture.index', compact('furnitures'));
    }
    public function store_furniture(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_name' => 'required',
            'quantity' => 'required',
            'condition' => 'required',
            
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Please fill all the required fields');
            return redirect()->back();
        } else {
            $file = $request->file('furniture_image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $filepath = $file->storeAs('furniture_image', $filename, 'public');
                Furniture::create([
                    'item_name' => $request->item_name,
                    'quantity' => $request->quantity,
                    'condition' => $request->condition,
                    'furniture_image' => $filepath
                ]);
                dd($filepath);
                Alert::success('Success', 'Furniture added successfully');
                return redirect()->route('index_furniture');            
        }
    }

    public function edit_furniture(string $id)
    {
        $furniture_data = Furniture::find($id);
        return response()->json($furniture_data);
    }

    public function update_furniture(Request $request)
    {
        $furniture_data = Furniture::where('id_furniture', $request->id_furniture)->first();
        $validator = Validator::make($request->all(), [
            'item_name' => 'required',
            'quantity' => 'required',
            'condition' => 'required'
        ]);
        if ($validator->fails()) {
            Alert::error('Error', 'Please fill all the required fields');
            return redirect()->back();
        } else {
            $furniture_data->update([
                'item_name' => $request->item_name,
                'quantity' => $request->quantity,
                'condition' => $request->condition,
                'updated_at' => date('Y-m-d h:i:s')
            ]);
            Alert::success('Success', 'Furniture updated successfully');
            return redirect()->route('index_furniture');
        }
        

    }   

    public function destroy_furniture(string $id)
    {
        $furniture_data = Furniture::where('id_furniture', $id)->first();
        try {
            $furniture_data->delete();
            Alert::success('Success', 'Furniture deleted successfully');
            return redirect()->route('index_furniture');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to delete furniture');
            return redirect()->route('index_furniture');
        }
    }

    public function generateQR(){
        // return QrCode::generate(
        //     'Hello, World!',
        // );
        $file = Storage::disk('public')->path('logo/inl.png');
        // $img = ; 
        $data = QrCode::size(512)
            ->format('png')
            ->mergeString(@imagecreatefrompng($file))
            ->errorCorrection('M')
            ->generate(
                'https://twitter.com/HarryKir',
            );

        return response($data)
            ->header('Content-type', 'image/png');

        // return response()->streamDownload(
        //     function () {
        //         echo QrCode::format('png')
        //         ->size(200)
        //         ->generate('Hello, World!');
        //     }
        //     ,  
        //     'qr-code.png',
        //     [
        //         'Content-Type' => 'image/png',
        //     ]
        // );
    }
}
