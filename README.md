# 🎓 CUP FICCT - Sistema de Administración del Curso Preuniversitario

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-12.60.2-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2-blue?style=flat-square&logo=php)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-15+-blue?style=flat-square&logo=postgresql)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.0-06B6D4?style=flat-square&logo=tailwindcss)
![Alpine.js](https://img.shields.io/badge/Alpine.js-3.0-8BC0D0?style=flat-square&logo=alpine.js)

**Sistema web para la administración del proceso de inscripción, evaluación y admisión universitaria**

*Facultad de Ingeniería de Ciencias de la Computación y Telecomunicaciones - UAGRM*

[📋 Requisitos](#-requisitos-del-sistema) · [🚀 Instalación](#-instalación) · [📊 Módulos](#-módulos) · [📈 Reportes](#-reportes) · [👨‍💻 Autor](#-autor)

</div>

---

## 📖 Descripción

Aplicación web completa desarrollada en **Laravel 12** para administrar el proceso de ingreso de estudiantes al **Curso Preuniversitario (CUP)** de la FICCT. El sistema gestiona desde el registro de postulantes hasta la asignación de grupos y emisión de reportes.

### 🎯 Objetivo

> Analizar, diseñar y desarrollar una aplicación web completa que permita administrar el proceso de inscripción, evaluación y admisión universitaria.

---

## ✨ Características Principales

### 📝 Módulo de Postulantes
- Registro con validación de **CI único**
- Subida y revisión de **requisitos** (título de bachiller, cédula, etc.)
- Flujo completo: **Postulante → Requisitos ✅ → Pago 💰 → Inscrito 📚 → CUP 🎓**

### 📚 Módulo Académico
- **4 materias**: Computación, Matemáticas, Inglés, Física
- **3 exámenes** por materia (0-100 pts)
- **Cálculo automático** de promedio: `(Nota1 + Nota2 + Nota3) / 3`
- **Estado automático**: APROBADO ≥ 60 | REPROBADO < 60

### 👥 Módulo de Grupos
- Cálculo automático: `CEIL(TotalInscritos / 80)`
- Capacidad máxima: **70 estudiantes por grupo**
- Asignación de docentes y horarios

### 👨‍🏫 Módulo de Docentes
- Registro con **credenciales automáticas**
- Gestión de requisitos (maestría, diplomado)
- Flujo de postulación: pendiente → revisión → aprobado/rechazado

### 📊 Dashboard y Reportes
- **KPIs**: total inscritos, aprobados, reprobados, grupos habilitados
- **Reportes**: postulantes, promedios, estadísticas por materia, grupos
- **Exportación PDF** de todos los reportes

### 🎨 Interfaz
- **Modo oscuro** nativo
- **Diseño responsive** (TailwindCSS)
- **Componentes Blade** reutilizables
- **Buscador inteligente** con Alpine.js (debounce 300ms)

---

## 🛠️ Stack Tecnológico

| Tecnología | Versión | Uso |
|------------|---------|-----|
| **Laravel** | 12.60.2 | Framework PHP backend |
| **PHP** | 8.2+ | Lenguaje de programación |
| **PostgreSQL** | 15+ | Base de datos relacional |
| **TailwindCSS** | 3.x | Framework CSS utilitario |
| **Alpine.js** | 3.x | Framework JS reactivo |
| **Vite** | 5.x | Bundler de assets |
| **Laravel Breeze** | 2.x | Autenticación |
| **DomPDF** | 3.x | Exportación de reportes PDF |

---

## 📋 Requisitos del Sistema

- ✅ PHP 8.2 o superior
- ✅ Composer 2.x
- ✅ Node.js 18+ y NPM
- ✅ PostgreSQL 15+
- ✅ Extensiones PHP: `pgsql`, `fileinfo`, `mbstring`, `gd`

---

## 🚀 Instalación

```bash
# 1. Clonar el repositorio
git clone https://github.com/Nady07/cup-ficct-.git
cd cup-ficct-uagrm

# 2. Instalar dependencias PHP
composer install

# 3. Instalar dependencias Node
npm install

# 4. Configurar entorno
cp .env.example .env

# 5. Editar .env con tus credenciales
# DB_CONNECTION=pgsql
# DB_HOST=127.0.0.1
# DB_PORT=5432
# DB_DATABASE=cup_ficct
# DB_USERNAME=postgres
# DB_PASSWORD=tu_password

# 6. Generar application key
php artisan key:generate

# 7. Migrar base de datos
php artisan migrate

# 8. Crear usuarios de prueba (opcional)
php artisan tinker
User::create(['name'=>'Administrador','email'=>'admin@cup.ficct.edu.bo','password'=>bcrypt('admin123'),'role'=>'admin']);
exit

# 9. Compilar assets
npm run build

# 10. Iniciar servidor
php artisan serve