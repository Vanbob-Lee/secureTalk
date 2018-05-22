<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Exception;
use App\User;
use Illuminate\Support\Facades\Cache;

include_once app_path().'/Tools/numpy.php';

class OpenCtrl extends Controller
{
    // 定义为常量可能更好
    private $p = 71, $q = 97, $N = 6887, $fi = 6720;

    //
    public function __invoke(Request $req, $part=null)
    {
        $prot = ['get_pri_key'];  // 其余某些函数，因为参数不对，本来就不能被调用
        if (in_array($part, $prot)) {
            throw new Exception("Can't Access Function: $part");
        }
        return $this->$part($req);
    }

    // 模幂运算（需要知道p q）
    private function mod_exp_pq($m, $key) {
        $p = $this->p; $q = $this->q;
        $m1 = $m % $p;
        $m2 = $m % $q;
        $e1 = $key % ($p-1);
        $e2 = $key % ($q-1);
        $t2 = reverse($p, $q);
        $t1 = reverse($q, $p);
        $a1 = pow($m1, $e1);
        $x1 = $a1 % $p;
        $a2 = pow($m2,$e2);
        $x2 = $a2 % $q;
        $c = ($x1*$q*$t1 + $x2*$p*$t2) % ($p*$q);
        return $c;
    }

    private function mod_exp($m, $key) {
        $n = $this->N;
        $i = 0; $val = 1;
        while ($i++ < $key) {
            $val *= $m;
            $val %= $n;
        }
        return $val;
    }

    private function get_pri_key() {
        $user = Auth::user();
        if (!$user) {
            throw new Exception("Not Login");
        }

        return Cache::rememberForever('pri_'.$user->id, function () use($user){
            $pub = $this->get_pub_inner($user->id);
            return reverse($pub, $this->fi);
        });
    }

    // 访问别人的私钥
    private function get_pri_insecure($uid) {
        return Cache::rememberForever('pri_'.$uid, function () use($uid){
            $pub = $this->get_pub_inner($uid);
            return reverse($pub, $this->fi);
        });
    }

    // 公钥：截取字符
    private function get_pub_inner($uid) {
        return Cache::rememberForever("pub_$uid", function () use($uid){
            $user = User::find($uid);
            $last = ord(substr($user->password, -1));
            return get_prime($last, $this->fi);
        });
    }

    private function get_pub_key($req) {
        return [
            'pub' => $this->get_pub_inner($req->id),
            'n' => $this->N
        ];
    }

    private function signature($req) {
        $pri_key = $this->get_pri_key();
        $hash = $req->hash;
        $sign_vals = [];
        for($i=0; $i<32; $i++) {
            $val = hexdec($hash[$i]);
            $sign_val = $this->mod_exp($val, $pri_key);
            $sign_vals[] = $sign_val;
        }
        return $sign_vals;
    }

    private function get_ks($req) {
        $pri_key = $this->get_pri_key();
        return $this->mod_exp($req->env, $pri_key);
    }

    private function get_history_ks($req) {
        $pri_key = $this->get_pri_insecure($req->uid);
        return $this->mod_exp($req->env, $pri_key);
    }
}
