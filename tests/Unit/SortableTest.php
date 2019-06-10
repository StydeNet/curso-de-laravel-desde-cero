<?php

namespace Tests\Unit;

use App\Sortable;
use Tests\TestCase;

class SortableTest extends TestCase
{
    /** @test */
    function returns_a_css_class_to_indicate_the_column_is_sortable()
    {
        $sortable = new Sortable;

        $this->assertSame('link-sortable', $sortable->classes('name'));
    }

    /** @test */
    function returns_css_classes_to_indicate_the_column_is_sorted_in_ascendent_order()
    {
        $sortable = new Sortable;
        $sortable->setCurrentOrder('name');

        $this->assertSame('link-sortable link-sorted-up', $sortable->classes('name'));
    }

    /** @test */
    function returns_css_classes_to_indicate_the_column_is_sorted_in_descendent_order()
    {
        $sortable = new Sortable;
        $sortable->setCurrentOrder('name', 'desc');

        $this->assertSame('link-sortable link-sorted-down', $sortable->classes('name'));
    }
}
