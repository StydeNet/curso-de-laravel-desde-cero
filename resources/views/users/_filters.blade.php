<form method="get" action="{{ url('usuarios') }}">
    <div class="row row-filters">
        <div class="col-md-6">
            @foreach (trans('users.filters.states') as $value => $text)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="state"
                           id="state_{{ $value }}" value="{{ $value }}" {{ $value == request('state') ? 'checked' : '' }}>
                    <label class="form-check-label" for="state_{{ $value }}">{{ $text }}</label>
                </div>
            @endforeach
        </div>
    </div>
    <div class="row row-filters">
        <div class="col-md-6">
            <div class="form-inline form-search">
                <input type="search" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Buscar...">
                &nbsp;
                <div class="btn-group">
                    <select name="role" id="role" class="select-field">
                        @foreach(trans('users.filters.roles') as $value => $text)
                            <option value="{{ $value }}"{{ request('role') == $value ? ' selected' : '' }}>{{ $text }}</option>
                        @endforeach
                    </select>
                </div>
                &nbsp;
                <div class="btn-group drop-skills">
                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Habilidades
                    </button>
                    <div class="drop-menu skills-list">
                    @foreach($skills as $skill)
                        <div class="form-group form-check">
                            <input name="skills[]"
                                   type="checkbox"
                                   class="form-check-input"
                                   id="skill_{{ $skill->id }}"
                                   value="{{ $skill->id }}"
                                   {{ $checkedSkills->contains($skill->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="skill_{{ $skill->id }}">{{ $skill->name }}</label>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 text-right">
            <div class="form-inline form-dates">
                <label for="date_start" class="form-label-sm">Fecha</label>&nbsp;
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="date_start" id="date_start" placeholder="Desde">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="date_end" id="date_end" placeholder="Hasta">
                </div>
                &nbsp;
                <button type="submit" class="btn btn-sm btn-primary">Filtrar</button>
            </div>
        </div>
    </div>
</form>