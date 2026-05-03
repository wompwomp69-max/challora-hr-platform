<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_candidate_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->cascadeOnDelete();
            $table->json('pros_json')->nullable();
            $table->json('cons_json')->nullable();
            $table->text('summary_text')->nullable();
            $table->string('recommendation')->nullable();
            $table->string('model_version')->nullable();
            $table->string('status')->default('pending');
            $table->text('error_message')->nullable();
            $table->timestamp('generated_at')->nullable();
            $table->timestamps();

            $table->unique('application_id');
            $table->index(['generated_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_candidate_summaries');
    }
};
