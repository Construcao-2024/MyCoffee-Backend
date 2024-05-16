<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\ClienteService;
use App\Models\User;
use App\Models\Cliente;

class ClienteController extends Controller
{
    protected $clienteService;

    public function __construct(ClienteService $clienteService)
    {
        $this->clienteService = $clienteService;
    }

    public function index()
    {
        return $this->clienteService->index();
    }

    public function store(Request $request)
    {


        Log::info('Recebendo solicitação para criar cliente:', $request->all());

        $validator = Validator::make($request->all(), [
            'nomeCompleto' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'cpf' => 'required',
            'telefone' => 'required',
            'cep' => 'required',
            'endereco' => 'required',
            'numero' => 'required',
            'bairro' => 'required',

        ]);

        if ($validator->fails()) {
            Log::error('Falha na validação:', $validator->errors()->all());
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        
        $cliente = $this->clienteService->criarCliente($request->all());
        
    
        return response()->json($cliente, 201);
    }

    public function show($id)
    {
        try {
            $cliente = $this->clienteService->show($id);
            return response()->json($cliente);
        } catch (\Exception $e) {
            Log::error('Cliente não encontrado:', ['id' => $id, 'message' => $e->getMessage()]);
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        Log::info('Recebendo solicitação para atualizar cliente:', $request->all());

        $validator = Validator::make($request->all(), [
            'nomeCompleto' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'cpf' => 'required',
            'telefone' => 'required',
            'cep' => 'required',
            'endereco' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
        ]);

        if ($validator->fails()) {
            Log::error('Falha na validação:', $validator->errors()->all());
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            $cliente = $this->clienteService->update($request->all(), $id);
            return response()->json($cliente);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar cliente:', ['id' => $id, 'message' => $e->getMessage()]);
            return response()->json(['message' => 'Erro ao atualizar cliente'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $this->clienteService->destroy($id);
            return response()->json(['message' => 'Cliente deletado com sucesso']);
        } catch (\Exception $e) {
            Log::error('Erro ao deletar cliente:', ['id' => $id, 'message' => $e->getMessage()]);
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }
    }
}
