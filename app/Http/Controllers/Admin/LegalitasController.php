<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Jobs\LegalitasScheduler;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\LegalitasOffice;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Console\Scheduling\Schedule;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class LegalitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function task_scheduler()
    {
        // Schedule::job(new LegalitasScheduler)->everyFiveSeconds();
    }
    public function index()
    {
        $legalitas_office = DB::table('legalitas_office')->orderBy('id_legalitas', 'desc')->get();
        return view('admin.administration.legalitas.index', ['legalitas_office' => $legalitas_office]);
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
        $validator = Validator::make($request->all(), [
            'txt_no_legalitas' => 'required',
            'txt_dokumen' => 'required',
            'txt_issued' => 'required',
            'txt_expiry' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validator->errors()
            ]);
        } else {
            try {
                $now = date('Y-m-d');
                if ($request->txt_expiry < $now) {
                    $status = 3;
                } else {
                    $status = 1;
                }

                LegalitasOffice::create([
                    'no_legalitas'      => $request->txt_no_legalitas,
                    'dokumen'           => $request->txt_dokumen,
                    'nama_perusahaan'   => $request->txt_comp,
                    'terbit'            => $request->txt_issued,
                    'berakhir'          => $request->txt_expiry,
                    'status'            => $status,
                    'created_at'        => date('Y-m-d h:i:s'),
                    'updated_at'        => date('Y-m-d h:i:s')
                ]);
                Alert::success('Success', 'New Legalitas Added');
                return redirect()->route('index_office_legalitas');
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error add data : ',
                    'errors'    => $ex
                ], 401);
                Alert::warning('Warning', 'Failed to add Legalitas !!');
                return redirect()->route('index_office_legalitas');
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
        $data_legalitas = DB::table('legalitas_office')->where('id_legalitas', '=', $id)->get();
        return view('components.modals.admin_area.legalitas_edit', ['data_legalitas' => $data_legalitas]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $legalitas_data = LegalitasOffice::where('id_legalitas', '=', $request->txt_id_legalitas)->first();
        $validator = Validator::make($request->all(), [
            'txt_no_legalitas' => 'required',
            'txt_dokumen' => 'required',
            'txt_issued' => 'required',
            'txt_expiry' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validator->errors()
            ]);
        } else {
            try {
                $legalitas_data->update([
                    'no_legalitas'      => $request->txt_no_legalitas,
                    'dokumen'           => $request->txt_dokumen,
                    'nama_perusahaan'   => $request->txt_comp,
                    'terbit'            => $request->txt_issued,
                    'berakhir'          => $request->txt_expiry,
                    'status'            => $request->txt_status,
                    'updated_at'        => date('Y-m-d h:i:s')
                ]);
                Alert::success('Success', 'Successfully Update Legalitas Data');
                return redirect()->route('index_office_legalitas');
            } catch (\Exception $ex) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error : ',
                    'errors'    => $ex
                ], 401);
                Alert::error('Error', 'Error Update Legalitas Data');
                return redirect()->route('index_office_legalitas');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
