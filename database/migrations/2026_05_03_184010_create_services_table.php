<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('service_name');
            $table->enum('service_type', ['systemd', 'docker', 'nginx', 'php-fpm', 'other'])->default('systemd');
            $table->integer('local_port')->nullable();
            $table->string('config_path')->nullable();
            $table->string('log_hint')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('services'); }
};