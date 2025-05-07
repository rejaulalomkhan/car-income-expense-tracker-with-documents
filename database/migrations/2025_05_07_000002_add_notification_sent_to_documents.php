<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('car_documents', function (Blueprint $table) {
            $table->boolean('notification_sent')->default(false);
        });

        Schema::table('company_documents', function (Blueprint $table) {
            $table->boolean('notification_sent')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('car_documents', function (Blueprint $table) {
            $table->dropColumn('notification_sent');
        });

        Schema::table('company_documents', function (Blueprint $table) {
            $table->dropColumn('notification_sent');
        });
    }
};
