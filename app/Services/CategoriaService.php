<?php

namespace App\Services;
use App\Models\Categoria;


class CategoriaService{

    public function index(){
        return Categoria::all();
    }


    public function criarCategoria(array $data){

        $produto = Categoria::create([
            'nome' => $data['nome'],
            'isDeleted' => $data['isDeleted'],
            
            
        ]

        );



    }

    public function pesquisarPorId(){

    }


    public function deletarCategoria(){

    }

    public function atualizarCategoria(){
        
    }

}