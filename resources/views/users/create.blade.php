<x-app-layout>
    <x-slot name="title">@lang('New User')</x-slot>

    <x-card>
        @slot('header', trans('New User'))

        <x-validation-errors />

        <form method="POST" action="{{ url('/users') }}">
            @include('users._fields')

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">{{ __('Create User') }}</button>
                <a href="{{ route('users.index') }}" class="btn btn-link">{{ __('Go Back') }}</a>
            </div>
        </form>
    </x-card>
</x-app-layout>
