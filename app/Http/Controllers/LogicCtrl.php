<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Exception;
use App\User;

class LogicCtrl extends Controller
{
    //
    public function __invoke(Request $req, $part=null)
    {
        return $this->$part($req);
    }

    public function logout() {
        Auth::logout();
    }

    public function edit_info($req) {
        $info = $req->post();
        $uid = $info['id']; $name = $info['name'];
        unset($info['id'], $info['name']);
        $info_str = json_encode($info);
        User::find($uid)->update(['info' => $info_str, 'name'=> $name]);
        return redirect('/view/index');
    }

    public function add_contact($req) {
        try {
            DB::table('contacts')->insert(
                ['user_id' => $req->my_id, 'con_id' => $req->uid]
            );
            return "添加成功，请返回通讯录查看";
        } catch (Exception $e) {
            return "添加失败，可能进行了重复添加";
        }
    }

    public function del_contact($req) {
        DB::table('contacts')
            ->where('user_id', $req->my_id)
            ->where('con_id', $req->uid)->delete();
        return "已删除";
    }
}