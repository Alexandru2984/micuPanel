<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('quick_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('label');
            $table->string('url');
            $table->enum('type', ['public', 'repo', 'docs', 'grafana', 'sentry', 'uptime', 'admin', 'other'])->default('other');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('quick_links'); }
};