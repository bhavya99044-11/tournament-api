<?php
namespace App\Helpers;
class ApiResponse
{
    public static  function success($message=null,$data=null){
        return response()->json([
            'status' => true,
           'message' => $message,
           'data' => $data
        ],200);
    }

    public static function error($message='error', $status = 400){
        return response()->json([
            'status' => 'error',
           'message' => $message
        ], $status);
    }
}
