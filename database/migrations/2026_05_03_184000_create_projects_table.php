<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('public_url')->nullable();
            $table->string('primary_domain')->nullable();
            $table->string('repository_url')->nullable();
            $table->string('local_path')->nullable();
            $table->string('stack')->nullable();
            $table->enum('status', ['active', 'paused', 'broken', 'archived', 'experimental'])->default('active');
            $table->enum('environment', ['production', 'staging', 'demo', 'local'])->default('production');
            $table->string('provider')->nullable();
            $table->integer('local_port')->nullable();
            $table->string('systemd_service_name')->nullable();
            $table->string('nginx_config_path')->nullable();
            $table->string('database_type')->nullable();
            $table->text('notes')->nullable();
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->timestamp('last_deployed_at')->nullable();
            $table->timestamp('last_checked_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('projects'); }
};