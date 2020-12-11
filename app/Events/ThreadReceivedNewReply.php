<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ThreadReceivedNewReply
{
    use Dispatchable, SerializesModels;

    /**
     * The reply that was posted.
     *
     * @param \App\Reply $reply
     */
    public $reply;

    /**
     * Create a new event instance.
     *
     * @param \App\Reply $reply
     */
    public function __construct($reply)
    {
        $this->reply = $reply;
    }

    /**
     * Get the subject of the event.
     */
    public function subject()
    {
        return $this->reply;
    }
}
