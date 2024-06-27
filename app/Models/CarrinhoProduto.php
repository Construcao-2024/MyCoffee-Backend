<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarrinhoProduto extends Model
{
    protected $table = 'carrinho_produto';

    protected $fillable = [
        'user_id',
        'produto_id',
        'quantidade',
        'preco',
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }
}
