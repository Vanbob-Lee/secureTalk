<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ViewCtrl extends Controller
{
    //
    public function __invoke(Request $req, $part=null)
    {
        $data = $this->$part($req);
        return view($part, $data);
    }

    private function index() {
        return [];
    }

    private function search($req) {
        if (!$req->keyword) return [];
        $results = User::orwhere('name', 'like', '%'.$req->keyword.'%')
            ->orwhere('email', 'like', '%'.$req->keyword.'%')
            ->get()->all();
        return compact('results');
    }

    private function info($req) {
        $user = User::find($req->id);
        return compact('user');
    }
}
