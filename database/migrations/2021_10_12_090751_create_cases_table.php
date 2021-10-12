<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasesTable extends Migration
{   
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->boolean('public')->default(false);
            $table->boolean('required_testing')->default(false);
            $table->boolean('required_approval')->default(false);
            $table->foreignId('status_id')->constrained('statuses')->nullable();
            $table->foreignId('category_id')->constrained('categories')->nullable();
            $table->foreignId('type_id')->constrained('types')->nullable();
            $table->foreignId('priority_id')->constrained('priorities')->nullable();
            $table->foreignId('change_impact_id')->constrained('change_impacts')->nullable();
            $table->float('sla')->nullable();
            $table->foreignId('project_id')->constrained('projects');
            $table->foreignId('tester_id')->constrained('users')->nullable();
            $table->foreignId('customer_id')->constrained('users');
            $table->foreignId('agent_id')->constrained('users')->nullable();
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
        Schema::dropIfExists('cases');
    }
}
