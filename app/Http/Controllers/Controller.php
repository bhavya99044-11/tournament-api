<?php

namespace App\Http\Controllers;
/**
 * REST API route base class.
 *
 * @OA\Info(
 *     title="Test API REST",
 *     version="latest",
 *     description="test"
 * )
 */
abstract class Controller
{


     public  function success($message=null,$data=null,$meta=null,$status=200){

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

   public  function error($message='error', $status = 400){
        return response()->json([
            'status' => false,
           'message' => $message
        ], $status);
    }
}


