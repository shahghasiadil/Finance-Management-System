<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $fillable = ['name', 'code', 'donor', 'location', 'start_date', 'end_date', 'number_of_months', 'total_budget', 'status'];

    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }
}
