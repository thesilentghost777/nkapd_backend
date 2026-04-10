<?php

namespace App\Models\BrFinal;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'br_messages';

    protected $fillable = ['assistance_id', 'sender_id', 'contenu', 'lu'];

    protected $casts = ['lu' => 'boolean'];

    public function assistance()
    {
        return $this->belongsTo(AssistanceRequest::class, 'assistance_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
