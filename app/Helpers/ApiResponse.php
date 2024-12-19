<?php
namespace App\Helpers;
class ApiResponse
{

     static function success($message=null,$data=null,$meta=null,$status=200){

        $response=[
            'status'=>true,
            'message' => $message,
            'data'=>$data
        ];


        if($meta){
            $response['meta'] = $meta;
        }
        return response()->json($response,$status);
    }

   static function error($message='error', $status = 400){
        return response()->json([
            'status' => false,
           'message' => $message
        ], $status);
    }
}
