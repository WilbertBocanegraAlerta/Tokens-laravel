<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['jwt', 'role:admin']);
    }

    public function addUser()
    {
        return 'hola 1';
    }

    public function delUserBy($UUID)
    {
        return 'hola 2';
    }

    public function updateUserBy($UUID)
    {
        return 'hola 3';
    }

    public function findUserBy($UUID)
    {
        return 'hola 4';
    }
    public function findAll()
    {
        try {
            $users = User::where('id', '!=', auth()->id())->get();
            return response()->json(["msg" => "find all sucessfully", "data" => $users]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(["error" => $th->getMessage()]);
        }
    }
}
