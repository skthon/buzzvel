<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->nullable()->comment('Globally Unique identifier for user');
            $table->string('title')->comment('Task Title');
            $table->text('description')->comment('Task Description');
            $table->boolean('is_completed')->default(false)->comment('Whether the task is completed or not');
            $table->timestamp('completed_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('SET NULL')
                ->onUpdate('no action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
