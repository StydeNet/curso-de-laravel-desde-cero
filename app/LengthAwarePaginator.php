<?php

namespace App;

class LengthAwarePaginator extends \Illuminate\Pagination\LengthAwarePaginator
{
    public function parameters()
    {
        return $this->query;
    }
}
