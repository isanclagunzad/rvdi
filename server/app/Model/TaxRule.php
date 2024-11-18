<?php

namespace App\Model;

class TaxRule extends BaseModel
{
    protected $table = 'tax_rule';
    protected $primaryKey = 'tax_rule_id';

    protected $fillable = [
        'tax_rule_id',
        'min_income_bracket',
        'max_income_bracket',
        'base_amount',
        'tax',
        'gender'
    ];
}
