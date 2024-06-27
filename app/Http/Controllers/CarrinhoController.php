<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CarrinhoService;

class CarrinhoController extends Controller
{
    protected $carrinhoService;

    public function __construct(CarrinhoService $carrinhoService)
    {
        $this->carrinhoService = $carrinhoService;
    }

    public function addToCart(Request $request)
    {
        $validatedData = $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
        ]);

        $carrinhoProduto = $this->carrinhoService->addToCart($validatedData['produto_id'], $validatedData['quantidade']);
        return response()->json($carrinhoProduto, 201);
    }

    public function getCart()
    {
        $carrinho = $this->carrinhoService->getCartItems();
        return response()->json($carrinho);
    }

    public function removeFromCart($produtoId)
    {
        $this->carrinhoService->removeFromCart($produtoId);
        return response()->json(['message' => 'Produto removido do carrinho com sucesso']);
    }

    public function clearCart()
    {
        $this->carrinhoService->clearCart();
        return response()->json(['message' => 'Carrinho esvaziado com sucesso']);
    }
}
