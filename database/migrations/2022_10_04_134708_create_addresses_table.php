<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('code', 255)->nullable()->unique();
            $table->string('rank', 255)->nullable();
            $table->string('slug', 255)->nullable()->unique();
            $table->string('title', 255)->nullable();
            $table->string('subtitle', 255)->nullable();
            $table->json('location')->nullable();
            $table->longText('content')->nullable();
            $table->boolean('status')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('city_id')->nullable()->constrained('parameters')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('setting_id')->nullable()->constrained('settings')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('user_created')->nullable()->constrained('users')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('user_updated')->nullable()->constrained('users')->onDelete('set null')->cascadeOnUpdate();
            $table->softDeletes()->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
