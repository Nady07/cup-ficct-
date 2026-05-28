<?php

namespace Tests\Feature;

use App\Models\Grupo;
use App\Models\MateriaCup;
use App\Models\Docente;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GrupoControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private MateriaCup $materia;
    private Docente $docente;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create(['role' => 'admin']);
        
        // Crear materia y docente para los grupos
        $this->materia = MateriaCup::create([
            'nombre' => 'Matemática I',
            'codigo' => 'MAT101',
            'creditos' => 3,
            'estado' => 1,
        ]);
        
        $docenteUser = User::factory()->create(['role' => 'docente']);
        $this->docente = Docente::create([
            'user_id' => $docenteUser->id,
            'ci' => '1234567',
            'nombre' => 'Carlos',
            'apellidos' => 'Pérez',
            'email' => 'carlos@ficct.edu.bo',
            'estado_postulacion' => 'aprobado',
            'estado' => true,
        ]);
    }

    /**
     * Test: Listar grupos sin autenticación
     */
    public function test_listar_grupos_sin_autenticacion()
    {
        $response = $this->get('/admin/grupos');
        $response->assertRedirect('/login');
    }

    /**
     * Test: Listar grupos autenticado
     */
    public function test_listar_grupos_autenticado()
    {
        $response = $this->actingAs($this->admin)
                        ->get('/admin/grupos');
        
        $response->assertStatus(200);
        $response->assertViewHas('grupos');
    }

    /**
     * Test: Crear grupo - formulario
     */
    public function test_crear_grupo_form()
    {
        $response = $this->actingAs($this->admin)
                        ->get('/admin/grupos/create');
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.grupos.create');
    }

    /**
     * Test: Guardar nuevo grupo válido
     */
    public function test_guardar_grupo_valido()
    {
        $data = [
            'codigo' => 'G-001',
            'turno' => 'Matutino',
            'aula' => '101',
            'horario_inicio' => '08:00',
            'horario_fin' => '10:00',
            'capacidad_maxima' => 40,
            'docente_id' => $this->docente->id,
            'materia_id' => $this->materia->id,
        ];

        $response = $this->actingAs($this->admin)
                        ->post('/admin/grupos', $data);

        $this->assertDatabaseHas('grupos', ['codigo' => 'G-001']);
        $response->assertRedirect('/admin/grupos');
    }

    /**
     * Test: No guardar grupo con datos inválidos
     */
    public function test_guardar_grupo_invalido()
    {
        $data = [
            'codigo' => '', // Requerido
            'turno' => 'Matutino',
            'capacidad_maxima' => 'abc', // Debe ser número
            'docente_id' => $this->docente->id,
            'materia_id' => $this->materia->id,
        ];

        $response = $this->actingAs($this->admin)
                        ->post('/admin/grupos', $data);

        $response->assertSessionHasErrors(['codigo', 'capacidad_maxima']);
    }

    /**
     * Test: No permitir grupo con código duplicado
     */
    public function test_no_permitir_grupo_codigo_duplicado()
    {
        Grupo::create([
            'codigo' => 'G-001',
            'turno' => 'Matutino',
            'aula' => '101',
            'capacidad_maxima' => 40,
            'docente_id' => $this->docente->id,
            'materia_id' => $this->materia->id,
        ]);

        $data = [
            'codigo' => 'G-001', // Duplicado
            'turno' => 'Vespertino',
            'capacidad_maxima' => 35,
            'docente_id' => $this->docente->id,
            'materia_id' => $this->materia->id,
        ];

        $response = $this->actingAs($this->admin)
                        ->post('/admin/grupos', $data);

        $response->assertSessionHasErrors(['codigo']);
    }

    /**
     * Test: Ver detalle de grupo
     */
    public function test_ver_detalle_grupo()
    {
        $grupo = Grupo::create([
            'codigo' => 'G-001',
            'turno' => 'Matutino',
            'capacidad_maxima' => 40,
            'docente_id' => $this->docente->id,
            'materia_id' => $this->materia->id,
        ]);

        $response = $this->actingAs($this->admin)
                        ->get("/admin/grupos/{$grupo->id}");

        $response->assertStatus(200);
        $response->assertViewHas('grupo', $grupo);
    }

    /**
     * Test: Editar grupo
     */
    public function test_editar_grupo_form()
    {
        $grupo = Grupo::create([
            'codigo' => 'G-002',
            'turno' => 'Vespertino',
            'capacidad_maxima' => 35,
            'docente_id' => $this->docente->id,
            'materia_id' => $this->materia->id,
        ]);

        $response = $this->actingAs($this->admin)
                        ->get("/admin/grupos/{$grupo->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('admin.grupos.edit');
        $response->assertViewHas('grupo', $grupo);
    }

    /**
     * Test: Actualizar grupo
     */
    public function test_actualizar_grupo()
    {
        $grupo = Grupo::create([
            'codigo' => 'G-003',
            'turno' => 'Nocturno',
            'aula' => '201',
            'capacidad_maxima' => 30,
            'docente_id' => $this->docente->id,
            'materia_id' => $this->materia->id,
        ]);

        $data = [
            'codigo' => 'G-003',
            'turno' => 'Matutino',
            'aula' => '202',
            'capacidad_maxima' => 40,
            'docente_id' => $this->docente->id,
            'materia_id' => $this->materia->id,
        ];

        $response = $this->actingAs($this->admin)
                        ->put("/admin/grupos/{$grupo->id}", $data);

        $this->assertDatabaseHas('grupos', [
            'id' => $grupo->id,
            'turno' => 'Matutino',
            'aula' => '202',
        ]);
        $response->assertRedirect('/admin/grupos');
    }

    /**
     * Test: Eliminar grupo
     */
    public function test_eliminar_grupo()
    {
        $grupo = Grupo::create([
            'codigo' => 'G-004',
            'turno' => 'Matutino',
            'capacidad_maxima' => 40,
            'docente_id' => $this->docente->id,
            'materia_id' => $this->materia->id,
        ]);

        $response = $this->actingAs($this->admin)
                        ->delete("/admin/grupos/{$grupo->id}");

        $this->assertDatabaseMissing('grupos', ['id' => $grupo->id]);
        $response->assertRedirect('/admin/grupos');
    }

    /**
     * Test: Grupo debe tener relación con docente
     */
    public function test_grupo_tiene_docente()
    {
        $grupo = Grupo::create([
            'codigo' => 'G-005',
            'turno' => 'Matutino',
            'capacidad_maxima' => 40,
            'docente_id' => $this->docente->id,
            'materia_id' => $this->materia->id,
        ]);

        $this->assertEquals($this->docente->id, $grupo->docente->id);
    }

    /**
     * Test: Grupo debe tener relación con materia
     */
    public function test_grupo_tiene_materia()
    {
        $grupo = Grupo::create([
            'codigo' => 'G-006',
            'turno' => 'Vespertino',
            'capacidad_maxima' => 35,
            'docente_id' => $this->docente->id,
            'materia_id' => $this->materia->id,
        ]);

        $this->assertEquals($this->materia->id, $grupo->materia->id);
    }
}
