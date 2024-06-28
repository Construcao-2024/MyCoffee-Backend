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

    
    public function index()
    {
        return $this->cargoService->index();
    }

    
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

    

    public function show(string $id)
    {
        $cargo = $this->cargoService->pesquisarPorId($id);
        
        if (!$cargo) {
            return response()->json(['error' => 'cargo não encontrado'], 404);
        }
        
        return response()->json($cargo, 200);
    }

   

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


    
    public function destroy(string $id)
    {
        $cargo = $this->cargoService->deletarCargo($id);
        
        if (!$cargo) {
            return response()->json(['error' => 'cargo não encontrado'], 404);
        }
        
        return response()->json(['message' => 'cargo deletado com sucesso'], 200);
    
    }


}
