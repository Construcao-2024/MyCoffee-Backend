<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CarrinhoService;


/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="API Documentation",
 *      description="Swagger OpenApi description",
 *      @OA\Contact(
 *          email="support@example.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="API Server"
 * )
 */

class CarrinhoController extends Controller

{


    /**
     * @OA\Schema(
     *     schema="Produto",
     *     type="object",
     *     title="Produto",
     *     properties={
     *         @OA\Property(property="id", type="integer", example=1),
     *         @OA\Property(property="nome", type="string", example="Produto A"),
     *         @OA\Property(property="preco", type="number", format="float", example=19.99),
     *         @OA\Property(property="descricao", type="string", example="Descrição do produto A"),
     *     }
     * )
     */

    protected $carrinhoService;

    public function __construct(CarrinhoService $carrinhoService)
    {
        $this->carrinhoService = $carrinhoService;
    }


    /**
     * @OA\Post(
     *     path="/api/cart",
     *     summary="Add product to cart",
     *     tags={"Cart"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"produto_id", "quantidade"},
     *             @OA\Property(property="produto_id", type="integer", example=1),
     *             @OA\Property(property="quantidade", type="integer", example=2),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Product added to cart",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Produto")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     )
     * )
     */
    public function addToCart(Request $request)
    {
        $validatedData = $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
        ]);

        $carrinhoProduto = $this->carrinhoService->addToCart($validatedData['produto_id'], $validatedData['quantidade']);
        return response()->json($carrinhoProduto, 201);
    }


    /**
     * @OA\Get(
     *     path="/api/cart",
     *     summary="Get user's cart",
     *     tags={"Cart"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="User's cart",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Produto")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */

    public function getCart()
    {
        $carrinho = $this->carrinhoService->getCartItems();
        return response()->json($carrinho);
    }




    /**
     * @OA\Delete(
     *     path="/api/cart/{produtoId}",
     *     summary="Remove product from cart",
     *     tags={"Cart"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         name="produtoId",
     *         in="path",
     *         required=true,
     *         description="ID of the product to be removed from the cart",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product removed from cart successfully"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found in cart"
     *     )
     * )
     */

    public function removeFromCart($produtoId)
    {
        $this->carrinhoService->removeFromCart($produtoId);
        return response()->json(['message' => 'Produto removido do carrinho com sucesso']);
    }



    /**
     * @OA\Delete(
     *     path="/api/cart",
     *     summary="Clear cart",
     *     tags={"Cart"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Cart cleared successfully"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */

    public function clearCart()
    {
        $this->carrinhoService->clearCart();
        return response()->json(['message' => 'Carrinho esvaziado com sucesso']);
    }
}
