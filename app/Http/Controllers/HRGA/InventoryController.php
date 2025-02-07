<?php

namespace App\Http\Controllers\HRGA;

use App\Http\Controllers\Controller;
use App\Models\Furniture;
use Illuminate\Http\Request;
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
            'condition' => 'required'
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Please fill all the required fields');
            return redirect()->back();
        } else {
            Furniture::create([
                'item_name' => $request->item_name,
                'quantity' => $request->quantity,
                'condition' => $request->condition
            ]);
            Alert::success('Success', 'Furniture added successfully');
            return redirect()->route('index_furniture');
        }
    }

    public function edit_furniture($id)
    {
        $furniture = \App\Models\Furniture::find($id);
        return view('hr_ga.inventory.furniture.edit', compact('furniture'));
    }

    public function update_furniture(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'qty' => 'required',
            'condition' => 'required'
        ]);

        $furniture = \App\Models\Furniture::find($id);
        $furniture->update($request->all());
        return redirect()->route('hr_ga.inventory.furniture.index')->with('success', 'Furniture updated successfully');
    }   

    public function destroy_furniture($id)
    {
        $furniture = \App\Models\Furniture::find($id);
        $furniture->delete();
        return redirect()->route('hr_ga.inventory.furniture.index')->with('success', 'Furniture deleted successfully');
    }
}
