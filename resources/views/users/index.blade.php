<x-app-layout>

    <x-slot name="title">{{ trans("users.title.{$view}") }}</x-slot>

    <div class="d-flex justify-content-between align-items-end mb-3">
        <h1 class="pb-1">
            {{ trans("users.title.{$view}") }}
        </h1>
        <p>
        @if ($view == 'index')
            <a href="{{ route('users.trashed') }}" class="btn btn-outline-dark">{{ __('View Trash') }}</a>
            <a href="{{ route('users.create') }}" class="btn btn-dark">{{ __('New User') }}</a>
        @else
            <a href="{{ route('users.index') }}" class="btn btn-outline-dark">{{ __('Go back') }}</a>
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
                <th scope="col"><a href="{{ $sortable->url('name') }}" class="{{ $sortable->classes('name') }}">{{ __('Name') }} <i class="icon-sort"></i></a></th>
                <th scope="col"><a href="{{ $sortable->url('email') }}" class="{{ $sortable->classes('email') }}">{{ __('Email') }} <i class="icon-sort"></i></a></th>
                <th scope="col"><a href="{{ $sortable->url('date') }}" class="{{ $sortable->classes('date') }}">{{ __('Registered at') }} <i class="icon-sort"></i></a></th>
                <th scope="col"><a href="{{ $sortable->url('login') }}" class="{{ $sortable->classes('login') }}">{{ __('Last login') }} <i class="icon-sort"></i></a></th>
                <th scope="col" class="text-right th-actions">{{ __('Actions') }}</th>
            </tr>
            </thead>
            <tbody>
                @each('users._row', $users, 'user')
            </tbody>
        </table>

        {{ $users->links() }}
        <p>{{ __('Viewing page') }} {{ $users->currentPage() }} {{ __('of') }} {{ $users->lastPage() }}</p>
    </div>
    @else
        <p>{{ __('There are no records') }}.</p>
    @endif

</x-app-layout>
