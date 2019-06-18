<?php

namespace App;

use Illuminate\Support\Arr;

class Sortable
{
    protected $currentUrl;
    protected $query = [];

    public function __construct($currentUrl)
    {
        $this->currentUrl = $currentUrl;
    }

    public function appends(array $query)
    {
        $this->query = $query;
    }

    public function url($column)
    {
        if ($this->isSortingBy($column, 'asc')) {
            return $this->buildSortableUrl($column, 'desc');
        }

        return $this->buildSortableUrl($column, 'asc');
    }

    protected function buildSortableUrl($column, $direction = 'asc')
    {
        return $this->currentUrl.'?'.Arr::query(array_merge(
            $this->query, ['order' => $column, 'direction' => $direction]
        ));
    }
    
    public function classes($column)
    {
        if ($this->isSortingBy($column, 'asc')) {
            return 'link-sortable link-sorted-up';
        }

        if ($this->isSortingBy($column, 'desc')) {
            return 'link-sortable link-sorted-down';
        }

        return 'link-sortable';
    }

    protected function isSortingBy($column, $direction)
    {
        return Arr::get($this->query, 'order') == $column && Arr::get($this->query, 'direction', 'asc') == $direction;
    }
}
