@extends('layouts.estudiante')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    @include('estudiante.partials.welcome-card')
    @include('estudiante.partials.timeline')
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            @include('estudiante.partials.postulacion')
            @include('estudiante.partials.kpis')
            @include('estudiante.partials.simulador')
        </div>
        <div class="space-y-6">
            @include('estudiante.partials.acciones-rapidas')
            @include('estudiante.partials.documentos')
            @include('estudiante.partials.pago')
            @include('estudiante.partials.documentos-enviados')
        </div>
    </div>
</div>

@include('estudiante.partials.modal-editar-perfil')
@endsection