<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase; // Opcional: si necesitas limpiar la base de datos entre tests

    public function test_el_usuario_puede_iniciar_sesion_con_credenciales_correctas()
    {
        // 1. Preparación: Crear un usuario de prueba en la base de datos
        $user = User::factory()->create([
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
        ]);

        // 2. Acción: Simular una petición POST a la ruta de login
        $response = $this->post('/login', [
            'email' => 'admin@gmail.com',
            'password' => 'admin123',
        ]);

        // 3. Validación (Aserciones):
        
        // Comprobar que el sistema redirige al usuario (por ejemplo, al Home/Dashboard)
        $response->assertRedirect('/dashboard'); 
        
        // ¡La aserción más importante! Comprobar que el usuario está realmente autenticado
        $this->assertAuthenticatedAs($user);
        
        // Alternativamente, puedes usar:
        // $this->assertAuthenticated();
    }
}