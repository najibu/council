<?php

namespace Tests\Feature;

use App\Channel;
use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PinThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test  */
    public function adminstrators_can_pin_threads()
    {
        $this->signInAdmin();

        $thread = create('App\Thread');

        $this->post(route('pinned-threads.store', $thread));

        $this->assertTrue($thread->fresh()->pinned, 'Failed asserting that the thread was pinned.');
    }

    /** @test  */
    public function adminstrators_can_unpin_threads()
    {
        $this->signInAdmin();

        $thread = create('App\Thread', ['pinned' => true]);

        $this->delete(route('pinned-threads.destroy', $thread));

        $this->assertFalse($thread->fresh()->pinned, 'Failed asserting that the thread was unpinned.');
    }

    /** @test  */
    public function pinned_threads_are_listed_first()
    {
        $this->signInAdmin();

        $threads = create(Thread::class, [], 3);
        $ids = $threads->pluck('id');

        $this->getJson(route('threads'))
            ->assertJson([
                'data' => [
                    ['id' => $ids[0]],
                    ['id' => $ids[1]],
                    ['id' => $ids[2]]
                ]
            ]);

        $this->post(route('pinned-threads.store', $pinned = $threads->last()));

        $this->getJson(route('threads'))
            ->assertJson([
                'data' => [
                    ['id' => $pinned->id],
                    ['id' => $ids[0]],
                    ['id' => $ids[1]]
                ]
            ]);
    }
}
