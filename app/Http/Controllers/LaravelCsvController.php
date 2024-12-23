<?php

namespace App\Http\Controllers;

use App\Imports\ExcelImport;
use Illuminate\Http\Request;
use App\Models\Csv;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeeExport;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\HeadingRowImport;

class LaravelCsvController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filename = 'Cr.xlsx';

        Csv::query()->storeExcel('query-store.csv');
        // return view('csv');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        Excel::import(new ExcelImport,$request->file('csv_file') );

        return redirect()->back()->with('successsuccess');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function csvCreate(Request $request)
    {

      $data=  Excel::import(new ExcelImport,$request->file('csv_file') );
      return redirect()->back()->with('successsuccess');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

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
}
