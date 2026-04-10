<?php

namespace App\Models\BrFinal;

use Illuminate\Database\Eloquent\Model;

class AssistanceRequest extends Model
{
    protected $table = 'br_assistance_requests';

    protected $fillable = ['user_id', 'sujet', 'description', 'type', 'statut', 'reponse_admin'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'assistance_id');
    }
}
