<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SelectedMemberChat extends Model
{
    //protected $with = ['comments', 'post_member'];
    
    public function comments()
    {
        return $this->hasMany(ChatMemberComment::class, 'chat_id', 'id');
    }

    public function post_member()
    {
        return $this->hasMany(ChatMemberPermission::class, 'chat_id', 'id');
    }
}
