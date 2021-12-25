<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('location');
            $table->foreignId('voucher_id')->constrained();
            $table->foreignId('budget_code_id')->constrained();
            $table->foreignId('budget_cat_code_id')->constrained();
            $table->foreignId('expense_code_id')->constrained();
            $table->string('remarks');
            $table->bigInteger('total_expense');
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
        Schema::dropIfExists('journals');
    }
}
