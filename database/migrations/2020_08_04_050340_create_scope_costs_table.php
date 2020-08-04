<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScopeCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('milestones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100)->nullable()->default();
            $table->date('due_date')->nullable()->default(new DateTime());
            $table->string('deliverables', 255)->nullable()->default();
            $table->integer('status_id')->unsigned()->nullable()->default(0);
            $table->integer('project_id')->unsigned()->nullable()->default(0);
            $table->string('total_hours', 100)->nullable()->default('0');
            $table->timestamps();
        });

        Schema::create('milestone_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status', 100)->nullable()->default();
            $table->timestamps();
        });

        Schema::create('milestone_costs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100)->nullable()->default();
            $table->text('description')->nullable()->default();
            $table->double('price_per', 15, 2)->nullable()->default(0);
            $table->integer('quantity')->unsigned()->nullable()->default(0);
            $table->double('total_cost', 15, 2)->nullable()->default(0);
            $table->integer('project_id')->unsigned()->nullable()->default(0);
            $table->integer('milesone_id')->unsigned()->nullable()->default(0);
            $table->timestamps();
        });

        Schema::create('milestone_hours', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100)->nullable()->default();
            $table->text('description')->nullable()->default();
            $table->double('price_per', 15, 2)->nullable()->default(0);
            $table->integer('quantity')->unsigned()->nullable()->default(0);
            $table->double('total_cost', 15, 2)->nullable()->default(0);
            $table->integer('project_id')->unsigned()->nullable()->default(0);
            $table->integer('milesone_id')->unsigned()->nullable()->default(0);
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
        Schema::dropIfExists('milestones');
        Schema::dropIfExists('milestone_status');
        Schema::dropIfExists('milestone_costs');
        Schema::dropIfExists('milestone_hours');
    }
}
