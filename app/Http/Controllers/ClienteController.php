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

    /**
     * @OA\Get(
     *     path="/api/clientes",
     *     summary="Get a list of all clients",
     *     tags={"Clientes"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="nomeCompleto", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="cpf", type="string"),
     *             @OA\Property(property="telefone", type="string"),
     *             @OA\Property(property="cep", type="string"),
     *             @OA\Property(property="endereco", type="string"),
     *             @OA\Property(property="numero", type="string"),
     *             @OA\Property(property="bairro", type="string"),
     *             @OA\Property(property="fotoDePerfil", type="string", nullable=true)
     *         ))
     *     )
     * )
     */

    public function index()
    {
        return $this->clienteService->index();
    }

    /**
     * @OA\Post(
     *     path="/api/clientes",
     *     summary="Create a new client",
     *     tags={"Clientes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nomeCompleto", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="cpf", type="string"),
     *             @OA\Property(property="telefone", type="string"),
     *             @OA\Property(property="cep", type="string"),
     *             @OA\Property(property="endereco", type="string"),
     *             @OA\Property(property="numero", type="string"),
     *             @OA\Property(property="bairro", type="string"),
     *             @OA\Property(property="fotoDePerfil", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Client created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="nomeCompleto", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="cpf", type="string"),
     *             @OA\Property(property="telefone", type="string"),
     *             @OA\Property(property="cep", type="string"),
     *             @OA\Property(property="endereco", type="string"),
     *             @OA\Property(property="numero", type="string"),
     *             @OA\Property(property="bairro", type="string"),
     *             @OA\Property(property="fotoDePerfil", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     )
     * )
     */

    public function store(Request $request)
    {


        Log::info('Recebendo solicitação para criar cliente:', $request->all());

        $validator = Validator::make($request->all(), [
            'nomeCompleto' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'cpf' => 'required',
            'fotoDePerfil'=> 'nullable',
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

    /**
     * @OA\Get(
     *     path="/api/clientes/{id}",
     *     summary="Get a specific client by ID",
     *     tags={"Clientes"},
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
     *             @OA\Property(property="nomeCompleto", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="cpf", type="string"),
     *             @OA\Property(property="telefone", type="string"),
     *             @OA\Property(property="cep", type="string"),
     *             @OA\Property(property="endereco", type="string"),
     *             @OA\Property(property="numero", type="string"),
     *             @OA\Property(property="bairro", type="string"),
     *             @OA\Property(property="fotoDePerfil", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client not found"
     *     )
     * )
     */

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

    /**
     * @OA\Put(
     *     path="/api/clientes/{id}",
     *     summary="Update a specific client by ID",
     *     tags={"Clientes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nomeCompleto", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="cpf", type="string"),
     *             @OA\Property(property="telefone", type="string"),
     *             @OA\Property(property="cep", type="string"),
     *             @OA\Property(property="endereco", type="string"),
     *             @OA\Property(property="numero", type="string"),
     *             @OA\Property(property="bairro", type="string"),
     *             @OA\Property(property="fotoDePerfil", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Client updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="nomeCompleto", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="cpf", type="string"),
     *             @OA\Property(property="telefone", type="string"),
     *             @OA\Property(property="cep", type="string"),
     *             @OA\Property(property="endereco", type="string"),
     *             @OA\Property(property="numero", type="string"),
     *             @OA\Property(property="bairro", type="string"),
     *             @OA\Property(property="fotoDePerfil", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client not found"
     *     )
     * )
     */

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

    /**
     * @OA\Delete(
     *     path="/api/clientes/{id}",
     *     summary="Delete a specific client by ID",
     *     tags={"Clientes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Client deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client not found"
     *     )
     * )
     */

    public function destroy($id)
    {
        Log::info('Requisição de deleção recebida', ['id' => $id]);

        try {
            $this->clienteService->destroy($id);
            Log::info('Cliente deletado com sucesso', ['id' => $id]);
    
            return response()->json(['message' => 'Cliente deletado com sucesso']);
        } catch (\Exception $e) {
            Log::error('Erro ao deletar cliente:', ['id' => $id, 'message' => $e->getMessage()]);
    
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }
    }
}
