<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('body');
            $table->enum('type', ['todo', 'bug', 'idea', 'deploy', 'security', 'maintenance', 'general'])->default('general');
            $table->boolean('pinned')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('notes'); }
};