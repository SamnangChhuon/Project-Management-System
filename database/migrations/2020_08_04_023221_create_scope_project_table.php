<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScopeProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('project_name');
            $table->string('hourly_rate', 100)->nullable()->default('0');
            $table->string('budget', 100)->nullable()->default('0');
            $table->boolean('active')->nullable()->default(false);
            $table->string('total_hours', 100)->nullable()->default('0');
            $table->double('labor_costs', 15, 2)->nullable()->default(00.00);
            $table->double('material_costs', 15, 2)->nullable()->default(00.00);
            $table->double('total_costs', 15, 2)->nullable()->default(00.00);
            $table->integer('project_manager_id')->unsigned()->nullable()->default(0);
            $table->integer('status_id')->unsigned()->nullable()->default(0);
            $table->integer('client_id')->unsigned()->nullable()->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('project_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status', 100)->nullable()->default();
            $table->timestamps();
        });

        Schema::create('task_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status', 100)->nullable()->default();
            $table->timestamps();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('task_name');
            $table->text('instructions')->nullable();
            $table->string('total_hours', 100)->nullable()->default('0');
            $table->integer('status_id')->unsigned()->nullable()->default(0);
            $table->integer('milestone_id')->unsigned()->nullable()->default(0);
            $table->integer('project_id')->unsigned()->nullable()->default(0);
            $table->integer('employee_id')->unsigned()->nullable()->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('projects');
        Schema::dropIfExists('project_status');
        Schema::dropIfExists('task_status');
        Schema::dropIfExists('tasks');
    }
}
