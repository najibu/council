<?php

namespace Tests\Feature\admin;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AdminstratorTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->withExceptionHandling();
    }

    /** @test  */
    public function an_administrator_can_access_the_administration_section()
    {
        $adminstrator = factory('App\User')->create();
        config(['council.adminstrators' => [ $adminstrator->email ]]);
        $this->signIn($adminstrator);

        $this->actingAs($adminstrator)
            ->get('/admin')
            ->assertStatus(Response::HTTP_OK);
    }

    /** @test  */
    public function a_non_adminstrator_cannot_access_the_adminstration_section()
    {
        $regularUser = factory(User::class)->create();

        $this->actingAs($regularUser)
            ->get('/admin')
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
