<?php
namespace App\Helpers;
class ApiResponse
{
    public static  function success($message=null,$data=null,$meta=null){

        $response=[
            'status'=>true,
            'message' => $message,
        ];
        if($data){
            $response['data']=$data;
        }
        if($meta){
            $response['meta'] = $meta;
        }
        return response()->json($response,200);
    }

    public static function error($message='error', $status = 400){
        return response()->json([
            'status' => 'error',
           'message' => $message
        ], $status);
    }
}
