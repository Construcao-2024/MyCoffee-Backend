<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;
use App\Models\Compra;
use App\Models\Produto;
use Illuminate\Validation\ValidationException;
use Exception;

class CompraService{

    public function getComprasComProdutos($purchaseId)
    {
        return Compra::with('produtos')->findOrFail($purchaseId);
    }

    /*public function criarCompra($userId, $produtos)
{

    $total = 0;

    foreach ($produtos as $produtoData) {
        $produto = Produto::findOrFail($produtoData['produto_id']);
        $subtotal = $produto->preco * $produtoData['quantidade'];
        $total += $subtotal;
    }
    // Criação da compra
    $compra = Compra::create([
        'user_id' => $userId,
        'total'=> $total
        
    ]);

    // faz a associação dos produtos à compra
    foreach ($produtos as $produto) {
        // aqui adiciona o produto a compra com quantidade e preco
        $compra->produtos()->attach($produto['produto_id'], [
            'quantidade' => $produto['quantidade'],
            'preco' => $produto->preco, 
        ]);
    }

    // 
    return $compra;
}*/


    public function getProdutosByComprasId($compraId)
    {
        $compra = Compra::with('products')->findOrFail($compraId);
        return $compra->produtos;
    }

    public function calculateTotal($compraId)
    {
        $compra = Compra::with('produtos')->findOrFail($compraId);
        $total = 0;

        foreach ($compra->produtos as $produto) {
            $total += $produto->pivot->preco * $produto->pivot->quantidade;
        }

        return $total;
    }

    public function createCompra($userId, $produtos)
    {
        try {
            $total = 0;
            foreach ($produtos as $produtoData) {
                $produto = Produto::findOrFail($produtoData['produto_id']);
                $subtotal = $produto->preco * $produtoData['quantidade'];
                $total += $subtotal;
            }

            $compra = Compra::create([
                'user_id' => $userId,
                'total' => $total,
            ]);

            foreach ($produtos as $produtoData) {
                $produto = Produto::findOrFail($produtoData['produto_id']);
                $compra->produtos()->attach($produto->id, [
                    'quantidade' => $produtoData['quantidade'],
                    'preco' => $produto->preco,
                ]);
            }

            return $compra;
        } catch (Exception $e) {
            Log::error('Error in createCompra:', ['exception' => $e]);
            throw $e;
        }
    }

}