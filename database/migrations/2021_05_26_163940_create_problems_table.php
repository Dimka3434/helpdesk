<?php

use App\Models\Problem;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('problems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('subcategory_id');
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('performer_id')->constrained('users', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('description');
            $table->string('place');
            $table->unsignedTinyInteger('status')->default(Problem::STATUS_OPENED);
            $table->string('commentary')->nullable();
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
        Schema::dropIfExists('problems');
    }
}
