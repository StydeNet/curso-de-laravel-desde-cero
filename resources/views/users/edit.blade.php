<x-app-layout>
    <x-slot name="title">@lang('Edit User')</x-slot>
    <x-card>
        @slot('header', trans('Edit User'))

        @include('shared._errors')

        <form method="POST" action="{{ url("usuarios/{$user->id}") }}">
            {{ method_field('PUT') }}

            @include('users._fields')

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">{{ __('Update User') }}</button>
                <a href="{{ route('users.index') }}" class="btn btn-link">{{ __('Go back') }}</a>
            </div>
        </form>
    </x-card>
</x-app-layout>
