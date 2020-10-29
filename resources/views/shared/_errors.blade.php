
@if ($errors->any())
    <div class="alert alert-danger">
        <h6>{{ __('Please fix the following errors') }}:</h6>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
