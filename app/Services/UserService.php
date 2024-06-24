<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;
use App\Models\Endereco;
use App\Models\User;


class UserService{
    
    public function index()
    {
        return User::all();
    }
    

    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function destroy($id){
        
        $user = User::findOrFail($id);
        $user = User::findOrFail($user->user_id);
        $user->delete();
        $user->delete();

    }


}


