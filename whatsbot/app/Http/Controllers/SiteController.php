<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Webhook;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    //
    public function index(Request $request) {

        $webhook = Webhook::find(12);
        $myObject = json_decode($webhook->webhook);
        $reqId = json_decode($myObject->entry[0]->id);
        return view('hello-message');
    }
}
