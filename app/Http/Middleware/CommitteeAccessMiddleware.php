<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\ClubMembersService;

class CommitteeAccessMiddleware
{
    protected $clubMembersService;

    public function __construct(ClubMembersService $clubMembersService)
    {
        $this->clubMembersService = $clubMembersService;
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
        $clubId = $request->query('club_id');

        // Check if the user is a faculty member but not a club committee member
        if ($user->account_role == 2 && !$this->clubMembersService->checkCommitteeMember($clubId, $user->profile->profile_id)) {
            abort(403, 'Forbidden');
        }

        return $next($request);
    }
}
