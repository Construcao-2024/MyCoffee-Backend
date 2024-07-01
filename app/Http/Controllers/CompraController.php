<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Produto;
use Illuminate\Support\Facades\Log;
use App\Services\CompraService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Exception;


class CompraController extends Controller
{
    protected $compraService;

    public function __construct(CompraService $compraService)
    {
        $this->compraService = $compraService;
    }

    /**
     * @OA\Get(
     *     path="/api/compras/{id}",
     *     summary="Get a specific compra with its products",
     *     tags={"Compras"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time"),
     *             @OA\Property(property="produtos", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="nome", type="string"),
     *                 @OA\Property(property="preco", type="number"),
     *                 @OA\Property(property="quantidade", type="integer")
     *             ))
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Compra not found"
     *     )
     * )
     */

    public function show($id)
    {
        $compra = $this->compraService->getComprasComProdutos($id);
        return response()->json($compra);
    }

    /**
     * @OA\Get(
     *     path="/api/compras/{id}/produtos",
     *     summary="Get all products of a specific compra",
     *     tags={"Compras"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="nome", type="string"),
     *             @OA\Property(property="preco", type="number"),
     *             @OA\Property(property="quantidade", type="integer")
     *         ))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Compra not found"
     *     )
     * )
     */

    public function getProducts($id)
    {
        $produtos = $this->compraService->getProdutosByComprasId($id);
        return response()->json($produtos);
    }

    /**
     * @OA\Get(
     *     path="/api/compras/{id}/total",
     *     summary="Calculate the total of a compra",
     *     tags={"Compras"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="total", type="number")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Compra not found"
     *     )
     * )
     */

    public function calculateTotal($id)
    {
        $total = $this->compraService->calculateTotal($id);
        return response()->json(['total' => $total]);
    }

    // Adicionar um produto a uma compra
    /*public function addProductToPurchase(Request $request, $id)
    {
        $validatedData = $request->validate([
            'produto_id' => 'required|exists:products,id',
            'quantidade' => 'required|integer|min:1',
        ]);

        $this->compraService->addProdutoToCompra($id, $validatedData['produto_id'], $validatedData['quantidade']);
        return response()->json(['message' => 'produto adicionado k k']);
    }*/


    /**
     * @OA\Post(
     *     path="/api/compras",
     *     summary="Create a new compra",
     *     tags={"Compras"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="produtos", type="array", @OA\Items(
     *                 @OA\Property(property="produto_id", type="integer"),
     *                 @OA\Property(property="quantidade", type="integer")
     *             ))
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Compra created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time"),
     *             @OA\Property(property="produtos", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="nome", type="string"),
     *                 @OA\Property(property="preco", type="number"),
     *                 @OA\Property(property="quantidade", type="integer")
     *             ))
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="An unexpected error occurred"
     *     )
     * )
     */

    public function store(Request $request)
    {
        Log::info('Request to store purchase:', ['request' => $request->all()]);

        try {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'produtos' => 'required|array',
                'produtos.*.produto_id' => 'required|exists:produtos,id',
                'produtos.*.quantidade' => 'required|integer|min:1',
            ]);

            Log::info('Validated data for storing purchase:', $validatedData);

            $compra = $this->compraService->createCompra($validatedData['user_id'], $validatedData['produtos']);
            Log::info('Compra criada:', ['compra' => $compra]);

            return response()->json($compra, 201);
        } catch (ValidationException $e) {
            Log::error('Validation error:', ['errors' => $e->errors()]);
            return response()->json(['errors' => $e->errors()], 422);
        } catch (Exception $e) {
            Log::error('An unexpected error occurred:', ['exception' => $e]);
            return response()->json(['error' => 'An unexpected error occurred. Please try again later.'], 500);
        }
    }
}
