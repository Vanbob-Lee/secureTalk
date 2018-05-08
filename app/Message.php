<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    const UPDATED_AT = null;  // 无需维护updated_at
    protected $guarded = ['id'];  // 必须写这句，否则所有字段都为不可更改
    public function sender() {
        return $this->belongsTo('App\User', 'sender_id');
    }

    public function recv() {
        return $this->belongsTo('App\User', 'recv_id');
    }
}
