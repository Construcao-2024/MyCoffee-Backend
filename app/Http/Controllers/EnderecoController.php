<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    /**
     * Busca um endereço pelo ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $endereco = Endereco::findOrFail($id);
            return response()->json($endereco, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Endereço não encontrado'], 404);
        }
    }
}