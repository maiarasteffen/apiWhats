<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Webhook;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    //
    public function index(Request $r) {

        $data = $r->all();
        $request_type = $r->method();

        $dataToString = json_encode($data);
        Webhook::create(['webhook' => $dataToString, 'type' => $request_type]);
        // return $data['hub_challenge'];
    }
}
