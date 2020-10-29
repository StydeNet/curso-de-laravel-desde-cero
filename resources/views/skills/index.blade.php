<x-app-layout>
    <x-slot name="title">@lang('Skills')</x-slot>

    <div class="d-flex justify-content-between align-items-end mb-3">
        <h1 class="pb-1">{{ __('Skills') }}</h1>
    </div>

    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">{{ __('Title') }}</th>
            <th scope="col">{{ __('Actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($skills as $skill)
            <tr>
                <th scope="row">{{ $skill->id }}</th>
                <td>{{ $skill->name }}</td>
                <td>
                    {{--<form action="{{ route('users.destroy', $user) }}" method="POST">--}}
                        {{--{{ csrf_field() }}--}}
                        {{--{{ method_field('DELETE') }}--}}
                        {{--<button type="submit" class="btn btn-link"><span class="oi oi-trash"></span></button>--}}
                    {{--</form>--}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</x-app-layout>
