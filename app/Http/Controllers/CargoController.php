<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Services\CargoService;
use Illuminate\Support\Facades\Validator;


class CargoController extends Controller
{
    protected $cargoService;

    public function __construct(CargoService $cargoService)
    {
        $this->cargoService = $cargoService;
    }

    /**
     * @OA\Get(
     *     path="/api/cargos",
     *     summary="Get a list of all cargos",
     *     tags={"Cargos"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="nome", type="string"),
     *             @OA\Property(property="isDeleted", type="boolean")
     *         ))
     *     )
     * )
     */

    public function index()
    {
        return $this->cargoService->index();
    }

    /**
     * @OA\Post(
     *     path="/api/cargos",
     *     summary="Create a new cargo",
     *     tags={"Cargos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nome", type="string"),
     *             @OA\Property(property="isDeleted", type="boolean")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Cargo created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="nome", type="string"),
     *             @OA\Property(property="isDeleted", type="boolean")
     *         )
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
            'isDeleted' => 'required',
        ]);

        if($validator->fails()){
            Log::error('Falha na validação:', $validator->errors()->all());
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $cargo = $this->cargoService->criarCargo($request->all());
        
    
        return response()->json($cargo, 201);

    }

    /**
     * @OA\Get(
     *     path="/api/cargos/{id}",
     *     summary="Get a specific cargo by ID",
     *     tags={"Cargos"},
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
     *             @OA\Property(property="nome", type="string"),
     *             @OA\Property(property="isDeleted", type="boolean")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cargo not found"
     *     )
     * )
     */

    public function show(string $id)
    {
        $cargo = $this->cargoService->pesquisarPorId($id);
        
        if (!$cargo) {
            return response()->json(['error' => 'cargo não encontrado'], 404);
        }
        
        return response()->json($cargo, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/cargos/{id}",
     *     summary="Update a specific cargo by ID",
     *     tags={"Cargos"},
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
     *             @OA\Property(property="isDeleted", type="boolean")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cargo updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="nome", type="string"),
     *             @OA\Property(property="isDeleted", type="boolean")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cargo not found"
     *     )
     * )
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
        
        $cargo = $this->cargoService->atualizarCargo($id, $request->all());
    
        if (!$cargo) {
            return response()->json(['error' => 'cargo não encontrado'], 404);
        }
        
        return response()->json($cargo, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/cargos/{id}",
     *     summary="Delete a specific cargo by ID",
     *     tags={"Cargos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cargo deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cargo not found"
     *     )
     * )
     */
    
    public function destroy(string $id)
    {
        $cargo = $this->cargoService->deletarCargo($id);
        
        if (!$cargo) {
            return response()->json(['error' => 'cargo não encontrado'], 404);
        }
        
        return response()->json(['message' => 'cargo deletado com sucesso'], 200);
    
    }


}
