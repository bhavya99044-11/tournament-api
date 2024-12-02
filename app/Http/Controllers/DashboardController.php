<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class DashboardController extends Controller
{
    public function dashboard(){
        return view('admin-panel.dashboard');
    }

    public function index(){

    }

    public function token(Request $request ,$token){
        // Session::put('id_token_'.$token,$token);
        dd(Session::get('id_token_bhwwww'));
    }
}
