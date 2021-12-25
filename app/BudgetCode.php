<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetCode extends Model
{
    //
    protected $fillable = ['name', 'code', 'description', 'type'];

    public function budgetcatcodes()
    {
        return $this->hasMany(BudgetCatCode::class);
    }
    public function journals()
    {
        return $this->hasMany(Journal::class);
    }
}
