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
        if(! Schema::hasColumns('employees', ['designation'])) {
            Schema::table('employees', function (Blueprint $table) {
                $table->string('designation')->default('Employee')->after('gender');
                $table->string('total_paid')->nullable()->after('designation');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('designation');
            $table->dropColumn('total_paid');
        });
    }
};
