<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * CREATE TABLE 'project_technology'(
     * 'technology_id' UNSIGNED BIGINT NOT NULL,
     * 'prohect_id' UNSIGNED  BIGINT NOT NULL,
     * FOREIGN KEY 'technology_id' REFERENCES 'technologies'('id'),
     * FOREIGN KEY 'project_id' REFERENCES 'projects'('id),
     * 
     * PRIMARY KEY('technology_id' ,'project_id'),
     * 
     * )
     * 'project_technology'-> è scritto cosi perchè per convenzione lo devo scrivere in ordine alfabetico
     */
    public function up(): void
    {
        Schema::create('project_technology', function (Blueprint $table) {
            $table->unsignedBigInteger('technology_id');
            //     Aggiungo cascadeOnDelete che cancella i record nella tabella ponte
            $table->foreign('technology_id')->references('id')->on('technologies')->cascadeOnDelete();

            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->cascadeOnDelete();

            // PRIMARY KEY
            $table->primary(['technology_id' ,'project_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_technology');
    }
};
