<?php

namespace App\Http\Controllers;

use App\ActionEvent;
use Illuminate\Http\Request;

class C_DataActionEvent extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('gets');
    }

    public function gets() {
        $events = ActionEvent::get();
        return response()->json([
           'success' => true,
           'events' => $events
        ]);
    }
}
