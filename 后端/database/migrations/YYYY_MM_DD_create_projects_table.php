<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->nullable();
            $table->text('content')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('projects')->onDelete('cascade');
            $table->unsignedBigInteger('responsible_person_id')->nullable(); // 假设有用户系统
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('status')->default('未开始');
            $table->string('priority')->nullable();
            $table->timestamps();

            // 如果有用户表，取消注释
            //$table->foreign('responsible_person_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};