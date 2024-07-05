<?php

namespace App\Services;

use App\Models\Funcionario;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class FuncionarioService{

    public function index(){
        return Funcionario::all();
    }


    public function criarFuncionario(array $data){

        Log::info('Recebendo dados para criar funcionário:', $data);

        $user = User::create([
            'nomeCompleto' => $data['nomeCompleto'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'fotoPerfil'=>$data['fotoPerfil'] ?? null,
            'permission'=> 'funcionario',
            // 
        ]);

        $userId = $user->id;
        Log::info('Usuário criado com sucesso:', $user->toArray());
        Log::info('O id do user é:', ['id' => $user->id]);
        Log::info('O id do user é:', ['id' => $userId]);



        // criando o funcionario aqui


        Log::info('O ID do usuário é:', ['id' => $userId]);

        $funcionario = Funcionario::create([
            'user_id' => $userId,
            'cpf' => $data['cpf'],
            'cargo_id' => $data['cargo_id'],
            'isDeleted'=> $data['isDeleted']

        ]);
        
        
        return $funcionario;

    }

    public function pesquisarPorId($id){
        return Funcionario::find($id);
    }


    public function deletarFuncionario($id){
        $funcionario = Funcionario::find($id);
        
        if ($funcionario) {
            $funcionario->delete();
            return true;
        }
        
        return false;

    }

    public function searchByUserId(string $user_id)
{
    return Funcionario::where('user_id', $user_id)->first();
}

    public function atualizarFuncionario($id, array $data){
        $funcionario = Funcionario::find($id);
        
        if ($funcionario) {
            $funcionario->update($data);
            return $funcionario;
        }
        
        return null;
    }





}