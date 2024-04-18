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
            'senha' => 'required|min:6',
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
}
