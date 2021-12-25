<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = ['date', 'location', 'voucher_id', 'budget_code_id', 'budget_cat_code_id', 'expense_code_id', 'remarks', 'total_expense'];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
    public function budgetCode()
    {
        return $this->belongsTo(BudgetCode::class);
    }

    public function budgetCatCode()
    {
        return $this->belongsTo(BudgetCatCode::class);
    }

    public function expenseCode()
    {
        return $this->belongsTo(ExpenseCode::class);
    }
}
