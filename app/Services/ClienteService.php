<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;
use App\Models\Cliente;
use App\Models\User;


class ClienteService{
    
    public function index()
    {
        return Cliente::all();
    }
    

    public function criarCliente(array $data)
    {   

        Log::info('Recebendo dados para criar cliente:', $data);

        $user = User::create([
            'nomeCompleto' => $data['nomeCompleto'],
            'email' => $data['email'],
            'senha' => bcrypt($data['senha']),
            // 
        ]);

        $userId = $user->id;
        Log::info('Usuário criado com sucesso:', $user->toArray());
        Log::info('O id do user é:', ['id' => $user->id]);
        Log::info('O id do user é:', ['id' => $userId]);


        // criando o cliente aqui

        
        $cliente = Cliente::create([
            'user_id' => $userId,
            'cpf' => $data['cpf'],
            'telefone' => $data['telefone'],
            'endereco' => $data['endereco'],
        ]);
        
        
        return $cliente;
    }

    public function show($id)
    {
        return Cliente::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->update($data);
        return $cliente;
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();
    }

}


