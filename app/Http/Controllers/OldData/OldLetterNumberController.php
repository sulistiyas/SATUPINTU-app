<?php

namespace App\Http\Controllers\OldData;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OldLetterNumberController extends Controller
{
    public function index_letter_2018()
    {
        $fetch_data = DB::table('tbl_letter_number_2018')->orderBy('nomor_urut', 'desc')->get();
        return view('layouts.old_data.letter_number.2018', ['letter_number' => $fetch_data]);
    }

    public function index_letter_2019()
    {
        $fetch_data = DB::table('tbl_letter_number_2019')->orderBy('nomor_urut', 'desc')->get();
        return view('layouts.old_data.letter_number.2019', ['letter_number' => $fetch_data]);
    }

    public function index_letter_2020()
    {
        $fetch_data = DB::table('tbl_letter_number_2020')->orderBy('nomor_urut', 'desc')->get();
        return view('layouts.old_data.letter_number.2020', ['letter_number' => $fetch_data]);
    }

    public function index_letter_2021()
    {
        $fetch_data = DB::table('tbl_letter_number_2021')->orderBy('nomor_urut', 'desc')->get();
        return view('layouts.old_data.letter_number.2021', ['letter_number' => $fetch_data]);
    }

    public function index_letter_2022()
    {
        $fetch_data = DB::table('tbl_letter_number_2022')->orderBy('nomor_urut', 'desc')->get();
        return view('layouts.old_data.letter_number.2022', ['letter_number' => $fetch_data]);
    }

    public function index_letter_2023()
    {
        $fetch_data = DB::table('tbl_letter_number_2023')->orderBy('nomor_urut', 'desc')->get();
        return view('layouts.old_data.letter_number.2023', ['letter_number' => $fetch_data]);
    }

    public function index_letter_2024()
    {
        $fetch_data = DB::table('tbl_letter_number_2024')->orderBy('nomor_urut', 'desc')->get();
        return view('layouts.old_data.letter_number.2024', ['letter_number' => $fetch_data]);
    }
}
