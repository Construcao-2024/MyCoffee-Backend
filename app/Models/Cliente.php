<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends User
{
    protected $fillable = ['userId', 'cpf', 'telefone', 'endereco', 'isDeleted'];
}
