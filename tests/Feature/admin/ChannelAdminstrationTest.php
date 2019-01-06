<?php

namespace Tests\Feature\Admin;

use App\User;
use App\Channel;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChannelAdminstrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();

        $this->withExceptionHandling();
    }

    /** @test  */
    public function an_administrator_can_access_the_channel_administration_section()
    {
        $this->signInAdmin()
            ->get(route('admin.channels.index'))
            ->assertStatus(Response::HTTP_OK);
    }

    /** @test  */
    public function a_non_adminstrator_cannot_access_the_channel_adminstration_section()
    {
        $regularUser = create(User::class);

        $this->actingAs($regularUser)
            ->get(route('admin.channels.index'))
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->actingAs($regularUser)
            ->get(route('admin.channels.create'))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test  */
    public function an_administrator_can_create_a_channel()
    {
        $response = $this->createChannel([
            'name' => 'php',
            'description' => 'This is the channel for discussing all things PHP.',
        ]);

        $this->get($response->headers->get('Location'))
            ->assertSee('php')
            ->assertSee('This is the channel for discussing all things PHP.');
    }

    /** @test */
    public function a_channel_requires_a_name()
    {
        $this->createChannel(['name' => null])
            ->assertSessionHasErrors('name');
    }

    /** @test  */
    public function an_administrator_can_edit_an_existing_channel()
    {
        $this->signInAdmin();

        $channel = create('App\Channel');

        $updated_data = [
            'name' => 'altered',
            'description' => 'altered channel description',
        ];

        $this->patch(
            route('admin.channels.update', ['channel' => $channel->slug]),
            $updated_data
        );

        $this->get(route('admin.channels.index'))
            ->assertSee($updated_data['name'])
            ->assertSee($updated_data['description']);
    }

    /** @test */
    public function a_channel_requires_a_description()
    {
        $this->createChannel(['description' => null])
            ->assertSessionHasErrors('description');
    }

    protected function createChannel($overrides = [])
    {
        $this->signInAdmin();

        $channel = make(Channel::class, $overrides);

        return $this->post(route('admin.channels.store'), $channel->toArray());
    }
}
