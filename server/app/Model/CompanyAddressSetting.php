<?php

namespace App\Model;

class CompanyAddressSetting extends BaseModel
{
    protected $table = 'company_address_settings';
    protected $primaryKey = 'company_address_setting_id';

    protected $fillable = [
        'company_address_setting_id', 'address'
    ];
}
