<?php

namespace App\Services;
use App\Models\Plano;
use App\Models\Cliente;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PlanoService{

    public function index(){
        return Plano::all();
    }

    public function criarPlano(array $data)
    {
        $plano = Plano::create([
            'nome' => $data['nome'],
            'desconto' => $data['desconto'],
            'ativo' => $data['ativo'],
            'precoAnual' => $data['precoAnual'],
            'precoMensal' => $data['precoMensal'],
            'preco' => $data['preco'],
            'descricao' => $data['descricao'],
            'frete' => $data['frete'],
            'qntCafe' => $data['qntCafe'],

            // 
        ]);

        return $plano;

    }

    public function assinarPlano($planoId, $clienteId)
    {
        $plano = Plano::find($planoId);
        $cliente = Cliente::find($clienteId);

        if (!$plano || !$cliente) {
            return ['success' => false, 'message' => 'Plano ou cliente não encontrado'];
        }

        // assina plano
        $cliente->plano()->associate($plano);
        $cliente->save();

        Log::info("Cliente ID {$clienteId} assinou o plano ID {$planoId}");

        return ['success' => true];
    }

    public function pesquisarPorId($id){
        return Plano::find($id);
    }


    public function deletarPlano($id){
        $plano = Plano::find($id);
        
        if ($plano) {
            $plano->delete();
            return true;
        }
        
        return false;

    }

    public function atualizarPlano($id, array $data){
        $plano = Plano::find($id);
        
        if ($plano) {
            $plano->update($data);
            return $plano;
        }
        
        return null;
    }



}