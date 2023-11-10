<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('code', 255)->nullable()->unique();
            $table->string('rank', 255)->nullable();
            $table->string('slug', 255)->nullable()->unique();
            $table->string('title', 255)->nullable();
            $table->string('subtitle', 255)->nullable();
            $table->string('icon', 255)->nullable();
            $table->longText('content')->nullable();
            $table->string('link', 255)->nullable();
            $table->string('link_video', 255)->nullable();
            $table->text('resume')->nullable();
            $table->string('address', 255)->nullable();
            $table->json('location')->nullable();
            $table->json('other')->nullable();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->timestamp('antidated')->nullable();

            // Pricing
            $table->double('price_buy', 40, 2)->nullable();
            $table->double('price_new', 40, 2)->nullable();
            $table->double('price_old', 40, 2)->nullable();
            $table->double('quantity', 10, 2)->nullable();
            $table->boolean('status')->nullable();
            $table->boolean('enable')->nullable();

            // Bien immobilier
            $table->string('periodicite')->nullable();
            $table->string('surface', 255)->nullable();
            $table->string('number_piece', 255)->nullable(); /* Nombre de pièce */
            $table->string('bathroom', 255)->nullable(); /* Nombre Sale de Bain */
            $table->string('stage', 255)->nullable(); /* Etage */
            //$table->string('equipement', 255)->nullable();
            $table->string('parking', 255)->nullable();

            // Emploi
            $table->string('level', 255)->nullable();
            $table->double('experience', 40, 2)->nullable();
            $table->string('number_job')->nullable();

            // Véhicule
            $table->double('number_place', 40, 2)->nullable();
            $table->double('luggage', 40, 2)->nullable();
            $table->double('door', 40, 2)->nullable();
            $table->string('air_conditioner')->nullable();

            $table->foreignId('city_id')->nullable()->constrained('parameters')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('property_id')->nullable()->constrained('parameters')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('offer_id')->nullable()->constrained('parameters')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('contract_id')->nullable()->constrained('parameters')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('fuel_id')->nullable()->constrained('parameters')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('transmission_id')->nullable()->constrained('parameters')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('brand_id')->nullable()->constrained('parameters')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('available_id')->nullable()->constrained('parameters')->onDelete('set null')->cascadeOnUpdate();

            $table->foreignId('rubric_id')->nullable()->constrained('parameters')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('audience_id')->nullable()->constrained('parameters')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('setting_id')->nullable()->constrained('settings')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('parent_id')->nullable()->constrained('articles')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('user_created')->nullable()->constrained('users')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('user_updated')->nullable()->constrained('users')->onDelete('set null')->cascadeOnUpdate();

            $table->timestamp('published_at')->nullable();
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
        Schema::dropIfExists('articles');
    }
}
