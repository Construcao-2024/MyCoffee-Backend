<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\User;


class ClienteService{
    
    public function index()
    {
        return Cliente::all();
    }

    public function criarCliente(array $data)
    {   
        $user = User::create([
            'nomeCompleto' => $data['nomeCompleto'],
            'email' => $data['email'],
            'senha' => bcrypt($data['senha']),
            // 
        ]);

        // criando o cliente aqui
        $cliente = Cliente::create([
            'user_id' => $user->id,
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


