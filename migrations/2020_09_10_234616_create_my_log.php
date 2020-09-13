<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateMyLog extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('my_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('log_type', 100)->unique()->comment('日志类型');
            $table->string('key')->comment('日志键1');
            $table->string('val1')->comment('日志值');
            $table->string('val2')->comment('日志值');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_log');
    }
}
