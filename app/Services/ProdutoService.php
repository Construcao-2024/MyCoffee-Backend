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



    }

    public function pesquisarPorId(){

    }


    public function deletarProduto(){

    }

    public function atualizarProduto(){
        
    }


}


