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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('code', 255)->nullable()->unique();
            $table->string('rank', 255)->nullable();
            $table->string('slug', 255)->nullable()->unique();
            $table->string('lang', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('first_name', 255)->nullable();
            $table->string('email', 255)->nullable()->unique();
            $table->string('pseudo', 255)->nullable()->unique();
            $table->string('phone', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->json('location')->nullable();
            $table->string('occupation', 255)->nullable();
            $table->enum('sex', ["Masculin","Féminin"])->nullable();
            $table->timestamp('birth_at')->nullable();
            $table->string('birth_place', 255)->nullable();
            $table->longText('bio')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255)->nullable();
            $table->rememberToken();
            $table->boolean('status')->nullable();
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('parent_id')->nullable()->constrained('users')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('setting_id')->nullable()->constrained('settings')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('user_created')->nullable()->constrained('users')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('user_updated')->nullable()->constrained('users')->onDelete('set null')->cascadeOnUpdate();

            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();

            $table->softDeletes()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
