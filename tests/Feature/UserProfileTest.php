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
            ->put(route('profile.update'), [
                'name' => $user->name,
                'email' => $user->email,
                'current_password' => 'password-incorrecta',
                'new_password' => 'password-nueva',
                'new_password_confirmation' => 'password-nueva',
            ])
            ->assertSessionHas('error', 'Contraseña actual incorrecta')
            ->assertSessionDoesntHaveErrors();

        $this->assertTrue(Hash::check('password-original', $user->fresh()->password));
    }

    public function test_actualiza_la_contrasena_y_muestra_mensaje_de_exito(): void
    {
        $user = User::factory()->create([
            'password' => 'password-original',
        ]);

        $this->actingAs($user)
            ->put(route('profile.update'), [
                'name' => $user->name,
                'email' => $user->email,
                'current_password' => 'password-original',
                'new_password' => 'password-nueva',
                'new_password_confirmation' => 'password-nueva',
            ])
            ->assertSessionHas('success', 'Perfil actualizado correctamente.');

        $this->assertTrue(Hash::check('password-nueva', $user->fresh()->password));
    }

    public function test_devuelve_error_si_las_nuevas_contrasenas_no_coinciden(): void
    {
        $user = User::factory()->create([
            'password' => 'password-original',
        ]);

        $this->actingAs($user)
            ->put(route('profile.update'), [
                'name' => $user->name,
                'email' => $user->email,
                'current_password' => 'password-original',
                'new_password' => 'password-nueva',
                'new_password_confirmation' => 'password-distinta',
            ])
            ->assertSessionHas('error', 'Las contraseñas no coinciden');

        $this->assertTrue(Hash::check('password-original', $user->fresh()->password));
    }
}