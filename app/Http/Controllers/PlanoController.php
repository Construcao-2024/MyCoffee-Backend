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

    /**
     * @OA\Get(
     *     path="/api/planos",
     *     summary="Get list of planos",
     *     tags={"Planos"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(
     *             @OA\Property(property="nome", type="string"),
     *             @OA\Property(property="desconto", type="string"),
     *             @OA\Property(property="ativo", type="boolean"),
     *             @OA\Property(property="precoAnual", type="string"),
     *             @OA\Property(property="precoMensal", type="string"),
     *             @OA\Property(property="preco", type="string"),
     *             @OA\Property(property="descricao", type="string"),
     *             @OA\Property(property="frete", type="string"),
     *             @OA\Property(property="qntCafe", type="integer")
     *         ))
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */

    public function index()
    {
        return $this->planoService->index();
    }

    /**
     * @OA\Post(
     *     path="/api/planos",
     *     summary="Create a new plano",
     *     tags={"Planos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nome", type="string"),
     *             @OA\Property(property="desconto", type="string"),
     *             @OA\Property(property="ativo", type="boolean"),
     *             @OA\Property(property="precoAnual", type="string"),
     *             @OA\Property(property="PrecoMensal", type="string"),
     *             @OA\Property(property="preco", type="string"),
     *             @OA\Property(property="descricao", type="string"),
     *             @OA\Property(property="frete", type="string"),
     *             @OA\Property(property="qntCafe", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Plano created successfully"
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
            'nome' => 'required',
            'desconto' => 'required',
            'ativo' => 'required',
            'precoAnual' => 'required',
            'precoMensal' => 'required',
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


    /**
     * @OA\Get(
     *     path="/api/planos/{id}",
     *     summary="Get plano by ID",
     *     tags={"Planos"},
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
     *             @OA\Property(property="nome", type="string"),
     *             @OA\Property(property="desconto", type="string"),
     *             @OA\Property(property="ativo", type="boolean"),
     *             @OA\Property(property="precoAnual", type="string"),
     *             @OA\Property(property="precoMensal", type="string"),
     *             @OA\Property(property="preco", type="string"),
     *             @OA\Property(property="descricao", type="string"),
     *             @OA\Property(property="frete", type="string"),
     *             @OA\Property(property="qntCafe", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Plano not found"
     *     )
     * )
     */

    public function show(string $id)
    {
        $plano = $this->planoService->pesquisarPorId($id);
        
        if (!$plano) {
            return response()->json(['error' => 'Categoria não encontrada'], 404);
        }
        
        return response()->json($plano, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/planos/{id}",
     *     summary="Update a plano",
     *     tags={"Planos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nome", type="string"),
     *             @OA\Property(property="desconto", type="string"),
     *             @OA\Property(property="ativo", type="boolean"),
     *             @OA\Property(property="precoAnual", type="string"),
     *             @OA\Property(property="precoMensal", type="string"),
     *             @OA\Property(property="preco", type="string"),
     *             @OA\Property(property="descricao", type="string"),
     *             @OA\Property(property="frete", type="string"),
     *             @OA\Property(property="qntCafe", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Plano updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="nome", type="string"),
     *             @OA\Property(property="desconto", type="string"),
     *             @OA\Property(property="ativo", type="boolean"),
     *             @OA\Property(property="precoAnual", type="string"),
     *             @OA\Property(property="precoMensal", type="string"),
     *             @OA\Property(property="preco", type="string"),
     *             @OA\Property(property="descricao", type="string"),
     *             @OA\Property(property="frete", type="string"),
     *             @OA\Property(property="qntCafe", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Plano not found"
     *     )
     * )
     */

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'desconto' => 'required',
            'ativo' => 'required',
            'precoAnual' => 'required',
            'precoMensal' => 'required',
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

    /**
     * @OA\Delete(
     *     path="/api/planos/{id}",
     *     summary="Delete a plano",
     *     tags={"Planos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Plano deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Plano not found"
     *     )
     * )
     */

    public function destroy(string $id)
    {
        $plano = $this->planoService->deletarPlano($id);
        
        if (!$plano) {
            return response()->json(['error' => 'plano não encontrada'], 404);
        }
        
        return response()->json(['message' => 'plano deletado com sucesso'], 200);
    
    }


}
