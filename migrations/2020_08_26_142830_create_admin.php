<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;
use Hyperf\DbConnection\Db;

class CreateAdmin extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->string('username', 100)->unique()->comment('登录账号');
            $table->string('password')->comment('登录密码');
            $table->string('nickname', 20)->nullable()->comment('账号姓名');
            $table->string('avatar')->nullable()->commnet('头像');
            $table->string('phone', 100)->nullable()->unique()->comment('手机号');
            $table->string('email', 100)->nullable()->unique()->comment('账号邮箱');
            $table->unsignedTinyInteger('status')->default(1)->comment('账号状态，0关闭，1正常');
            $table->unsignedTinyInteger('is_admin')->default(0)->comment('是否总管理，0不是，1是');
            $table->timestamps();
            $table->softDeletes();
        });
        Db::statement("ALTER TABLE `admin` comment'后台用户表'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
}
