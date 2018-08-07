@extends('layout')

@section('title', 'Usuarios')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-3">
        <h1 class="pb-1">{{ $title }}</h1>
        <p>
            <a href="{{ route('users.create') }}" class="btn btn-dark">Nuevo usuario</a>
        </p>
    </div>

    @if ($users->isNotEmpty())
    <form method="get" action="/usuarios">
        <div class="row row-filters">
            <div class="col-12">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" checked>
                    <label class="form-check-label" for="inlineRadio1">Todos</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                    <label class="form-check-label" for="inlineRadio2">Solo activos</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                    <label class="form-check-label" for="inlineRadio3">Solo inactivos</label>
                </div>
            </div>
        </div>
        <div class="row row-filters">
            <div class="col-md-6">
                <div class="form-inline form-search">
                    <div class="input-group">
                        <input type="search" class="form-control form-control-sm" placeholder="Buscar...">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-secondary btn-sm"><span class="oi oi-magnifying-glass"></span></button>
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
                    <div class="btn-group drop-skills">
                        <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Habilidades
                        </button>
                        <div class="drop-menu skills-list">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="skill1">
                                <label class="form-check-label" for="skill1">CSS</label>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="skill2">
                                <label class="form-check-label" for="skill2">Laravel Development</label>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="skill3">
                                <label class="form-check-label" for="skill3">Front End</label>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="skill4">
                                <label class="form-check-label" for="skill4">Bases de Datos</label>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="skill5">
                                <label class="form-check-label" for="skill5">Javascript</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                
            <div class="col-md-6 text-right">
                <div class="form-inline form-dates">
                    <label for="date_start" class="form-label-sm">Fecha</label>&nbsp;
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" name="date_start" id="date_start" placeholder="Desde">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-secondary btn-sm"><span class="oi oi-calendar"></span></button>
                        </div>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" name="date_start" id="date_start" placeholder="Hasta">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-secondary btn-sm"><span class="oi oi-calendar"></span></button>
                        </div>
                    </div> 
                    &nbsp;
                    <button type="submit" class="btn btn-sm btn-primary">Filtrar</button>
                </div>            
            </div>
        </div>
    </form>

    <div class="table-responsive-lg">
        <table class="table table-sm">
            <thead class="thead-dark">
            <tr>
                <th scope="col"># <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
                <th scope="col" class="sort-desc">Nombre <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
                <th scope="col">Correo <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
                <th scope="col">Rol <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
                <th scope="col">Fechas <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
                <th scope="col" class="text-right th-actions">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
            <tr>
                <td rowspan="2">{{ $user->id }}</td>
                <th scope="row">
                    {{ $user->name }} 
                    <span class="note">Nombre de Empresa</span>
                </th>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <span class="note">Registro: {{ $user->created_at->format('d/m/Y') }}</span>
                    <span class="note">Último login: {{ $user->created_at->format('d/m/Y') }}</span>
                </td>
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
            <tr class="skills">
                <td colspan="1"><span class="note">Profesion aqui</span></td>
                <td colspan="4"><span class="note">Lorem, Ipsum dolor, Sit amet, Consectetur Adipisicing elit</span></td>
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