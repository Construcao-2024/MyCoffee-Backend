<?php

namespace App\Services;

use App\Models\Carrinho;
use App\Models\Produto;
use Illuminate\Support\Facades\Auth;

class CarrinhoService
{
    /**
     * aqui adiciona um produto ao carrinho do usuário autenticado.
     *
     * @param int $produtoId
     * @param int $quantidade
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    public function addToCart($produtoId, $quantidade)
    {
        $user = Auth::user();

        if (!$user) {
            throw new \Exception('Usuário não autenticado.');
        }

        // Verifica se o usuário já possui um carrinho ativo
        $carrinho = Carrinho::firstOrCreate(['user_id' => $user->id]);

        // Adiciona o produto ao carrinho ou atualiza a quantidade se já estiver presente
        $carrinho->produtos()->syncWithoutDetaching([
            $produtoId => ['quantidade' => $quantidade, 'user_id' => $user->id]
        ]);

        // Atualiza o total do carrinho
        $this->updateCartTotal($carrinho);

        // Retorna os produtos do carrinho atualizados
        return $carrinho->produtos()->withPivot('quantidade')->get();
    }

    /**
     * Retorna os itens do carrinho do usuário autenticado.
     *
     * @return \App\Models\Carrinho|null
     */
    public function getCartItems()
    {
        $user = Auth::user();
        return Carrinho::where('user_id', $user->id)->with('produtos')->first();
    }

    /**
     * 
     *
     * @param int $produtoId
     * @return void
     */
    public function removeFromCart($produtoId)
    {
        $user = Auth::user();
        $carrinho = Carrinho::where('user_id', $user->id)->firstOrFail();
        $carrinho->produtos()->detach($produtoId);

        // Atualiza o total do carrinho
        $this->updateCartTotal($carrinho);
    }

    /**
     * 
     *
     * @return void
     */
    public function clearCart()
    {
        $user = Auth::user();
        $carrinho = Carrinho::where('user_id', $user->id)->firstOrFail();
        $carrinho->produtos()->detach();

     
        $this->updateCartTotal($carrinho);
    }

    /**
     * Atualiza o total do carrinho baseado nos produtos e suas quantidades.
     *
     * @param \App\Models\Carrinho $carrinho
     * @return void
     */
    private function updateCartTotal(Carrinho $carrinho)
    {
        $total = $carrinho->produtos->sum(function ($produto) {
            return $produto->preco * $produto->pivot->quantidade;
        });

        $carrinho->total = $total;
        $carrinho->save();
    }
}
