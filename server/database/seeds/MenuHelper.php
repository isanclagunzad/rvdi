<?php


use App\Constants\ModuleConstants;

class MenuHelper
{
    // Method to get the ID of a navigation name with an optional addend
    public static function getIdOf($name, $addend = 0)
    {
        $constantName = strtoupper($name);

        // Check if the constant exists in ModuleConstants
        if (defined('App\Constants\ModuleConstants::' . $constantName)) {
            $id = constant('App\Constants\ModuleConstants::' . $constantName)*100;
            return $id + $addend;
        }

        throw new \Exception("Navigation name '{$name}' not found.");
    }
}
