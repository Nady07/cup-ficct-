<?php

namespace Tests\Feature;

use App\Models\MateriaCup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MateriaControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Crear usuario admin para tests
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    /**
     * Test: Listar materias sin autenticación debe redirigir a login
     */
    public function test_listar_materias_sin_autenticacion()
    {
        $response = $this->get('/admin/materias');
        
        $response->assertRedirect('/login');
    }

    /**
     * Test: Listar materias con autenticación debe retornar 200
     */
    public function test_listar_materias_autenticado()
    {
        $response = $this->actingAs($this->admin)
                        ->get('/admin/materias');
        
        $response->assertStatus(200);
        $response->assertViewHas('materias');
    }

    /**
     * Test: Crear materia - página de creación
     */
    public function test_crear_materia_form()
    {
        $response = $this->actingAs($this->admin)
                        ->get('/admin/materias/create');
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.materias.create');
    }

    /**
     * Test: Guardar nueva materia válida
     */
    public function test_guardar_materia_valida()
    {
        $data = [
            'nombre' => 'Matemática I',
            'codigo' => 'MAT101',
            'creditos' => 3,
            'descripcion' => 'Cálculo diferencial e integral',
            'estado' => 1,
        ];

        $response = $this->actingAs($this->admin)
                        ->post('/admin/materias', $data);

        $this->assertDatabaseHas('materias_cup', ['nombre' => 'Matemática I']);
        $response->assertRedirect('/admin/materias');
    }

    /**
     * Test: No guardar materia con datos inválidos
     */
    public function test_guardar_materia_invalida()
    {
        $data = [
            'nombre' => '', // Requerido, pero vacío
            'codigo' => 'MAT101',
            'creditos' => 'abc', // Debe ser número
        ];

        $response = $this->actingAs($this->admin)
                        ->post('/admin/materias', $data);

        $response->assertSessionHasErrors(['nombre', 'creditos']);
        $this->assertDatabaseMissing('materias_cup', ['codigo' => 'MAT101']);
    }

    /**
     * Test: No permitir materia duplicada
     */
    public function test_no_permitir_materia_codigo_duplicado()
    {
        MateriaCup::create([
            'nombre' => 'Matemática I',
            'codigo' => 'MAT101',
            'creditos' => 3,
            'estado' => 1,
        ]);

        $data = [
            'nombre' => 'Otra Materia',
            'codigo' => 'MAT101', // Código duplicado
            'creditos' => 4,
        ];

        $response = $this->actingAs($this->admin)
                        ->post('/admin/materias', $data);

        $response->assertSessionHasErrors(['codigo']);
    }

    /**
     * Test: Ver detalle de materia
     */
    public function test_ver_detalle_materia()
    {
        $materia = MateriaCup::create([
            'nombre' => 'Física I',
            'codigo' => 'FIS101',
            'creditos' => 4,
            'estado' => 1,
        ]);

        $response = $this->actingAs($this->admin)
                        ->get("/admin/materias/{$materia->id}");

        $response->assertStatus(200);
        $response->assertViewHas('materia', $materia);
    }

    /**
     * Test: Editar página de materia
     */
    public function test_editar_materia_form()
    {
        $materia = MateriaCup::create([
            'nombre' => 'Química I',
            'codigo' => 'QUI101',
            'creditos' => 3,
            'estado' => 1,
        ]);

        $response = $this->actingAs($this->admin)
                        ->get("/admin/materias/{$materia->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('admin.materias.edit');
        $response->assertViewHas('materia', $materia);
    }

    /**
     * Test: Actualizar materia
     */
    public function test_actualizar_materia()
    {
        $materia = MateriaCup::create([
            'nombre' => 'Biología I',
            'codigo' => 'BIO101',
            'creditos' => 3,
            'estado' => 1,
        ]);

        $data = [
            'nombre' => 'Biología I Actualizada',
            'codigo' => 'BIO101',
            'creditos' => 4,
            'estado' => 1,
        ];

        $response = $this->actingAs($this->admin)
                        ->put("/admin/materias/{$materia->id}", $data);

        $this->assertDatabaseHas('materias_cup', [
            'id' => $materia->id,
            'nombre' => 'Biología I Actualizada',
            'creditos' => 4,
        ]);
        $response->assertRedirect('/admin/materias');
    }

    /**
     * Test: Eliminar materia
     */
    public function test_eliminar_materia()
    {
        $materia = MateriaCup::create([
            'nombre' => 'Historia I',
            'codigo' => 'HIS101',
            'creditos' => 2,
            'estado' => 1,
        ]);

        $response = $this->actingAs($this->admin)
                        ->delete("/admin/materias/{$materia->id}");

        $this->assertDatabaseMissing('materias_cup', ['id' => $materia->id]);
        $response->assertRedirect('/admin/materias');
    }
}
