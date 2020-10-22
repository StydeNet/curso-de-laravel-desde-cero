<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Tests\TestCase;

class CollectionTest extends TestCase
{
    /**
     * @test
     * @description Collections are "macroable", which allows you to add additional methods to the `Collection` class at run time. For example, the following code adds a `toUpper` method to the `Collection` class:
     */
    function can_create_a_collection_macro()
    {
        $callback = enlighten(function () {
            // use Illuminate\Support\Collection;
            // use Illuminate\Support\Str;

            Collection::macro('toUpper', function () {
                return $this->map(function ($value) {
                    return Str::upper($value);
                });
            });

            $collection = collect(['first', 'second']);

            return $collection->toUpper()->all();
        });

        $this->assertSame(['FIRST', 'SECOND'], $callback());
    }

    /** @test */
    function can_add_users_to_a_collection()
    {
        $user = new User([
            'name' => 'Duilio',
        ]);

        $code = enlighten(function ($user) {
            return collect()->add($user);
        });

        $this->assertSame('Duilio', $code($user)->first()->name);
    }
}
