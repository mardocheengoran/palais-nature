<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->foreignId('supplier_id')->nullable()->constrained('users')->onDelete('set null')->cascadeOnUpdate();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('store')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('supplier_id');
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('store');
        });
    }
};
