<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = ['idCategoria', 'nome','marca', 'preco', 'codigoBarras', 'descricao', 'quantidade', 'imagens', 'desconto', 'isDeleted',];

    public function purchases()
    {
        return $this->belongsToMany(Compra::class, 'compra_produto')
                    ->withPivot('quantidade', 'preco')
                    ->withTimestamps();
    }

    public function carrinhos()
    {
        return $this->belongsToMany(CarrinhoProduto::class, 'carrinho_produto')
                    ->withPivot('quantidade')
                    ->withTimestamps();
    }
}
