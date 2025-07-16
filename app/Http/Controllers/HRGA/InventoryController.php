<?php

namespace App\Http\Controllers\HRGA;

use App\Models\Furniture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index_furniture()
    {
        $furnitures = DB::table('furniture')->orderBy('id_furniture', 'desc')->get();
        if($furnitures->isEmpty()) {
            Alert::info('Info', 'No furniture found');
        }
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
                // dd($filepath);
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

    public function generateQR($id)
    {
        $item = Furniture::findOrFail($id);

        $qrContent = "Item Name: {$item->name}\n"
                . "Quantity: {$item->quantity}\n"
                . "Condition: {$item->condition}\n"
                . "Location: {$item->location}";

        $qrImage = QrCode::format('png')
            ->size(300)
            ->errorCorrection('H')
            ->generate($qrContent);

        $fileName = 'QR ITEM - ' . $item->item_name . '.png';

        return Response::make($qrImage, 200, [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => "attachment; filename={$fileName}"
        ]);
    }
}
