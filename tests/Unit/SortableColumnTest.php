<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Rules\SortableColumn;

class SortableColumnTest extends TestCase
{
    /** @test */
    function validates_sortable_values()
    {
        $rule = new SortableColumn(['id', 'name', 'email']);

        $this->assertTrue($rule->passes('order', 'id'));
        $this->assertTrue($rule->passes('order', 'name'));
        $this->assertTrue($rule->passes('order', 'email'));
        $this->assertTrue($rule->passes('order', 'id-desc'));
        $this->assertTrue($rule->passes('order', 'name-desc'));
        $this->assertTrue($rule->passes('order', 'email-desc'));

        $this->assertFalse($rule->passes('order', []));
        $this->assertFalse($rule->passes('order', 'first_name'));
        $this->assertFalse($rule->passes('order', 'name-descendent'));
        $this->assertFalse($rule->passes('order', 'asc-name'));
        $this->assertFalse($rule->passes('order', 'email-'));
        $this->assertFalse($rule->passes('order', 'email-des'));
        $this->assertFalse($rule->passes('order', 'name-descx'));
        $this->assertFalse($rule->passes('order', 'desc-name'));
    }
}
