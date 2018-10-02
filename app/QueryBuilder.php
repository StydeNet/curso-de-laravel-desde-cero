<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class QueryBuilder extends Builder
{
    public function whereQuery($subquery, $operator, $value = null)
    {
        $this->addBinding($subquery->getBindings());
        $this->where(DB::raw("({$subquery->toSql()})"), $operator, $value);
    }
}