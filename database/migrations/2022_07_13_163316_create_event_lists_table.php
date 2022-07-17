<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_lists', function (Blueprint $table) {
            $table->id();
            $table->string('event_name'); // Nom de l'évenement
            $table->string('event_content'); // Contenu de l'évenement
            $table->date('event_start'); // Début de l'évenement
            $table->date('event_end'); // Fin de l'évenement
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_lists');
    }
};
