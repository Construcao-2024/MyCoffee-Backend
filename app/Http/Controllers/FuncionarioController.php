<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Services\FuncionarioService;


/**
 * @OA\Schema(
 *     schema="Funcionario",
 *     type="object",
 *     title="Funcionario",
 *     description="Funcionario schema",
 *     @OA\Property(
 *         property="nomeCompleto",
 *         type="string",
 *         description="Nome completo do funcionário"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Email do funcionário"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         description="Senha do funcionário"
 *     ),
 *     @OA\Property(
 *         property="cpf",
 *         type="string",
 *         description="CPF do funcionário"
 *     ),
 *     @OA\Property(
 *         property="fotoDePerfil",
 *         type="string",
 *         nullable=true,
 *         description="URL da foto de perfil do funcionário"
 *     ),
 *     @OA\Property(
 *         property="cargo_id",
 *         type="integer",
 *         description="ID do cargo do funcionário"
 *     ),
 *     @OA\Property(
 *         property="isDeleted",
 *         type="boolean",
 *         description="Status de deleção do funcionário"
 *     )
 * )
 */


class FuncionarioController extends Controller
{
    protected $funcionarioService;

    public function __construct(FuncionarioService $funcionarioService)
    {
        $this->funcionarioService = $funcionarioService;
    }

    /**
     * @OA\Get(
     *     path="/api/funcionarios",
     *     summary="Get list of funcionarios",
     *     tags={"Funcionarios"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Funcionario"))
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */

    public function index()
    {
        return $this->funcionarioService->index();
    }

    /**
     * @OA\Post(
     *     path="/api/funcionarios",
     *     summary="Create a new funcionario",
     *     tags={"Funcionarios"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Funcionario")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Funcionario created successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     )
     * )
     */

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

    /**
     * @OA\Get(
     *     path="/api/funcionarios/{id}",
     *     summary="Get funcionario by ID",
     *     tags={"Funcionarios"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Funcionario")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Funcionario not found"
     *     )
     * )
     */

    public function show(string $id)
    {
        $funcionario = $this->funcionarioService->pesquisarPorId($id);
        
        if (!$funcionario) {
            return response()->json(['error' => 'funcionario não encontrado'], 404);
        }
        
        return response()->json($funcionario, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/funcionarios/{id}",
     *     summary="Update a funcionario",
     *     tags={"Funcionarios"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Funcionario")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Funcionario updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Funcionario")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Funcionario not found"
     *     )
     * )
     */


    /**
 * @OA\Get(
 *     path="/api/funcionarios/user/{user_id}",
 *     summary="Get funcionario by user ID",
 *     tags={"Funcionarios"},
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(ref="#/components/schemas/Funcionario")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Funcionario not found"
 *     )
 * )
 */
public function searchByUserId(string $user_id)
{
    $funcionario = $this->funcionarioService->searchByUserId($user_id);

    if (!$funcionario) {
        return response()->json(['error' => 'Funcionario não encontrado'], 404);
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

    /**
     * @OA\Delete(
     *     path="/api/funcionarios/{id}",
     *     summary="Delete a funcionario",
     *     tags={"Funcionarios"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Funcionario deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Funcionario not found"
     *     )
     * )
     */

    public function destroy(string $id)
    {
        $funcionario = $this->funcionarioService->deletarFuncionario($id);
        
        if (!$funcionario) {
            return response()->json(['error' => 'funcionario não encontrada'], 404);
        }
        
        return response()->json(['message' => 'funcionario deletado com sucesso'], 200);
    
    }

    
}
