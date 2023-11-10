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
        Schema::create('devis', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->string('entreprise')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('nature')->nullable();
            $table->string('hscode')->nullable();
            $table->string('poids')->nullable();
            $table->string('shipping')->nullable();
            $table->string('conteneur')->nullable();
            $table->string('port')->nullable();
            $table->string('enlevement')->nullable();
            $table->string('dechargement')->nullable();
            $table->string('livraison')->nullable();
            $table->longText('commentaire')->nullable();

            $table->foreignId('user_created')->nullable()->constrained('users')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('user_updated')->nullable()->constrained('users')->onDelete('set null')->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devis');
    }
};
