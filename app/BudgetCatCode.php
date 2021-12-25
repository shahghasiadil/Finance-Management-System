<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetCatCode extends Model
{
    //
    protected $fillable = ['name', 'code', 'description', 'type', 'budget_code_id'];
    public function budgetCode()
    {
        return $this->belongsTo(BudgetCode::class);
    }

    public function journals()
    {
        return $this->hasMany(Journal::class);
    }
}
