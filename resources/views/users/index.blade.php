<x-app-layout>

    <x-slot name="title">Usuarios</x-slot>

    <div class="d-flex justify-content-between align-items-end mb-3">
        <h1 class="pb-1">
            {{ trans("users.title.{$view}") }}
        </h1>
        <p>
        @if ($view == 'index')
            <a href="{{ route('users.trashed') }}" class="btn btn-outline-dark">Ver papelera</a>
            <a href="{{ route('users.create') }}" class="btn btn-dark">Nuevo usuario</a>
        @else
            <a href="{{ route('users.index') }}" class="btn btn-outline-dark">Regresar al listado de usuarios</a>
        @endif
        </p>
    </div>

    @includeWhen($view == 'index', 'users._filters')

    @if ($users->isNotEmpty())

    <div class="table-responsive-lg">
        <table class="table table-sm">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col"><a href="{{ $sortable->url('name') }}" class="{{ $sortable->classes('name') }}">Nombre <i class="icon-sort"></i></a></th>
                <th scope="col"><a href="{{ $sortable->url('email') }}" class="{{ $sortable->classes('email') }}">Correo <i class="icon-sort"></i></a></th>
                <th scope="col"><a href="{{ $sortable->url('date') }}" class="{{ $sortable->classes('date') }}">Registrado el <i class="icon-sort"></i></a></th>
                <th scope="col"><a href="{{ $sortable->url('login') }}" class="{{ $sortable->classes('login') }}">Último login <i class="icon-sort"></i></a></th>
                <th scope="col" class="text-right th-actions">Acciones</th>
            </tr>
            </thead>
            <tbody>
                @each('users._row', $users, 'user')
            </tbody>
        </table>

        {{ $users->links() }}
        <p>Viendo página {{ $users->currentPage() }} de {{ $users->lastPage() }}</p>
    </div>
    @else
        <p>No hay usuarios registrados.</p>
    @endif

</x-app-layout>
