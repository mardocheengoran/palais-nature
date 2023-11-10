<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('article_invoice', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->nullable()->constrained('articles')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('invoice_id')->nullable()->constrained('invoices')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null')->cascadeOnUpdate();
            $table->double('price', 10, 2)->nullable();
            $table->double('quantity')->nullable();
            $table->json('options')->nullable(); // Pour enregistrer les couleurs, bonnets, tailles...
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
        Schema::dropIfExists('article_invoice');
    }
}
