<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = ['number', 'budget_code_id', 'description', 'type_of_transaction', 'project_id', 'budget_cat_code_id', 'expense_code_id', 'amount'];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function budgetCatCode()
    {
        return $this->belongsTo(BudgetCatCode::class);
    }
    public function expenseCode()
    {
        return $this->belongsTo(ExpenseCode::class);
    }
    public function journals()
    {
        return $this->hasMany(Journal::class);
    }
    public function budgetCode()
    {
        return $this->belongsTo(BudgetCode::class);
    }
}
