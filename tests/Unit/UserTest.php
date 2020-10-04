<?php

namespace Tests\Unit;

use App\Models\Login;
use App\Models\User;
use Illuminate\Support\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

//    /** @test */
//    function sums_two_numbers()
//    {
//        // @enlighten('SumTest::sums_two_numbers')
//
//        $a = 2;
//        $b = 3;
//
//        enlighten(function ($a, $b) {
//            return sum($a, $b); // 5
//        }, $a, $b);
//
//        $user = User::create();
//
//        $post = new Post;
//
//        //User { /**/}
//        //Post { /**/ }
//
//        $post = enlighten(function ($user, $post) {
//            return $user->addPost($post);
//        });
//
//        // Post { author_id }
//
//        $this->assertSame($user->id, $post->author_id);
//    }

    /** @test */
    function gets_the_last_login_datetime_of_each_user()
    {
        $joel = User::factory()->create(['name' => 'Joel']);
        Login::factory()->create([
            'user_id' => $joel->id,
            'created_at' => '2019-09-18 12:30:00',
        ]);
        Login::factory()->create([
            'user_id' => $joel->id,
            'created_at' => '2019-09-18 12:31:00',
        ]);
        Login::factory()->create([
            'user_id' => $joel->id,
            'created_at' => '2019-09-17 12:31:00',
        ]);

        $ellie = User::factory()->create(['name' => 'Ellie']);
        Login::factory()->create([
            'user_id' => $ellie->id,
            'created_at' => '2019-09-15 12:00:00',
        ]);
        Login::factory()->create([
            'user_id' => $ellie->id,
            'created_at' => '2019-09-15 12:01:00',
        ]);
        Login::factory()->create([
            'user_id' => $ellie->id,
            'created_at' => '2019-09-15 11:59:59',
        ]);

        $users = User::withLastLogin()->get();

//        $this->assertTrue(
//            $users->firstWhere('name', 'Joel')->lastLogin->created_at->eq('2019-09-18 12:31:00')
//        );

        $this->assertInstanceOf(Carbon::class, $users->firstWhere('name', 'Joel')->last_login_at);

        $this->assertEquals(Carbon::parse('2019-09-18 12:31:00'), $users->firstWhere('name', 'Joel')->last_login_at);
        $this->assertEquals(Carbon::parse('2019-09-15 12:01:00'), $users->firstWhere('name', 'Ellie')->last_login_at);
    }
}
