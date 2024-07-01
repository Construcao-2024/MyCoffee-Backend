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

    /**
     * @OA\Get(
     *     path="/api/categorias",
     *     summary="Get a list of all categories",
     *     tags={"Categorias"},
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
        return $this->categoriaService->index();
    }

    /**
     * @OA\Post(
     *     path="/api/categorias",
     *     summary="Create a new category",
     *     tags={"Categorias"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nome", type="string"),
     *             @OA\Property(property="isDeleted", type="boolean")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Category created successfully",
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
     * @OA\Get(
     *     path="/api/categorias/{id}",
     *     summary="Get a specific category by ID",
     *     tags={"Categorias"},
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
     *         description="Category not found"
     *     )
     * )
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
     * @OA\Put(
     *     path="/api/categorias/{id}",
     *     summary="Update a specific category by ID",
     *     tags={"Categorias"},
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
     *         description="Category updated successfully",
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
     *         description="Category not found"
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
        
        $categoria = $this->categoriaService->atualizarCategoria($id, $request->all());
    
        if (!$categoria) {
            return response()->json(['error' => 'Categoria não encontrada'], 404);
        }
        
        return response()->json($categoria, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/categorias/{id}",
     *     summary="Delete a specific category by ID",
     *     tags={"Categorias"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found"
     *     )
     * )
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
