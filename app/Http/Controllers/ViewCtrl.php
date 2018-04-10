<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use DB;

class ViewCtrl extends Controller
{
    //
    protected $me;
    public function __invoke(Request $req, $part=null)
    {
        $this->me = Auth::user();
        $data = $this->$part($req);
        return view($part, $data);
    }

    private function index() {
        if (!$this->me) return [];
        $contacts = DB::table('contacts')
            ->join('users', 'contacts.con_id', 'users.id')
            ->where('user_id', $this->me->id)
            ->select('contacts.id', 'name', 'head')
            ->get()->all();
        return compact('contacts');
    }

    private function search($req) {
        if (!$req->keyword) return [];
        $results = User::where('id', '!=', 3)
            ->where(function ($q) use($req) {
                $q->orwhere('name', 'like', '%'.$req->keyword.'%')
                    ->orwhere('email', 'like', '%'.$req->keyword.'%@%');
                // 防止搜索gmail而找出所有使用谷歌邮箱注册的用户
            })
            ->get()->all();
        return compact('results');
    }

    private function info($req) {
        $me = $this->me;
        if ($me) $info = json_decode($this->me->info);
        $user = User::find($req->id);
        return compact('user', 'me', 'info');
    }
}
