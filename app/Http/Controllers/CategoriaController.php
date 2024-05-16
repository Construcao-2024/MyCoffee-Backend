<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Services\CategoriaService;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    protected $categoriaService;

    public function __construct(CategoriaService $categoriaService)
    {
        $this->categoriaService = $categoriaService;
    }
    
    public function index()
    {
        return $this->categoriaService->index();
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'isDeleted' => 'required',
        ]);

        if($validator->fails()){
            Log::error('Falha na validação:', $validator->errors()->all());
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $cliente = $this->categoriaService->criarCategoria($request->all());
        
    
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
        $categoria = $this->categoriaService->pesquisarPorId($id);
        
        if (!$categoria) {
            return response()->json(['error' => 'Categoria não encontrada'], 404);
        }
        
        return response()->json($categoria, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'isDeleted' => 'required',
        ]);

        if ($validator->fails()) {
            Log::error('Falha na validação: ' . implode(', ', $validator->errors()->all()));
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $categoria = $this->categoriaService->atualizarCategoria($id, $request->all());
    
        if (!$categoria) {
            return response()->json(['error' => 'Categoria não encontrada'], 404);
        }
        
        return response()->json($categoria, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoria = $this->categoriaService->deletarCategoria($id);
        
        if (!$categoria) {
            return response()->json(['error' => 'Categoria não encontrada'], 404);
        }
        
        return response()->json(['message' => 'Categoria deletada com sucesso'], 200);
    
    }


}
