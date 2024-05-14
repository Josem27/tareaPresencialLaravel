<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;

class LogsController extends Controller
{
    public function listado(){
        $logs = Log::orderBy('fecha','desc')->get();
        return view('logs.logs',['logs' => $logs]);
    }
}