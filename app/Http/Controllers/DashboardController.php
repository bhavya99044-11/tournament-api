<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Tournament;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{

    public $data;

    public function __construct(){

    }
    public function dashboard(){
        $this->data['tournaments']=Tournament::selectRaw(
            'count(case when status=0 then 1 end) as upcoming_tournament,
            count(case when status=1 then 1 end) as live_tournament,
            count(case when status=2 then 1 end) as completed_tournament,
            count(case when status=3 then 1 end) as canceled_tournament'
        )->first();

        return view('admin-panel.dashboard')->with('data',$this->data);
    }

    public function index(){

    }

    public function token(Request $request ,$token){
    }
}
