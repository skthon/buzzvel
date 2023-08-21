<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_attachments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('task_id')->nullable()->comment('Globally Unique identifier for a task');
            $table->string('filename');
            $table->string('disk');
            $table->string('mime_type');
            $table->string('path');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('task_id')
                ->references('id')->on('tasks')
                ->onDelete('SET NULL')
                ->onUpdate('no action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_attachments');
    }
};
