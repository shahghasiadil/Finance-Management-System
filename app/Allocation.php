<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Allocation extends Model
{
    //
    protected $fillable = ['project_id', 'budget_code_id', 'expense_code_id', 'budget_cat_code_id', 'unit', 'number_of_activities', 'unit_cost', 'quantity'];
    public function project()
    {
        return $this->belongsTo(Project::class);
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
