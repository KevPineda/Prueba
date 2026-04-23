<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \DB::unprepared("CREATE TABLE `publicaciones` (`id` INT NOT NULL AUTO_INCREMENT , `titulo` VARCHAR(255) NOT NULL , `contenido` TEXT NOT NULL , `imagen` TEXT NOT NULL , `email_registro` VARCHAR(255) NOT NULL , `fecha_registro` DATETIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_publicaciones');
    }
};
