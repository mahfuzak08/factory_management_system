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
        if(! Schema::hasTable('device_attendances')) {
            Schema::create('device_attendances', function (Blueprint $table) {
                $table->id();
                $table->string('uid')->comment('device user id');
                $table->string('emp_id')->comment('employee office id');
                $table->string('state')->comment('the authentication type, 1 for Fingerprint, 4 for RF Card etc');
                $table->string('timestamp')->comment('time of attendance');
                $table->string('type'); /* attendance type, like check-in, check-out, overtime-in, overtime-out, break-in & break-out etc. if attendance type is none of them, it gives  255. */
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_attendances');
    }
};
