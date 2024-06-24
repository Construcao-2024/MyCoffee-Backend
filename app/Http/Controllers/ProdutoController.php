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
    
    public function index()
    {
        return $this->produtoService->index();
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idCategoria' => 'required',
            'nome' => 'required',
            'marca' => 'required',
            'preco' => 'required',
            'codigoBarras' => 'required',
            'descricao' => 'required',
            'quantidade' => 'required',
            'imagens' => 'required',
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
     * Display the specified resource.
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
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $success = $this->produtoService->deletarProduto($id);
        
        if ($success) {
            return response()->json(['message' => 'Produto deletado com sucesso']);
        }
        
        return response()->json(['message' => 'Produto não encontrado'], 404);
    }

    public function produtosPorCategoria($idCategoria)
{
        $produtos = $this->produtoService->pesquisarPorIdCategoria($idCategoria);
    
        if (count($produtos) > 0) {
            return response()->json($produtos);
        }
    
        return response()->json(['message' => 'Nenhum produto encontrado para essa categoria'], 404);
}

    
}
