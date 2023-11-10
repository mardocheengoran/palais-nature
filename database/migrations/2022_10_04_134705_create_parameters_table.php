<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('parameters', function (Blueprint $table) {
            $table->id();
            $table->string('code', 255)->nullable()->unique();
            $table->string('rank', 255)->nullable();
            $table->string('slug', 255)->nullable()->unique();
            $table->string('title', 255)->nullable();
            $table->string('subtitle', 255)->nullable();
            $table->string('icon', 255)->nullable();
            $table->string('class', 255)->nullable();
            $table->string('color', 255)->nullable();
            $table->longText('content')->nullable();
            $table->string('address', 255)->nullable();
            $table->json('location')->nullable();

            $table->string('component')->nullable();
            $table->string('component_detail')->nullable();
            $table->json('field')->nullable();
            $table->string('column')->nullable();

            $table->string('link')->nullable();
            $table->boolean('submenu')->nullable(); // Est t'il sous menu ou pas
            $table->boolean('ecommerce')->nullable(); // Est t'il un menu ecommerce dans ce cas il listera les categories et sous categories
            $table->foreignId('link_id')->nullable()->constrained('parameters')->onDelete('set null')->cascadeOnUpdate(); // lien dynamique vers un parametre
            $table->foreignId('link_article_id')->nullable()->constrained('articles')->onDelete('set null')->cascadeOnUpdate(); // Lien dynamique vers un article
            $table->foreignId('item_type_parameter_id')->nullable()->constrained('type_parameters')->onDelete('set null')->cascadeOnUpdate(); // peut lister par exemple Commune, Mode de paiement, Rubrique, Categorie ...
            $table->foreignId('item_rubric_id')->nullable()->constrained('parameters')->onDelete('set null')->cascadeOnUpdate(); // Peut lister des articles d'une rubrique : service, actualité, blog

            $table->boolean('status')->nullable();
            $table->foreignId('type_parameter_id')->nullable()->constrained('type_parameters')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('parent_id')->nullable()->constrained('parameters')->onDelete('set null')->cascadeOnUpdate();
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
        Schema::dropIfExists('parameters');
    }
}
