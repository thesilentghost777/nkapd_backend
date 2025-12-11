<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NkapConversation extends Model
{
    use HasFactory;

    protected $table = 'nkap_conversations';

    protected $fillable = [
        'participant1_id',
        'participant2_id',
        'type',
        'dernier_message_at',
    ];

    protected $casts = [
        'dernier_message_at' => 'datetime',
    ];

    public function participant1()
    {
        return $this->belongsTo(NkapUser::class, 'participant1_id');
    }

    public function participant2()
    {
        return $this->belongsTo(NkapUser::class, 'participant2_id');
    }

    public function messages()
    {
        return $this->hasMany(NkapMessage::class, 'conversation_id');
    }

    public function dernierMessage()
    {
        return $this->hasOne(NkapMessage::class, 'conversation_id')->latest();
    }

    public static function trouverOuCreer(int $user1Id, int $user2Id, string $type = 'prive'): self
    {
        $conversation = self::where(function ($query) use ($user1Id, $user2Id) {
            $query->where('participant1_id', $user1Id)
                  ->where('participant2_id', $user2Id);
        })->orWhere(function ($query) use ($user1Id, $user2Id) {
            $query->where('participant1_id', $user2Id)
                  ->where('participant2_id', $user1Id);
        })->first();

        if (!$conversation) {
            $conversation = self::create([
                'participant1_id' => $user1Id,
                'participant2_id' => $user2Id,
                'type' => $type,
            ]);
        }

        return $conversation;
    }
}
