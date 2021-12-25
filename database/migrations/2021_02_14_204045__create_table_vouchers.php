<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableVouchers extends Migration
{
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->date('date');
            $table->foreignId('budget_code_id')->constrained();
            $table->string('type');
            $table->string('description');
            $table->string('type_of_transaction');
            $table->foreignId('project_id')->constrained();
            $table->foreignId('budget_cat_code_id')->constrained();
            $table->foreignId('expense_code_id')->constrained();
            $table->bigInteger('amount');
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
        Schema::dropIfExists('vouchers');
    }
}
