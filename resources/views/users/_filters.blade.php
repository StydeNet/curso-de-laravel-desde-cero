<form method="get" action="{{ url('usuarios') }}">
    <div class="row row-filters">
        <div class="col-md-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" checked>
                <label class="form-check-label" for="inlineRadio1">Todos</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                <label class="form-check-label" for="inlineRadio2">Solo activos</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                <label class="form-check-label" for="inlineRadio3">Solo inactivos</label>
            </div>
        </div>
    </div>
    <div class="row row-filters">
        <div class="col-md-6">
            <div class="form-inline form-search">
                <input type="search" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Buscar...">
                &nbsp;
                <div class="btn-group">
                    <select name="rol" id="rol" class="select-field">
                        <option value="">Rol</option>
                        <option value="todos">Todos</option>
                        <option value="usuario">Usuario</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                &nbsp;
                <div class="btn-group drop-skills">
                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Habilidades
                    </button>
                    <div class="drop-menu skills-list">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="skill1">
                            <label class="form-check-label" for="skill1">CSS</label>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="skill2">
                            <label class="form-check-label" for="skill2">Laravel Development</label>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="skill3">
                            <label class="form-check-label" for="skill3">Front End</label>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="skill4">
                            <label class="form-check-label" for="skill4">Bases de Datos</label>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="skill5">
                            <label class="form-check-label" for="skill5">Javascript</label>
                        </div>
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