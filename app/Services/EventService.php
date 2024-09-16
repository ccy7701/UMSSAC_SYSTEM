<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class EventService
{
    // Get all club events for all clubs
    public function getAllEvents(array $filters, $search = null) {
        // Always save the filters, even if empty (to clear the saved filters)
        DB::table('user_preference')
            ->where('profile_id', profile()->profile_id)
            ->update([
                'event_search_filters' => json_encode($filters),
                'updated_at' => now()
            ]);

        // Fetch events based on the filters (if empty, return all events) and search input
        return Event::join('club', 'event.club_id', '=', 'club.club_id')
            ->when(!empty($filters['category_filter']), function ($query) use ($filters) {
                return $query->whereIn('club.club_category', $filters['category_filter']);
            })
            ->when(!empty($filters['event_status']), function ($query) use ($filters) {
                return $query->whereIn('event.event_status', $filters['event_status']);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('event.event_name', 'like', "%{$search}%")
                      ->orWhere('event.event_description', 'like', "%{$search}%");
                });
            })
            ->select('event.*')
            ->paginate(9);  // TEST, paginate with 9 items per page
    }

    // Get the club events
    public function getEventsForClub($club_id) {
        return Event::where('club_id', $club_id)->paginate(9);
    }
}
