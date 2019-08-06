<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeyController extends Controller
{
    public function keycheck(Request $request) 
    {
        $key = $request->get('key');
        if (DB::table('keys')->where('key', $key)->exists())
        {
            return response()->json(['authorisation' => 'valid']);
        }
        else
        {
            return response()->json(['authorisation' => 'unvalid']);
        }
    }
}
