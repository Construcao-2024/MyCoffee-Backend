<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends User
{
    protected $fillable = ['user_id', 'cpf', 'telefone', 'endereco_id', 'isDeleted'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'endereco_id');
    }
}
