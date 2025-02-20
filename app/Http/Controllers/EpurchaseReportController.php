<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class EpurchaseReportController extends Controller
{
    public function index(){
        return view('layouts.epurchase.index_report');
    }

    public function epurchase_report(){
        return view('layouts.epurchase.epurchase_report');
    }

    public function epurchase_search_result(Request $request){
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

    public function print_pr_epurchase($id)
    {
        $pr_no = $id;
        $data = ['pr_no' => $pr_no];
        $pdf = Pdf::loadView('components.pdf.pr_print', $data);
        // $pdf->loadHTML($pr_no);
        return $pdf->stream("$pr_no.pdf");
    }
    public function print_po_epurchase($id)
    {
        $po_no = $id;
        $data = ['po_no' => $po_no];
        $pdf = Pdf::loadView('components.pdf.po_print', $data);
        // $pdf->loadHTML($po_no);
        return $pdf->stream("$po_no.pdf");
    }
}
