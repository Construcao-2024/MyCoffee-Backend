<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;
use App\Models\Produto;
use Illuminate\Support\Facades\Storage;



class ProdutoService{

    public function index(){
        return Produto::all();
    }

    public function criarProduto(array $data)
    {
        //  estamos recebendo apenas o caminho.
        $produto = Produto::create([
            'idCategoria' => $data['idCategoria'],
            'nome' => $data['nome'],
            'marca' => $data['marca'],
            'preco' => $data['preco'],
            'codigoBarras' => $data['codigoBarras'],
            'descricao' => $data['descricao'],
            'quantidade' => $data['quantidade'],
            'imagem' => $data['imagem'], // Armazena o caminho da imagem
            'desconto' => $data['desconto'],
            'isDeleted' => $data['isDeleted'],
        ]);

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

    public function atualizarProduto($id, array $data)
    {
        $produto = Produto::find($id);
        
        if ($produto) {
            if (isset($data['imagem'])) {
                // Remove a imagem antiga se existir
                if ($produto->imagem) {
                    Storage::disk('public')->delete($produto->imagem);
                }

                // Armazena a nova imagem
                $imagemPath = $data['imagem']->store('produtos', 'public');
                $data['imagem'] = $imagemPath;
            }
            
            $produto->update($data);
            return $produto;
        }

        return null;
    }

    public function pesquisarPorIdCategoria($idCategoria){
        return Produto::where('idCategoria', $idCategoria)->get();
    }


}


