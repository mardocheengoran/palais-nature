<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('supplies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 255)->nullable()->unique();
            $table->enum('type', ["entrée","sortie"])->nullable();
            $table->double('price_new', 10, 2)->nullable();
            $table->double('price_old', 10, 2)->nullable();
            $table->double('quantity', 10, 2)->nullable();
            $table->string('title', 255)->nullable();
            $table->string('subtitle', 255)->nullable();
            $table->longText('content')->nullable();
            $table->boolean('status')->nullable();
            $table->foreignId('article_id')->nullable()->constrained('articles')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('agent_id')->nullable()->constrained('users')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('vendor_id')->nullable()->constrained('users')->onDelete('set null')->cascadeOnUpdate();
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
        Schema::dropIfExists('supplies');
    }
}
