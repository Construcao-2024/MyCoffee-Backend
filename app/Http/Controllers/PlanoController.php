<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PlanoService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PlanoController extends Controller
{
    protected $planoService;


    public function __construct(PlanoService $planoService)
    {
        $this->planoService = $planoService;
    }


    public function index()
    {
        return $this->planoService->index();
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'desconto' => 'required',
            'ativo' => 'required',
            'descontoAnual' => 'required',
            'descontoMensal' => 'required',
            'preco' => 'required',
            'descricao' => 'required',
            'frete' => 'required',
            'qntCafe' => 'required',
        ]);

        if($validator->fails()){
            Log::error('Falha:', $validator->errors()->all());
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $cliente = $this->planoService->criarPlano($request->all());
        
    
        return response()->json($cliente, 201);

    }

    public function show(string $id)
    {
        $plano = $this->planoService->pesquisarPorId($id);
        
        if (!$plano) {
            return response()->json(['error' => 'Categoria não encontrada'], 404);
        }
        
        return response()->json($plano, 200);
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'desconto' => 'required',
            'ativo' => 'required',
            'descontoAnual' => 'required',
            'descontoMensal' => 'required',
            'preco' => 'required',
            'descricao' => 'required',
            'frete' => 'required',
            'qntCafe' => 'required',
        ]);

        if ($validator->fails()) {
            Log::error('Falha na validação: ' . implode(', ', $validator->errors()->all()));
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $categoria = $this->planoService->atualizarPlano($id, $request->all());
    
        if (!$categoria) {
            return response()->json(['error' => 'Categoria não encontrada'], 404);
        }
        
        return response()->json($categoria, 200);
    }

    public function destroy(string $id)
    {
        $plano = $this->planoService->deletarPlano($id);
        
        if (!$plano) {
            return response()->json(['error' => 'plano não encontrada'], 404);
        }
        
        return response()->json(['message' => 'plano deletado com sucesso'], 200);
    
    }


}
