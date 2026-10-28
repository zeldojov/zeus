<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Fortify\Fortify;
use Tests\TestCase;

class UserSettingsTwoFactorTest extends TestCase
{
    public function test_enabled_two_factor_details_and_recovery_codes_are_always_visible(): void
    {
        $secret = 'JBSWY3DPEHPK3PXP';
        $recoveryCodes = ['FIRST-RECOVERY-CODE', 'SECOND-RECOVERY-CODE'];
        $encrypter = Fortify::currentEncrypter();
        $user = User::factory()->make([
            'username' => 'two-factor-user',
            'two_factor_secret' => $encrypter->encrypt($secret),
            'two_factor_recovery_codes' => $encrypter->encrypt(json_encode($recoveryCodes)),
            'two_factor_confirmed_at' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('user.settings'));

        $response->assertOk()
            ->assertSee('Dvofaktorska zaštita je')
            ->assertSee($secret)
            ->assertSee('data:image/svg+xml;base64,', false)
            ->assertSee($recoveryCodes[0])
            ->assertSee($recoveryCodes[1]);
    }
}
