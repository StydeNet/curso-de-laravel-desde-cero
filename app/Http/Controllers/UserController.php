<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = [
            'Joel',
            'Ellie',
            'Tess',
            'Tommy',
            'Bill',
            '<script>alert("Clicker")</script>'
        ];

        $title = 'Listado de usuarios';

        return view('users', compact('title', 'users'));
    }

    public function show($id)
    {
        return "Mostrando detalle del usuario: {$id}";
    }

    public function create()
    {
        return 'Crear nuevo usuario';
    }
}
