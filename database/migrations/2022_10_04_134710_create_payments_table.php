<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('code', 255)->nullable()->unique();
            $table->string('moyen', 255)->nullable();
            $table->string('token', 255)->nullable();
            $table->json('content')->nullable();
            $table->double('price_ht', 10, 2)->nullable();
            $table->double('price_tax', 10, 2)->nullable();
            $table->double('price_discount', 10, 2)->nullable();
            $table->double('price_final', 10, 2)->nullable();
            $table->boolean('status')->nullable();
            $table->foreignId('invoice_id')->nullable()->constrained('invoices')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('means_payment_id')->nullable()->constrained('parameters')->onDelete('set null')->cascadeOnUpdate();

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
        Schema::dropIfExists('payments');
    }
}
