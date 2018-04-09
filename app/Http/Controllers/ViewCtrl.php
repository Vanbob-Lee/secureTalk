<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewCtrl extends Controller
{
    //
    public function __invoke(Request $req, $part=null)
    {
        return $this->$part($req);
    }

    public function index() {
        return view('index');
    }
}
