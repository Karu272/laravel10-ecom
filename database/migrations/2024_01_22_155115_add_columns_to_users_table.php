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
        Schema::table('users', function (Blueprint $table) {
            $table->string('address')->after('name');
            $table->string('city')->after('address');
            $table->string('state')->after('city');
            $table->string('country')->after('state');
            $table->string('zip')->after('country');
            $table->string('phone')->after('zip');
            $table->tinyInteger('status')->after('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('country');
            $table->dropColumn('zip');
            $table->dropColumn('phone');
            $table->dropColumn('status');
        });
    }
};
