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
        Schema::create('admin_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('admin_prodis', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('admin_roles_id');
            $table->unsignedBigInteger('admin_prodis_id');
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('admin_roles_id')->references('id')->on('admin_roles');
            $table->foreign('admin_prodis_id')->references('id')->on('admin_prodis');
        });

        Schema::create('admin_menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('admin_sub_menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_menus_id');
            $table->string('name');
            $table->string('url');
            $table->string('icon');
            $table->timestamps();

            $table->foreign('admin_menus_id')->references('id')->on('admin_menus');
        });

        Schema::create('admin_access_menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_roles_id');
            $table->unsignedBigInteger('admin_menus_id');
            $table->timestamps();

            $table->foreign('admin_roles_id')->references('id')->on('admin_roles');
            $table->foreign('admin_menus_id')->references('id')->on('admin_menus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('admins', function (Blueprint $table) {
        //     // $table->dropForeign('users_id');
        //     $table->dropForeign('admin_roles_id');
        //     $table->dropForeign('admin_prodis_id');
        // });
        // Schema::table('admin_sub_menus', function (Blueprint $table) {
        //     $table->dropForeign('admin_menus_id');
        // });
        // Schema::table('admin_access_menus', function (Blueprint $table) {
        //     $table->dropForeign('admin_menus_id');
        //     $table->dropForeign('admin_roles_id');
        // });
        Schema::dropIfExists('admins');
        Schema::dropIfExists('admin_sub_menus');
        Schema::dropIfExists('admin_access_menus');
        Schema::dropIfExists('admin_menus');
        Schema::dropIfExists('admin_roles');
        Schema::dropIfExists('admin_prodis');
    }
};
