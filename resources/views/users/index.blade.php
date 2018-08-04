@extends('layout')

@section('title', 'Usuarios')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-3">
        <h1 class="pb-1">{{ $title }}</h1>
        <p>
            <a href="{{ route('users.create') }}" class="btn btn-primary">Nuevo usuario</a>
        </p>
    </div>

    @if ($users->isNotEmpty())
    <div class="row row-filters">
        <div class="col-md-6">
            <form class="form-inline form-search">
                <div class="input-group">
                    <input type="search" class="form-control form-control-sm" placeholder="Buscar...">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary btn-sm"><span class="oi oi-magnifying-glass"></span></button>
                    </div>
                </div>
                &nbsp;
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Rol
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Todos</a>
                        <a class="dropdown-item" href="#">Usuario</a>
                        <a class="dropdown-item" href="#">Admin</a>
                    </div>
                </div>
                &nbsp;
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Estado
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Todos</a>
                        <a class="dropdown-item" href="#">Activo</a>
                        <a class="dropdown-item" href="#">Inactivo</a>
                    </div>
                </div>
            </form>
        </div>
            
        <div class="col-md-6 text-right">
            <form class="form-inline form-dates">
                <label for="date_start" class="form-label-sm">Fecha</label>&nbsp;
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="date_start" id="date_start" placeholder="Desde">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary btn-sm"><span class="oi oi-calendar"></span></button>
                    </div>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="date_start" id="date_start" placeholder="Hasta">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary btn-sm"><span class="oi oi-calendar"></span></button>
                    </div>
                </div>
            </form>            
        </div>
    </div>

    <div class="table-responsive-lg">
        <table class="table table-striped table-sm">
            <thead class="thead-dark">
            <tr>
                <th scope="col"># <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
                <th scope="col" class="sort-asc">Nombre <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
                <th scope="col">Correo <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
                <th scope="col" class="th-actions">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <th scope="row">{{ $user->name }}</th>
                <td>{{ $user->email }}</td>
                <td class="text-right">
                    @if ($user->trashed())
                        <form action="{{ route('users.destroy', $user) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link"><span class="oi oi-circle-x"></span></button>
                        </form>
                    @else
                        <form action="{{ route('users.trash', $user) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <a href="{{ route('users.show', $user) }}" class="btn btn-outline-secondary btn-sm"><span class="oi oi-eye"></span></a>
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-secondary btn-sm"><span class="oi oi-pencil"></span></a>
                            <button type="submit" class="btn btn-outline-danger btn-sm"><span class="oi oi-trash"></span></button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @else
        <p>No hay usuarios registrados.</p>
    @endif
@endsection

@section('sidebar')
    @parent
@endsection