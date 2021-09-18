<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guids', function (Blueprint $table) {
            $table->id();
            $table->string('cin', 10);
            $table->string('ville', 20);
            $table->string('tel', 20);
            $table->string('adresse');
            $table->string('description');
            $table->string('cover_img');
            $table->foreignId('user_id')->constrained()->unique();
            $table->float('prix_min');
            $table->boolean('valid')->default(false);
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
        Schema::dropIfExists('guids');
    }
}
