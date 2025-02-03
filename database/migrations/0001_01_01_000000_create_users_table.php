<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Crea la tabla 'users' con los siguientes campos
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Crea una columna 'id' autoincremental como clave primaria
            $table->string('name'); // Crea una columna 'name' para almacenar el nombre del usuario
            $table->string('surnames'); // Crea una columna 'surnames' para almacenar los apellidos del usuario
            $table->string('email')->unique(); // Crea una columna 'email' que debe ser única
            $table->string('password'); // Crea una columna 'password' para almacenar la contraseña del usuario
            $table->string('image_path')->nullable(); // Crea una columna 'image_path' para almacenar la ruta de la imagen de perfil del usuario, que puede ser nula
            $table->boolean('status')->default(true); // Crea una columna 'status' para almacenar el estado del usuario, con un valor predeterminado de 'true' (activo)
            $table->enum('role', ['admin', 'vendedor', 'cliente'])->default('cliente'); // Crea una columna 'role' con un valor enum, con opciones 'admin', 'vendedor', 'cliente', y un valor predeterminado de 'cliente'
            $table->timestamps(); // Crea las columnas 'created_at' y 'updated_at' para el seguimiento de la creación y actualización del registro
        });
    }

    public function down()
    {
        // Elimina la tabla 'users' si existe
        Schema::dropIfExists('users');
    }
};

