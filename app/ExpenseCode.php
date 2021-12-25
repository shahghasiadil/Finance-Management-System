<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseCode extends Model
{

    protected $fillable = ['name', 'code', 'description', 'type', 'budget_cat_code_id',];
    protected $table = 'budget_expense_codes';
    public function budgetCatCode()
    {
        return $this->belongsTo(BudgetCatCode::class);
    }
    public function allocations()
    {
        return $this->hasMany(Allocation::class);
    }
    public function journals()
    {
        return $this->hasMany(Journal::class);
    }
}
