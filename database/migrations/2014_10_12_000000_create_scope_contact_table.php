<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScopeContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('title', 100)->nullable()->default();
            $table->string('first_name', 100)->nullable()->default();
            $table->string('middle', 100)->nullable()->default();
            $table->string('last_name', 100)->nullable()->default();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('gender', 20)->nullable()->default('male');
            $table->text('occupation')->nullable()->default();
            $table->string('phone', 50)->nullable()->default();
            $table->date('birthday')->nullable()->default();
            $table->text('notes')->nullable()->default();
            $table->integer('client_id')->unsigned()->nullable()->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('website', 100)->nullable()->default();
            $table->string('industry', 100)->nullable()->default();
            $table->string('revenue', 100)->nullable()->default();
            $table->text('description')->nullable()->default();
            $table->string('phone', 50)->nullable()->default();
            $table->text('street1')->nullable()->default();
            $table->text('street2')->nullable()->default();
            $table->string('city', 100)->nullable()->default();
            $table->string('state', 100)->nullable()->default();
            $table->integer('zip')->unsigned()->nullable()->default(0);
            $table->string('country', 100)->nullable()->default();
            $table->text('notes')->nullable()->default();
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
        Schema::dropIfExists('users');
    }
}
