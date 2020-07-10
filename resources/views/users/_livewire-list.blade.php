<div id="users-table">
    @includeWhen($view == 'index', 'users._filters')

    @if ($users->isNotEmpty())

        <div class="table-responsive-lg">
            <table class="table table-sm">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    @foreach(['name' => 'Nombre', 'email' => 'Correo', 'date' => 'Registrado el', 'login' => 'Último login'] as $column => $title)
                        <th scope="col">
                            <a wire:click.prevent="changeOrder('{{ $sortable->order($column) }}')" href="{{ $sortable->url($column) }}" class="{{ $sortable->classes($column) }}">
                                {{ $title }} <i class="icon-sort"></i>
                            </a>
                        </th>
                    @endforeach
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
</div>
