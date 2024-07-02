<?php

namespace App\Http\Controllers;

use App\Models\Webhook;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $data = Webhook::all();
        return view('index',compact('data'));
    }
}
