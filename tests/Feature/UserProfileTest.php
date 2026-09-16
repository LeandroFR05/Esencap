<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_no_actualiza_la_contrasena_si_la_actual_es_incorrecta(): void
    {
        $user = User::factory()->create([
            'password' => 'password-original',
        ]);

        $this->actingAs($user)
            ->put(route('profile.password.update'), [
                'current_password' => 'password-incorrecta',
                'new_password' => 'password-nueva',
                'new_password_confirmation' => 'password-nueva',
            ])
            ->assertSessionHasErrors(['current_password' => 'La contraseña actual es incorrecta.']);

        $this->assertTrue(Hash::check('password-original', $user->fresh()->password));
    }

    public function test_actualiza_la_contrasena_y_muestra_mensaje_de_exito(): void
    {
        $user = User::factory()->create([
            'password' => 'password-original',
        ]);

        $this->actingAs($user)
            ->put(route('profile.password.update'), [
                'current_password' => 'password-original',
                'new_password' => 'password-nueva',
                'new_password_confirmation' => 'password-nueva',
            ])
            ->assertSessionHas('success', 'Contraseña actualizada correctamente.');

        $this->assertTrue(Hash::check('password-nueva', $user->fresh()->password));
    }

    public function test_devuelve_error_si_las_nuevas_contrasenas_no_coinciden(): void
    {
        $user = User::factory()->create([
            'password' => 'password-original',
        ]);

        $this->actingAs($user)
            ->put(route('profile.password.update'), [
                'current_password' => 'password-original',
                'new_password' => 'password-nueva',
                'new_password_confirmation' => 'password-distinta',
            ])
            ->assertSessionHasErrors(['new_password' => 'No coincide con la nueva contraseña.']);

        $this->assertTrue(Hash::check('password-original', $user->fresh()->password));
    }
}