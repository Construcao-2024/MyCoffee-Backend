<?php

namespace App\Services;

use App\Models\Cargo;

class CargoService{

    public function index(){
        return Cargo::all();
    }


    public function criarCargo(array $data){

        $cargo = Cargo::create([
            'nome' => $data['nome'],
            'isDeleted' => $data['isDeleted']
        ]);

        return $cargo;

    }

    public function pesquisarPorId($id){
        return Cargo::find($id);
    }


    public function deletarCargo($id){
        $cargo = Cargo::find($id);
        
        if ($cargo) {
            $cargo->delete();
            return true;
        }
        
        return false;

    }

    public function atualizarCargo($id, array $data){
        $cargo = Cargo::find($id);
        
        if ($cargo) {
            $cargo->update($data);
            return $cargo;
        }
        
        return null;
    }





}