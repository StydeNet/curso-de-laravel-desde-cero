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
        if ($this->isSortingBy($column)) {
            return $this->buildSortableUrl("{$column}-desc");
        }

        return $this->buildSortableUrl($column);
    }

    protected function buildSortableUrl($order)
    {
        return $this->currentUrl.'?'.Arr::query(array_merge($this->query, ['order' => $order]));
    }
    
    public function classes($column)
    {
        if ($this->isSortingBy($column)) {
            return 'link-sortable link-sorted-up';
        }

        if ($this->isSortingBy("{$column}-desc")) {
            return 'link-sortable link-sorted-down';
        }

        return 'link-sortable';
    }

    protected function isSortingBy($column)
    {
        return Arr::get($this->query, 'order') == $column;
    }
}
