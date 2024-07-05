<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Services\ProdutoService;
use Illuminate\Support\Facades\Validator;

class ProdutoController extends Controller
{
    protected $produtoService;

    public function __construct(ProdutoService $produtoService)
    {
        $this->produtoService = $produtoService;
    }

    /**
     * @OA\Get(
     *     path="/api/produtos",
     *     summary="Get list of products",
     *     tags={"Produtos"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Produto"))
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    
    public function index()
    {
        return $this->produtoService->index();
    }
    
    /**
     * @OA\Post(
     *     path="/api/produtos",
     *     summary="Create a new product",
     *     tags={"Produtos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Produto")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Product created successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     )
     * ) 
     */

    public function create(Request $request)
    {
        // commit atual
        $validator = Validator::make($request->all(), [
            'idCategoria' => 'required',
            'nome' => 'required',
            'marca' => 'required',
            'preco' => 'required',
            'codigoBarras' => 'required',
            'descricao' => 'required',
            'quantidade' => 'required',
            'imagens' => 'required|string|max:255',
            'desconto' => 'required',
            'isDeleted' => 'required'

        ]);

        if($validator->fails()){
            Log::error('Falha na validação:', $validator->errors()->all());
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $cliente = $this->produtoService->criarProduto($request->all());
        
    
        return response()->json($cliente, 201);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
    

    /**
     * @OA\Get(
     *     path="/api/produtos/{id}",
     *     summary="Get product by ID",
     *     tags={"Produtos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Produto")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     )
     * )
     */

    public function show(string $id)
    {
        $produto = $this->produtoService->pesquisarPorId($id);
        
        if ($produto) {
            return response()->json($produto);
        }
        
        return response()->json(['message' => 'Produto não encontrado'], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * @OA\Put(
     *     path="/api/produtos/{id}",
     *     summary="Update a product",
     *     tags={"Produtos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Produto")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Produto")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     )
     * )
     */
    
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $produto = $this->produtoService->atualizarProduto($id, $data);
        
        if ($produto) {
            return response()->json($produto);
        }
        
        return response()->json(['message' => 'Produto não encontrado'], 404);
    }

    /**
     * @OA\Delete(
     *     path="/api/produtos/{id}",
     *     summary="Delete a product",
     *     tags={"Produtos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     )
     * )
     */

    public function destroy(string $id)
    {
        $success = $this->produtoService->deletarProduto($id);
        
        if ($success) {
            return response()->json(['message' => 'Produto deletado com sucesso']);
        }
        
        return response()->json(['message' => 'Produto não encontrado'], 404);
    }


    /**
     * @OA\Get(
     *     path="/api/produtos/categoria/{idCategoria}",
     *     summary="Get products by category",
     *     tags={"Produtos"},
     *     @OA\Parameter(
     *         name="idCategoria",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Produto"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No products found for this category"
     *     )
     * )
     */

    public function produtosPorCategoria($idCategoria)
{
        $produtos = $this->produtoService->pesquisarPorIdCategoria($idCategoria);
    
        if (count($produtos) > 0) {
            return response()->json($produtos);
        }
    
        return response()->json(['message' => 'Nenhum produto encontrado para essa categoria'], 404);
}

    
}
