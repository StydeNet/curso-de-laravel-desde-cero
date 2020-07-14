@extends('livewire-layout')

@section('title', 'Usuarios')

@section('content')
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

    @if ($view === 'index')
        @livewire('user-filter')
    @endif

    @livewire('users-list', compact([
        'view',
    ]))
@endsection

@push('scripts')
    <script>
        var loadCalendars = function () {
            ['from', 'to'].forEach(function (field) {
                $('#'+field).datepicker({
                    uiLibrary: 'bootstrap4',
                    format: 'dd/mm/yyyy'
                }).on('change', function () {
                    var usersTableId = $('#users-table').attr('wire:id');
                    var usersTable = window.livewire.find(usersTableId);

                    if (usersTable.get(field) !== $(this).val()) {
                        window.livewire.emit('refreshUserList', field, $(this).val());
                    }
                });
            });
        };

        loadCalendars();
        $('#btn-filter').hide();

        document.addEventListener('livewire:load', function (event) {
            window.livewire.hook('afterDomUpdate', loadCalendars);
        });
    </script>
@endpush
