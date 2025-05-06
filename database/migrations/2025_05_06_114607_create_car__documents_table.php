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
        Schema::create('car_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->enum('document_type', [
                'Certificate of Registration',
                'Fitness',
                'Tax Token',
                'Insurance',
                'Route Permit',
                'Branding'
            ])->nullable();
            $table->date('document_expiry_date')->nullable();
            $table->string('document_image')->nullable();
            $table->string('document_comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_documents');
    }
};
