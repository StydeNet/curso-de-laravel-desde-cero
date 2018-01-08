@extends('layout')

@section('title', "Crear usuario")

@section('content')
    <h1>Crear usuario</h1>

    <form method="POST" action="{{ url('usuarios') }}">
        {{ csrf_field() }}

        <label for="name">Nombre:</label>
        <input type="text" name="name" id="name" placeholder="Pedro Perez">
        <br>
        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" id="email" placeholder="pedro@example.com">
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" placeholder="Mayor a 6 caracteres">
        <br>
        <button type="submit">Crear usuario</button>
    </form>

    <p>
        <a href="{{ route('users.index') }}">Regresar al listado de usuarios</a>
    </p>
@endsection