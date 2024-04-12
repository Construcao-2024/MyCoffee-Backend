<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends User
{
    protected $filliable = ['userId', 'cpf', 'cargo', 'isDeleted'];
}


