<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('responsible_person_id')->nullable(); // 假设有用户系统
            $table->date('due_date')->nullable();
            $table->string('status')->default('待处理');
            $table->string('priority')->nullable();
            $table->timestamps();

            // 如果有用户表，取消注释
            //$table->foreign('responsible_person_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};