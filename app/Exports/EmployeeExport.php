<?php

namespace App\Exports;

use App\Models\Csv;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\LaravelNovaExcel\Actions\ExportToExcel;

class EmployeeExport implements FromCollection
{
    private $fileName = 'HandHoles.csv';

    /**
     * Optional Writer Type
     */

    /**
     * Optional headers
     */
    private $headers = [
        'Content-Type' => 'text/csv',
    ];
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Csv::all();
    }

    public function view()
    {
        return view('csv_export', [
            'employees' => $this->collection(),
            'fileName' => $this->fileName,
            'headers' => $this->headers,
        ]);
    }


}
