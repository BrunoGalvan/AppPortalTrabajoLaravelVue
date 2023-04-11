<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatesHasWorksplacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates_has_worksplaces', function (Blueprint $table) {
            $table->bigInteger('candidate_id')->unsigned();
            $table->bigInteger('worksplace_id')->unsigned();
            $table->longText('file_cv');
            $table->string('message');
            $table->timestamps();
            $table->foreign('candidate_id')->references('id')->on('tb_candidates')->onDelete('cascade');
            $table->foreign('worksplace_id')->references('id')->on('tb_worksplaces')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidates_has_worksplaces');
    }
}
