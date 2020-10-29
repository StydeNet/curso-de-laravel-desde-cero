<x-app-layout>

    <x-slot name="title">{{ __('Professions') }}</x-slot>

    <div class="d-flex justify-content-between align-items-end mb-3">
        <h1 class="pb-1">{{ __('Professions') }}}</h1>
    </div>

    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">{{ __('Title') }}</th>
            <th scope="col">{{ __('Profiles') }}</th>
            <th scope="col">{{ __('Actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($professions as $profession)
            <tr>
                <th scope="row">{{ $profession->id }}</th>
                <td>{{ $profession->title }}</td>
                <td>{{ $profession->profiles_count }}</td>
                <td>
                    @if ($profession->profiles_count == 0)
                    <form action="{{ url("profesiones/{$profession->id}") }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link"><span class="oi oi-trash"></span></button>
                    </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</x-app-layout>>
