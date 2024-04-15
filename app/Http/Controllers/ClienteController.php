<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
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
        $request->validate([
            'nomeCompleto' => 'required',
            'email' => 'required|email|unique:users',
            'senha' => 'required|min:6',
            'cpf' => 'required',
            'telefone' => 'required',
            'endereco' => 'required',
        ]);
    
        $cliente = $this->clienteService->criarCliente($request->all());
    
        return response()->json($cliente, 201);
    }
}
