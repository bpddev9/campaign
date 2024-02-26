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
        Schema::create('employments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('job_title_id')->constrained('job_titles')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('job_position')->nullable();
            $table->string('job_type');
            $table->string('location_type')->nullable();
            $table->integer('no_of_people')->nullable();
            $table->string('job_schedule')->nullable();
            $table->string('min_salary');
            $table->string('max_salary')->nullable();
            $table->string('pay_rate');
            $table->longText('job_description')->nullable();
            $table->longText('job_benefit')->nullable();
            $table->boolean('can_call')->nullable();
            $table->boolean('can_post_resume')->nullable();
            $table->longText('appl_quest')->nullable();
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
        Schema::dropIfExists('employments');
    }
};
