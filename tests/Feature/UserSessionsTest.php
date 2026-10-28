<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserSessionsTest extends TestCase
{
    use DatabaseTransactions;

    public function test_settings_lists_only_the_authenticated_users_sessions(): void
    {
        config(['session.driver' => 'database']);
        $user = User::factory()->create(['username' => 'session-owner']);
        $otherUser = User::factory()->create(['username' => 'other-owner']);

        $response = $this->actingAs($user)->get(route('user.settings'));
        $response->assertOk();
        $currentSessionId = $response->getCookie(config('session.cookie'))->getValue();
        $this->withCookie(config('session.cookie'), $currentSessionId);
        $this->createSession($currentSessionId, $user->id);
        $this->createSession('other-session', $user->id, '198.51.100.10', 'Firefox on Linux');
        $this->createSession('foreign-session', $otherUser->id, '198.51.100.20', 'Safari on macOS');

        $this->get(route('user.settings'))
            ->assertOk()
            ->assertSee('198.51.100.10')
            ->assertSee('Firefox on Linux')
            ->assertSee('Trenutna sesija')
            ->assertSee('Na ovoj stranici')
            ->assertSee('href="#personal-information"', false)
            ->assertSee('href="#two-factor"', false)
            ->assertDontSee('<nav aria-label="Podešavanja naloga"', false)
            ->assertDontSee('198.51.100.20')
            ->assertDontSee('Safari on macOS')
            ->assertSee(route('user.sessions.destroy-others'));
    }

    public function test_user_can_remove_one_of_their_other_sessions(): void
    {
        config(['session.driver' => 'database']);
        $user = User::factory()->create(['username' => 'session-owner']);
        $otherUser = User::factory()->create(['username' => 'other-owner']);

        $response = $this->actingAs($user)->get(route('user.settings'));
        $response->assertOk();
        $currentSessionId = $response->getCookie(config('session.cookie'))->getValue();
        $this->withCookie(config('session.cookie'), $currentSessionId);
        $this->createSession($currentSessionId, $user->id);
        $this->createSession('session-to-remove', $user->id);
        $this->createSession('foreign-session', $otherUser->id);

        $this->delete(route('user.sessions.destroy'), ['session_id' => 'session-to-remove'])
            ->assertRedirect(route('user.settings'));

        $this->assertDatabaseMissing('sessions', ['id' => 'session-to-remove']);
        $this->assertDatabaseHas('sessions', ['id' => $currentSessionId, 'user_id' => $user->id]);
        $this->assertDatabaseHas('sessions', ['id' => 'foreign-session', 'user_id' => $otherUser->id]);
    }

    public function test_user_can_remove_all_other_sessions_without_removing_the_current_one(): void
    {
        config(['session.driver' => 'database']);
        $user = User::factory()->create(['username' => 'session-owner']);
        $otherUser = User::factory()->create(['username' => 'other-owner']);

        $response = $this->actingAs($user)->get(route('user.settings'));
        $response->assertOk();
        $currentSessionId = $response->getCookie(config('session.cookie'))->getValue();
        $this->withCookie(config('session.cookie'), $currentSessionId);
        $this->createSession($currentSessionId, $user->id);
        $this->createSession('first-other-session', $user->id);
        $this->createSession('second-other-session', $user->id);
        $this->createSession('foreign-session', $otherUser->id);

        $this->delete(route('user.sessions.destroy-others'))
            ->assertRedirect(route('user.settings'));

        $this->assertDatabaseHas('sessions', ['id' => $currentSessionId, 'user_id' => $user->id]);
        $this->assertDatabaseMissing('sessions', ['id' => 'first-other-session']);
        $this->assertDatabaseMissing('sessions', ['id' => 'second-other-session']);
        $this->assertDatabaseHas('sessions', ['id' => 'foreign-session', 'user_id' => $otherUser->id]);
    }

    public function test_user_cannot_remove_another_users_session(): void
    {
        config(['session.driver' => 'database']);
        $user = User::factory()->create(['username' => 'session-owner']);
        $otherUser = User::factory()->create(['username' => 'other-owner']);
        $this->createSession('foreign-session', $otherUser->id);

        $this->actingAs($user)
            ->delete(route('user.sessions.destroy'), ['session_id' => 'foreign-session'])
            ->assertNotFound();

        $this->assertDatabaseHas('sessions', ['id' => 'foreign-session', 'user_id' => $otherUser->id]);
    }

    public function test_removing_the_current_session_logs_the_user_out(): void
    {
        config(['session.driver' => 'database']);
        $user = User::factory()->create(['username' => 'session-owner']);

        $response = $this->actingAs($user)->get(route('user.settings'));
        $response->assertOk();
        $currentSessionId = $response->getCookie(config('session.cookie'))->getValue();
        $this->withCookie(config('session.cookie'), $currentSessionId);
        $this->createSession($currentSessionId, $user->id);

        $this->delete(route('user.sessions.destroy'), ['session_id' => $currentSessionId])
            ->assertRedirect(route('login'));

        $this->assertGuest();
        $this->assertDatabaseMissing('sessions', ['id' => $currentSessionId]);
    }

    private function createSession(string $id, int $userId, ?string $ipAddress = null, ?string $userAgent = null): void
    {
        DB::table('sessions')->updateOrInsert(
            ['id' => $id],
            [
                'user_id' => $userId,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'payload' => '{}',
                'last_activity' => now()->timestamp,
            ],
        );
    }
}
