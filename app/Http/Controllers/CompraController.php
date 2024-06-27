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

    //    faz um Busca de uma compra especifica com seus produtos
    public function show($id)
    {
        $compra = $this->compraService->getComprasComProdutos($id);
        return response()->json($compra);
    }

    // Retornar todos os produtos de uma compra específica
    public function getProducts($id)
    {
        $produtos = $this->compraService->getProdutosByComprasId($id);
        return response()->json($produtos);
    }

    // Calcular o total de uma compra
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
