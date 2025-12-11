<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NkapMessage extends Model
{
    use HasFactory;

    protected $table = 'nkap_messages';

    protected $fillable = [
        'expediteur_id',
        'destinataire_id',
        'conversation_id',
        'contenu',
        'type',
        'lu',
        'date_lecture',
    ];

    protected $casts = [
        'lu' => 'boolean',
        'date_lecture' => 'datetime',
    ];

    public function expediteur()
    {
        return $this->belongsTo(NkapUser::class, 'expediteur_id');
    }

    public function destinataire()
    {
        return $this->belongsTo(NkapUser::class, 'destinataire_id');
    }

    public function conversation()
    {
        return $this->belongsTo(NkapConversation::class, 'conversation_id');
    }

    public function marquerCommeLu(): void
    {
        if (!$this->lu) {
            $this->lu = true;
            $this->date_lecture = now();
            $this->save();
        }
    }
}
