<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
        CREATE VIEW IF NOT EXISTS attendance_view AS
        SELECT
            `date`,
            `emp_id`,
            (CASE 
                WHEN TIMESTAMPDIFF(HOUR, `intime`, `outtime`) > 8 THEN 1
                WHEN TIMESTAMPDIFF(HOUR, `intime`, `outtime`) >= 4 AND TIMESTAMPDIFF(HOUR, `intime`, `outtime`) <= 8 THEN 0.5
                ELSE 0
            END) AS day_count
        FROM
            `attendances`;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS attendance_view;');
    }
};
