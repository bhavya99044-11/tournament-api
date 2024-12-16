<?php
namespace App\Helpers;
class ApiResponse
{
    public static  function success($message=null,$data=null,$meta=null,$status=200){

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

    public static function error($message='error', $status = 400){
        return response()->json([
            'status' => 'error',
           'message' => $message
        ], $status);
    }
}
