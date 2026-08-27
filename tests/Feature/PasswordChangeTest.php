<?php

// tests/Feature/PasswordChangeTest.php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordChangeTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_change_page_is_accessible()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('profile.editPassword'));

        $response->assertStatus(200);
        $response->assertViewIs('profile.editPassword');
    }

    public function test_password_can_be_changed_with_valid_current_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        $response = $this->actingAs($user)->put(route('profile.update-password'), [
            'current_password' => 'old-password',
            'new_password' => 'new-password',
            'new_password_confirmation' => 'new-password',
        ]);

        $response->assertRedirect(route('profile.show'));
        $response->assertSessionHas('message', 'Password aggiornata.');

        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }

    public function test_password_cannot_be_changed_with_invalid_current_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        $response = $this->actingAs($user)->put(route('profile.update-password'), [
            'current_password' => 'wrong-password',
            'new_password' => 'new-password',
            'new_password_confirmation' => 'new-password',
        ]);

        $response->assertSessionHasErrors('current_password');
        $this->assertTrue(Hash::check('old-password', $user->fresh()->password));
    }

    public function test_password_cannot_be_changed_without_confirmation()
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        $response = $this->actingAs($user)->put(route('profile.update-password'), [
            'current_password' => 'old-password',
            'new_password' => 'new-password',
            'new_password_confirmation' => 'wrong-confirmation',
        ]);

        $response->assertSessionHasErrors('new_password');
        $this->assertTrue(Hash::check('old-password', $user->fresh()->password));
    }
}
