<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCalificacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'estudiante_id' => 'required|exists:estudiantes,id',
            'materia_id'    => 'required|exists:materias_cup,id',
            'nota1'         => 'required|numeric|min:0|max:100',
            'nota2'         => 'required|numeric|min:0|max:100',
            'nota3'         => 'required|numeric|min:0|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'estudiante_id.required' => 'Debe seleccionar un estudiante.',
            'estudiante_id.exists'   => 'El estudiante seleccionado no es válido.',
            'materia_id.required'    => 'Debe seleccionar una materia.',
            'materia_id.exists'      => 'La materia seleccionada no es válida.',
            'nota1.required'         => 'La nota del primer examen es obligatoria.',
            'nota2.required'         => 'La nota del segundo examen es obligatoria.',
            'nota3.required'         => 'La nota del tercer examen es obligatoria.',
            'nota1.numeric'          => 'Las notas deben ser valores numéricos.',
            'nota1.min'              => 'Las notas no pueden ser menores a 0.',
            'nota1.max'              => 'Las notas no pueden ser mayores a 100.',
        ];
    }
}