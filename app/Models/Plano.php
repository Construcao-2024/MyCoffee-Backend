<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    protected $fillable = ["nome", "desconto", "ativo", "precoAnual", "precoMensal", "preco", "descricao","frete", "qntCafe"];
}
