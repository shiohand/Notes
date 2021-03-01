<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Person;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HelloTest extends TestCase
{
  use RefreshDatabase;

  public function testHello()
  {
    User::factory()
      ->state([
        'name' => 'AAA',
        'email' => 'BBB@CCC.COM',
        'password' => 'ABCABC',
      ])
      ->create();
    User::factory()->count(10)->create();

    $this->assertDatabaseHas('users', [
      'name' => 'AAA',
      'email' => 'BBB@CCC.COM',
      'password' => 'ABCABC',
    ]);
    Person::factory()
      ->state([
        'name' => 'XXX',
        'mail' => 'YYY@ZZZ.COM',
        'age' => '123',
      ])
      ->create();
    Person::factory()->count(10)->create();

    $this->assertDatabaseHas('people', [
      'name' => 'XXX',
      'mail' => 'YYY@ZZZ.COM',
      'age' => '123',
    ]);
  }
}
