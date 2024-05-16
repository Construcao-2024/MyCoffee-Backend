<?php

namespace App\Services;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\ModelNotFoundException;



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

    public function pesquisarPorId($id){
        try {
            return Categoria::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            // Trate aqui o caso em que a categoria não é encontrada
            return null;
        }

    }


    public function deletarCategoria($id){
        $categoria = Categoria::find($id);
        if ($categoria) {
            $categoria->delete();
            return true;
        }
        return false;

    }

    public function atualizarCategoria($id, array $data){
        
        $categoria = Categoria::find($id);
        if ($categoria) {
            $categoria->update([
                'nome' => $data['nome'],
                'isDeleted' => $data['isDeleted'],
            ]);
            return true;
        }
        return false;
    }

}