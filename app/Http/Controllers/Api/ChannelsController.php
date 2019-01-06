<?php

namespace App\Http\Controllers\Api;

use App\Channel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChannelsController extends Controller
{
    /**
     * Fetch all channels
     */
    public function index()
    {
        return cache()->rememberForever('channels', function () {
            return Channel::where('archived', false)
                ->orderBy('name', 'asc')->get();
        });
    }
}
