<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobListingsTable extends Migration
{
    public function up()
    {
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('company_name');
            $table->string('location');
            $table->decimal('salary', 8, 2);
            $table->enum('job_type', ['full-time', 'part-time', 'remote']);
            $table->enum('experience_level', ['junior', 'mid', 'senior']);
            $table->string('industry');
            $table->unsignedBigInteger('user_id');  // Foreign key to users table
            $table->timestamps();

            // Define foreign key relationship
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('job_listings', function (Blueprint $table) {
            $table->string('description')->nullable()->change();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('job_listings');
    }
}