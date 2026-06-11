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
        //    protected $fillable = ['name', 'slug', 'model', 'year', 'transmission', 'short_description', 'description', 'image', 'passengers', 'active', 'meta_description', 'meta_keywords'];
        Schema::create('fleets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('model');
            $table->integer('year');
            $table->string('transmission');
            $table->string('short_description');
            $table->text('description');
            $table->string('image');
            $table->integer('passengers');
            $table->string('meta_description');
            $table->string('meta_keywords');
            $table->boolean('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fleets');
    }
};
