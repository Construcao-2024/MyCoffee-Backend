<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;
use App\Models\Produto;


class ProdutoService{

    public function index(){
        return Produto::all();
    }

    public function criarProduto(array $data){

        $produto = Produto::create([
            'nome' => $data['nome'],
            'marca' => $data['marca'],
            'preco' => $data['preco'],
            'codigoBarras' => $data['codigoBarras'],
            'descricao' => $data['descricao'],
            'quantidade' => $data['quantidade'],
            'imagens' => $data['imagens'],
            'desconto' => $data['desconto'],
            'isDeleted' => $data['isDeleted'],
            'idCategoria' => $data['idCategoria']
            
        ]

        );

        return $produto;



    }

    public function pesquisarPorId($id){
        return Produto::find($id);
    }


    public function deletarProduto($id){
        $produto = Produto::find($id);
        
        if ($produto) {
            $produto->delete();
            return true;
        }
        
        return false;

    }

    public function atualizarProduto($id, array $data){
        $produto = Produto::find($id);
        
        if ($produto) {
            $produto->update($data);
            return $produto;
        }
        
        return null;
    }

    public function pesquisarPorIdCategoria($idCategoria){
        return Produto::where('idCategoria', $idCategoria)->get();
    }


}


