<?php

namespace App\Services;
use App\Models\Plano;

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
            'descontoAnual' => $data['descontoAnual'],
            'descontoMensal' => $data['descontoMensal'],
            'preco' => $data['preco'],
            'descricao' => $data['descricao'],
            'frete' => $data['frete'],
            'qntCafe' => $data['qntCafe'],

            // 
        ]);

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