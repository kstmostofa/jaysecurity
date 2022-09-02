<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table){
            $table->integer('requested_plan')->default(0)->after('plan_expire_date');
        });

        Schema::create('plan_requests', function (Blueprint $table){
            $table->id();
            $table->integer('user_id');
            $table->integer('plan_id');
            $table->string('duration', 20)->default('monthly');
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
        Schema::dropIfExists('plan_requests');
    }
}
