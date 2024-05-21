<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Services\FuncionarioService;


class FuncionarioController extends Controller
{
    protected $funcionarioService;

    public function __construct(FuncionarioService $funcionarioService)
    {
        $this->funcionarioService = $funcionarioService;
    }

    public function index()
    {
        return $this->funcionarioService->index();
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomeCompleto' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'cpf' => 'required',
            'fotoDePerfil'=> 'nullable',
            'cargo_id'=>'required',
            'isDeleted'=> 'required',

        ]);

        if($validator->fails()){
            Log::error('Falha:', $validator->errors()->all());
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $funcionario = $this->funcionarioService->criarFuncionario($request->all());
        
    
        return response()->json($funcionario, 201);

    }

    public function show(string $id)
    {
        $funcionario = $this->funcionarioService->pesquisarPorId($id);
        
        if (!$funcionario) {
            return response()->json(['error' => 'funcionario não encontrado'], 404);
        }
        
        return response()->json($funcionario, 200);
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nomeCompleto' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'cpf' => 'required',
            'fotoDePerfil'=> 'nullable',
            'cargo_id'=>'required',
            'isDeleted'=> 'required',

        ]); 

        if ($validator->fails()) {
            Log::error('Falha na validação: ' . implode(', ', $validator->errors()->all()));
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $funcionario = $this->funcionarioService->atualizarFuncionario($id, $request->all());
    
        if (!$funcionario) {
            return response()->json(['error' => 'funcionario não encontrada'], 404);
        }
        
        return response()->json($funcionario, 200);
    }

    public function destroy(string $id)
    {
        $funcionario = $this->funcionarioService->deletarFuncionario($id);
        
        if (!$funcionario) {
            return response()->json(['error' => 'funcionario não encontrada'], 404);
        }
        
        return response()->json(['message' => 'funcionario deletado com sucesso'], 200);
    
    }

    
}
