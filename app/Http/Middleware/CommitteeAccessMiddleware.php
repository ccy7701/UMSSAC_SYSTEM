<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\ClubAndEventService;
use Symfony\Component\HttpFoundation\Response;

class CommitteeAccessMiddleware
{
    protected $clubAndEventService;

    public function __construct(ClubAndEventService $clubAndEventService)
    {
        $this->clubAndEventService = $clubAndEventService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the current user profile and club ID from the request
        $user = currentAccount();
        $clubId = $request->query('club_id') ?? $request->input('club_id');

        // If the user is a student (role 1) or faculty member (role 2), check committee membership
        if (in_array($user->account_role, [1, 2])) {
            // Check if the user is part of the club's committee
            $isCommitteeMember = $this->clubAndEventService->checkCommitteeMember($clubId, $user->profile->profile_id);

            // If not a committee member, abort with a 403 Forbidden response
            if (!$isCommitteeMember) {
                abort(403, 'Forbidden');
            }
        }

        return $next($request);
    }
}
