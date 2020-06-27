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

    @livewire('users-table')
@endsection

@section('sidebar')
    @parent
@endsection

@push('scripts')
    <script>
        var loadCalendars = function () {
            ['#from', '#to'].forEach(function (field) {
                $(field).datepicker({
                    uiLibrary: 'bootstrap4',
                    format: 'dd/mm/yyyy'
                }).on('change', function () {
                    var usersTableId = $('#users-table').attr('wire:id');

                    window.livewire.find(usersTableId).set(field.substr(1), $(this).val());
                });
            });

            $('#filter-btn').hide();
        };

        loadCalendars();

        document.addEventListener("livewire:load", function(event) {

            window.livewire.hook('afterDomUpdate', () => {
                loadCalendars();
            });
        });
    </script>
@endpush
