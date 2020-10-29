<x-app-layout>
    <x-slot name="title">{{ $user->name }}</x-slot>

    <div class="d-flex justify-content-between align-items-end mb-3">
        <h1 class="pb-1">{{ $user->name }}</h1>

        <p><a href="{{ route('users.index') }}" class="btn btn-outline-dark btn-sm">{{ __('Go back') }}</a></p>
    </div>

    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Details') }}
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ __('User ID') }}: {{ $user->id }}</h5>
                    <div class="card-text">
                        <p><strong>{{ __('Email') }}</strong>: {{ $user->email }}</p>
                        <p><strong>{{ __('Role') }}</strong>: {{ $user->role }}</p>
                        <p><strong>{{ __('Registered at') }}</strong>: {{ $user->created_at }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-4">
        </div>
    </div>
    <br>
</x-app-layout>
