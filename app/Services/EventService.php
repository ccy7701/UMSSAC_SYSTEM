<?php

namespace App\Services;

use App\Models\Event;

class EventService
{
    // Get the club events
    public function getEventsForClub($club_id) {
        return Event::where('club_id', $club_id)->get();
    }
}
