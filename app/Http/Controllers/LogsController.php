<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logs;

class LogsController extends Controller
{
    public function repLogs(){
        $logs = Logs::join('actual','logs.codactual','=','actual.id')
        ->select('actual.codigo','logs.descripcion','logs.user','logs.created_at')->get();
        return response()->json(['logs' => $logs]);      
    }
}
