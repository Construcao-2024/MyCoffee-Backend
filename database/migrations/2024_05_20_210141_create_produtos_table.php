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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idCategoria');
            $table->foreign('idCategoria')->references('id')->on('categorias')->onDelete('cascade');
            $table->string('nome');
            $table->string('marca');
            $table->string('preco');
            $table->string('codigoBarras');
            $table->string('descricao');
            $table->string('quantidade');
            $table->string('imagens');
            $table->string('desconto');
            $table->string('isDeleted');
            $table->timestamps();
        });                         
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
