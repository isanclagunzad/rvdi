<?php

namespace App\Model;

class PrintHeadSetting extends BaseModel
{
    protected $table = 'print_head_settings';
    protected $primaryKey = 'print_head_setting_id';

    protected $fillable = [
        'print_head_setting_id', 'description'
    ];
}
