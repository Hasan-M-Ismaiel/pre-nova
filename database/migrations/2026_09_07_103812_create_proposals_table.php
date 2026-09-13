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
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();

            $table->string('title');

            $table->string('client_name');
            $table->string('client_email')->nullable();
            $table->string('client_phone')->nullable();

            $table->text('description')->nullable();
            $table->longText('scope')->nullable();
            $table->longText('terms')->nullable();

            $table->decimal('amount', 12, 2)->nullable();

            $table->string('status')->default('draft');

            // Used as an additional secret identifier
            $table->string('token', 64)->unique();

            $table->timestamp('approved_at')->nullable();

            $table->foreignId('project_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
