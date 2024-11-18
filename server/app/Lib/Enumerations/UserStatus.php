<?php
namespace App\Lib\Enumerations;

class UserStatus
{
     public static $ACTIVE = 1;
     public static $INACTIVE = 2;
     public static $TERMINATED = 3;
     public static $PROBATION_PERIOD  = 0;
     public static $PERMANENT  = 1;
     public static $RESIGNED = 4;
}