<?php

namespace App\Constants;

final class ModuleConstants {
    public const ADMINISTRATION = 1;
    public const EMPLOYEES = 2;
    public const LEAVES = 3;
    public const ATTENDANCE = 4;
    public const PAYROLL = 5;
    public const PERFORMANCE = 6;
    public const RECRUITMENT = 7;
    public const TRAINING = 8;
    public const AWARD = 9;
    public const NOTICE_BOARD = 10;
    public const SETTINGS = 11;

    // Prevent instantiation of this class
    private function __construct() {}

    public static function isValidValue($value): bool {
        $values = (new \ReflectionClass(static::class))->getConstants();
        return in_array($value, $values, true);
    }

    public static function getValues(): array {
        return array_values((new \ReflectionClass(static::class))->getConstants());
    }
}
