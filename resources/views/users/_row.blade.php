<tr>
    <td>{{ $user->id }}</td>
    <th scope="row">
        {{ $user->name }} {{ $user->status }}
        @if ($user->role != 'user')
            ({{ $user->role }})
        @endif
        <span class="status st-{{ $user->state }}"></span>
        <span class="note">{{ $user->team->name }}</span>
    </th>
    <td>{{ $user->email }}</td>
    <td>
        <span class="note">Registro: {{ $user->created_at->format('d/m/Y') }}</span>
        <span class="note">Último login: -</span>
    </td>
    <td class="text-right">
        @if ($user->trashed())
            <form action="{{ route('users.destroy', $user) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-link"><span class="oi oi-circle-x"></span></button>
            </form>
        @else
            <form action="{{ route('users.trash', $user) }}" method="POST">
                @csrf
                @method('PATCH')
                <a href="{{ route('users.show', $user) }}" class="btn btn-outline-secondary btn-sm"><span class="oi oi-eye"></span></a>
                <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-secondary btn-sm"><span class="oi oi-pencil"></span></a>
                <button type="submit" class="btn btn-outline-danger btn-sm"><span class="oi oi-trash"></span></button>
            </form>
        @endif
    </td>
</tr>
<tr class="skills">
    <td>&nbsp;</td>
    <td colspan="1">
        <span class="note">{{ $user->profile->profession->title }}</span>
    </td>
    <td colspan="4"><span class="note">{{ $user->skills->implode('name', ', ') }}</span></td>
</tr>