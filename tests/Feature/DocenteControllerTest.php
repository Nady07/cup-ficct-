<?php

namespace Tests\Feature;

use App\Models\Docente;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DocenteControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    /**
     * Test: Listar docentes sin autenticación
     */
    public function test_listar_docentes_sin_autenticacion()
    {
        $response = $this->get('/admin/docentes');
        $response->assertRedirect('/login');
    }

    /**
     * Test: Listar docentes autenticado
     */
    public function test_listar_docentes_autenticado()
    {
        $response = $this->actingAs($this->admin)
                        ->get('/admin/docentes');
        
        $response->assertStatus(200);
        $response->assertViewHas('docentes');
    }

    /**
     * Test: Crear docente - formulario
     */
    public function test_crear_docente_form()
    {
        $response = $this->actingAs($this->admin)
                        ->get('/admin/docentes/create');
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.docentes.create');
    }

    /**
     * Test: Guardar nuevo docente válido
     */
    public function test_guardar_docente_valido()
    {
        $data = [
            'ci' => '1234567',
            'nombre' => 'Juan',
            'apellidos' => 'García',
            'email' => 'juan@ficct.edu.bo',
            'telefono' => '74123456',
            'especialidad' => 'Matemática',
            'experiencia' => 'Docente universitario',
        ];

        $response = $this->actingAs($this->admin)
                        ->post('/admin/docentes', $data);

        $this->assertDatabaseHas('docentes', ['ci' => '1234567']);
        $this->assertDatabaseHas('users', ['email' => 'juan@ficct.edu.bo']);
        $response->assertRedirect('/admin/docentes');
    }

    /**
     * Test: Contraseña del nuevo docente es aleatoria (NO hardcodeada)
     */
    public function test_docente_tiene_password_aleatoria()
    {
        $data1 = [
            'ci' => '1111111',
            'nombre' => 'Docente1',
            'apellidos' => 'Prueba',
            'email' => 'docente1@ficct.edu.bo',
            'especialidad' => 'Física',
        ];

        $data2 = [
            'ci' => '2222222',
            'nombre' => 'Docente2',
            'apellidos' => 'Prueba',
            'email' => 'docente2@ficct.edu.bo',
            'especialidad' => 'Química',
        ];

        $this->actingAs($this->admin)->post('/admin/docentes', $data1);
        $this->actingAs($this->admin)->post('/admin/docentes', $data2);

        $user1 = User::where('email', 'docente1@ficct.edu.bo')->first();
        $user2 = User::where('email', 'docente2@ficct.edu.bo')->first();

        // Las contraseñas hasheadas deben ser diferentes
        $this->assertNotEquals($user1->password, $user2->password);
    }

    /**
     * Test: No guardar docente con datos inválidos
     */
    public function test_guardar_docente_invalido()
    {
        $data = [
            'ci' => '', // Requerido
            'nombre' => 'Juan',
            'apellidos' => 'García',
            'email' => 'email-invalido', // Email inválido
            'especialidad' => 'Matemática',
        ];

        $response = $this->actingAs($this->admin)
                        ->post('/admin/docentes', $data);

        $response->assertSessionHasErrors(['ci', 'email']);
    }

    /**
     * Test: No permitir CI duplicado
     */
    public function test_no_permitir_ci_duplicado()
    {
        $docenteUser = User::factory()->create(['role' => 'docente']);
        Docente::create([
            'user_id' => $docenteUser->id,
            'ci' => '9876543',
            'nombre' => 'Existente',
            'apellidos' => 'Docente',
            'email' => 'existente@ficct.edu.bo',
            'estado_postulacion' => 'aprobado',
            'estado' => true,
        ]);

        $data = [
            'ci' => '9876543', // Duplicado
            'nombre' => 'Nuevo',
            'apellidos' => 'Docente',
            'email' => 'nuevo@ficct.edu.bo',
            'especialidad' => 'Lenguaje',
        ];

        $response = $this->actingAs($this->admin)
                        ->post('/admin/docentes', $data);

        $response->assertSessionHasErrors(['ci']);
    }

    /**
     * Test: No permitir email duplicado
     */
    public function test_no_permitir_email_duplicado()
    {
        $docenteUser = User::factory()->create(['role' => 'docente']);
        Docente::create([
            'user_id' => $docenteUser->id,
            'ci' => '1111111',
            'nombre' => 'Existente',
            'apellidos' => 'Email',
            'email' => 'duplicado@ficct.edu.bo',
            'estado_postulacion' => 'aprobado',
            'estado' => true,
        ]);

        $data = [
            'ci' => '2222222',
            'nombre' => 'Otro',
            'apellidos' => 'Docente',
            'email' => 'duplicado@ficct.edu.bo', // Duplicado
            'especialidad' => 'Deporte',
        ];

        $response = $this->actingAs($this->admin)
                        ->post('/admin/docentes', $data);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test: Ver detalle de docente
     */
    public function test_ver_detalle_docente()
    {
        $docenteUser = User::factory()->create(['role' => 'docente']);
        $docente = Docente::create([
            'user_id' => $docenteUser->id,
            'ci' => '3333333',
            'nombre' => 'Carlos',
            'apellidos' => 'López',
            'email' => 'carlos@ficct.edu.bo',
            'estado_postulacion' => 'aprobado',
            'estado' => true,
        ]);

        $response = $this->actingAs($this->admin)
                        ->get("/admin/docentes/{$docente->id}");

        $response->assertStatus(200);
        $response->assertViewHas('docente', $docente);
    }

    /**
     * Test: Editar docente
     */
    public function test_editar_docente_form()
    {
        $docenteUser = User::factory()->create(['role' => 'docente']);
        $docente = Docente::create([
            'user_id' => $docenteUser->id,
            'ci' => '4444444',
            'nombre' => 'María',
            'apellidos' => 'Rodríguez',
            'email' => 'maria@ficct.edu.bo',
            'estado_postulacion' => 'aprobado',
            'estado' => true,
        ]);

        $response = $this->actingAs($this->admin)
                        ->get("/admin/docentes/{$docente->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('admin.docentes.edit');
        $response->assertViewHas('docente', $docente);
    }

    /**
     * Test: Actualizar docente
     */
    public function test_actualizar_docente()
    {
        $docenteUser = User::factory()->create(['role' => 'docente']);
        $docente = Docente::create([
            'user_id' => $docenteUser->id,
            'ci' => '5555555',
            'nombre' => 'Pedro',
            'apellidos' => 'Martínez',
            'email' => 'pedro@ficct.edu.bo',
            'especialidad' => 'Ingeniería',
            'estado_postulacion' => 'aprobado',
            'estado' => true,
        ]);

        $data = [
            'ci' => '5555555',
            'nombre' => 'Pedro',
            'apellidos' => 'Martínez',
            'email' => 'pedro@ficct.edu.bo',
            'especialidad' => 'Ingeniería Avanzada',
            'experiencia' => '10 años',
        ];

        $response = $this->actingAs($this->admin)
                        ->put("/admin/docentes/{$docente->id}", $data);

        $this->assertDatabaseHas('docentes', [
            'id' => $docente->id,
            'especialidad' => 'Ingeniería Avanzada',
        ]);
        $response->assertRedirect('/admin/docentes');
    }

    /**
     * Test: Eliminar docente
     */
    public function test_eliminar_docente()
    {
        $docenteUser = User::factory()->create(['role' => 'docente']);
        $docente = Docente::create([
            'user_id' => $docenteUser->id,
            'ci' => '6666666',
            'nombre' => 'Ana',
            'apellidos' => 'Flores',
            'email' => 'ana@ficct.edu.bo',
            'estado_postulacion' => 'aprobado',
            'estado' => true,
        ]);

        $response = $this->actingAs($this->admin)
                        ->delete("/admin/docentes/{$docente->id}");

        $this->assertDatabaseMissing('docentes', ['id' => $docente->id]);
        $response->assertRedirect('/admin/docentes');
    }

    /**
     * Test: Docente tiene usuario asociado
     */
    public function test_docente_tiene_usuario()
    {
        $user = User::factory()->create(['role' => 'docente']);
        $docente = Docente::create([
            'user_id' => $user->id,
            'ci' => '7777777',
            'nombre' => 'Luis',
            'apellidos' => 'Silva',
            'email' => 'luis@ficct.edu.bo',
            'estado_postulacion' => 'aprobado',
            'estado' => true,
        ]);

        $this->assertEquals($user->id, $docente->user->id);
        $this->assertEquals($user->email, $docente->email);
    }

    /**
     * Test: Solo docentes aprobados deben aparecer en listado
     */
    public function test_listar_solo_docentes_aprobados()
    {
        $user1 = User::factory()->create(['role' => 'docente']);
        $user2 = User::factory()->create(['role' => 'docente']);

        Docente::create([
            'user_id' => $user1->id,
            'ci' => '8888888',
            'nombre' => 'Aprobado',
            'apellidos' => 'Docente',
            'email' => 'aprobado@ficct.edu.bo',
            'estado_postulacion' => 'aprobado',
            'estado' => true,
        ]);

        Docente::create([
            'user_id' => $user2->id,
            'ci' => '9999999',
            'nombre' => 'Rechazado',
            'apellidos' => 'Docente',
            'email' => 'rechazado@ficct.edu.bo',
            'estado_postulacion' => 'rechazado',
            'estado' => false,
        ]);

        $response = $this->actingAs($this->admin)
                        ->get('/admin/docentes');

        $docentes = $response->viewData('docentes');
        $this->assertTrue($docentes->contains('nombre', 'Aprobado'));
        $this->assertFalse($docentes->contains('nombre', 'Rechazado'));
    }
}
