<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CollectionTest extends TestCase
{
    #[Test]
    /**
     * @description Collections are "macroable", which allows you to add additional methods to the `Collection` class at run time. For example, the following code adds a `toUpper` method to the `Collection` class:
     */
    function can_create_a_collection_macro()
    {
        $names = enlighten(function () {
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

        $this->assertSame(['FIRST', 'SECOND'], $names);
    }

    #[Test]
    function can_add_users_to_a_collection()
    {
        $collection = enlighten(function () {
            $user = new User([
                'name' => 'Duilio',
            ]);

            return collect()->add($user);
        });

        $this->assertSame('Duilio',$collection->first()->name);
    }
}
