<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produto;

class Compra extends Model
{
    protected $fillable = ['user_id', 'total'];


    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'compra_produto')
                    ->withPivot('quantidade', 'preco')
                    ->withTimestamps();
    }
}
