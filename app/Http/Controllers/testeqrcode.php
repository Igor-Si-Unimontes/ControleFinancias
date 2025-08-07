<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class testeqrcode extends Controller
{
    public function index()
    {
        return view('qrcode.index');
    }
}
