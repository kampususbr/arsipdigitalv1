<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('work_unit_id')->nullable();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type');
            $table->unsignedBigInteger('file_size');
            $table->string('document_number')->nullable();
            $table->date('document_date')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->enum('visibility', ['public', 'restricted', 'private'])->default('restricted');
            $table->integer('download_count')->default(0);
            $table->integer('view_count')->default(0);
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();
            
            $table->foreign('category_id')->references('id')->on('document_categories')->onDelete('cascade');
            $table->foreign('work_unit_id')->references('id')->on('work_units')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->index('category_id');
            $table->index('work_unit_id');
            $table->index('created_by');
            $table->index('visibility');
            $table->index('created_at');
            $table->fullText(['title', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
