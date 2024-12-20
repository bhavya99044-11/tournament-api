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
    public function hello(){
        dd(1);
    }
}
