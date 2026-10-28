<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserSettingsController extends Controller
{
    public function __invoke(Request $request): View
    {
        $sessionManagementAvailable = config('session.driver') === 'database';
        $sessions = collect();

        if ($sessionManagementAvailable) {
            $sessions = DB::connection(config('session.connection'))
                ->table(config('session.table'))
                ->where('user_id', $request->user()->getAuthIdentifier())
                ->orderByDesc('last_activity')
                ->get(['id', 'ip_address', 'user_agent', 'last_activity'])
                ->map(function (object $session) use ($request): object {
                    $session->is_current = hash_equals($request->session()->getId(), $session->id);

                    return $session;
                });
        }

        return view('user.settings', compact('sessionManagementAvailable', 'sessions'));
    }
}
