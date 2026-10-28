<?php

namespace App\Http\Controllers;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserSessionController extends Controller
{
    public function destroy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'session_id' => ['required', 'string'],
        ]);
        $sessionId = $validated['session_id'];
        $session = $this->sessionsTable()
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->where('id', $sessionId);

        abort_unless($session->exists(), 404);

        if (hash_equals($request->session()->getId(), $sessionId)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login');
        }

        $session->delete();

        return redirect()->route('user.settings')->with('status', 'session-removed');
    }

    public function destroyOthers(Request $request): RedirectResponse
    {
        $this->sessionsTable()
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->where('id', '!=', $request->session()->getId())
            ->delete();

        return redirect()->route('user.settings')->with('status', 'other-sessions-removed');
    }

    private function sessionsTable(): Builder
    {
        abort_unless(config('session.driver') === 'database', 404);

        return DB::connection(config('session.connection'))
            ->table(config('session.table'));
    }
}
