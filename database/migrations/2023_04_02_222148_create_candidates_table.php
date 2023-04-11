<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_candidates', function (Blueprint $table) {
            $table->id();
            $table->string('n_document');
            $table->bigInteger('type_document_id')->unsigned();
            $table->string('names');
            $table->string('last_names');
            $table->date('dates_birth');
            $table->string('email');
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();
            $table->foreign('type_document_id')->references('id')->on('tb_types_document')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_candidates');
    }
}
