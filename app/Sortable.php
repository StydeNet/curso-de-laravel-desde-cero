<?php

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Sortable
{
    protected $currentUrl;
    protected $query = [];

    public function __construct($currentUrl)
    {
        $this->currentUrl = $currentUrl;
    }

    public static function info($order)
    {
        if (Str::endsWith($order, '-desc')) {
            return [Str::substr($order, 0, -5), 'desc'];
        } else {
            return [$order, 'asc'];
        }
    }

    public function appends(array $query)
    {
        $this->query = $query;
    }

    public function url($order)
    {
        return $this->buildSortableUrl($this->order($order));
    }

    public function order($order)
    {
        if ($this->isSortingBy($order)) {
            return "{$order}-desc";
        }

        return $order;
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
