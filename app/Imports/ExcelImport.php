<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Csv;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class ExcelImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $validation=Validator::make($rows->toArray(),[
            '*.first_name'=>'required',
            '*.last_name'=>'required',
            '*.gender'=>'required',
        ]);
        log::info($validation->errors());

        if($validation->fails()){
            return response()->json([
                'errors'=>$validation->errors(),
                'code'=>422,
               'message'=>'Validation errors'
            ]);
        }
          Excel::create('data.csv',function(){

          });
    }


}
