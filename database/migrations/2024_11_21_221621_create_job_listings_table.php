<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('job-list-api', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('company_name');
        $table->string('location');
        $table->decimal('salary', 10, 2);
        $table->text('description');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job-list-api');
    }
};
