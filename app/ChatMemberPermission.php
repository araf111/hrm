<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMemberPermission extends Model
{
    protected $with = ['chat'];

    //
    public function chat()
    {
        return $this->belongsTo(SelectedMemberChat::class, 'chat_id');
    }
}
