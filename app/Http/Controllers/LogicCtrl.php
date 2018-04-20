<?php

namespace App\Http\Controllers;

use App\Message;
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
        if (!Auth::check())
            throw new Exception('Not Login');
        return $this->$part($req);
    }

    private function logout() {
        Auth::logout();
    }

    private function edit_info($req) {
        $info = $req->post();
        $uid = $info['id']; $name = $info['name'];
        unset($info['id'], $info['name']);
        $info_str = json_encode($info);
        User::find($uid)->update(['info' => $info_str, 'name'=> $name]);
        return redirect('/view/index');
    }

    private function add_contact($req) {
        try {
            DB::table('contacts')->insert(
                ['user_id' => $req->my_id, 'con_id' => $req->uid]
            );
            return "添加成功，请返回通讯录查看";
        } catch (Exception $e) {
            return "添加失败，可能进行了重复添加";
        }
    }

    private function del_contact($req) {
        DB::table('contacts')
            ->where('user_id', $req->my_id)
            ->where('con_id', $req->uid)->delete();
        return "已删除";
    }

    private function send_msg($req) {
        $msg = $req->post();
        $obj = Message::create($msg);
        return (string)$obj->created_at;
    }

    private function receive($req) {
        $buider = Message::where('recv_id', $req->recv_id)
            ->where('sender_id', $req->sender_id)
            ->where('read', 0);
        $msg = $buider->get()->all();
        $buider->update(['read' => 1]);
        return $msg;
    }

    private function unread($req) {
        $sql = <<<mark
select users.id uid, users.name, users.head, content, sub_table.count unread_count
from users, messages, (
  select sender_id, max(created_at) maxTime, count(*) `count`
  from messages where 
  recv_id = ? and `read` = 0 group by sender_id
) sub_table
where sub_table.sender_id = users.id and
messages.created_at = sub_table.maxTime;
mark;
        $messages = DB::select($sql, [$req->id]);
        return $messages;
    }
}
