<?php

namespace App\Services;

use App\Model\PayGradeType;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class PayGradeService
{
    public static function getPayGradeTypes(string $newPayGradeType = null, bool $forceReload = false): array
    {
        $newPayGradeType = trim(strtolower($newPayGradeType));

        // If forceReload is true, reset the cache and query the database
        if ($forceReload) {
            Cache::forget('pay_grade_types');
            return self::queryPayGradeTypes($newPayGradeType);
        }

        // Retrieve cached pay grade types
        $payGradeTypes = Cache::get('pay_grade_types', []);

        // If the cache is empty or newPayGradeType needs to be added, query the database
        if (empty($payGradeTypes) || (!empty($newPayGradeType) && !array_key_exists($newPayGradeType, $payGradeTypes))) {
            return self::queryPayGradeTypes($newPayGradeType);
        }

        return $payGradeTypes;
    }

    private static function queryPayGradeTypes(string $newPayGradeType = null): array
    {
        // Fetch all pay grade types from the database and ensure keys are lowercase
        $payGradeTypes = PayGradeType::all()->keyBy(function ($item) {
            return strtolower($item->name); // Ensure the key (name) is in lowercase
        })->map(function ($item) {
            return $item->id;
        })->toArray();

        // If a new pay grade type is provided, check if it exists, otherwise create it
        if (!empty($newPayGradeType)) {
            $existingPayGradeType = PayGradeType::whereRaw('LOWER(name) = ?', [$newPayGradeType])->first();

            if ($existingPayGradeType) {
                $payGradeTypes[$newPayGradeType] = $existingPayGradeType->id;
            } else {
                $newPayGrade = PayGradeType::create(['name' => $newPayGradeType]);
                $payGradeTypes[$newPayGradeType] = $newPayGrade->id;
            }
        }

        // Update the cache with all pay grade types
        Cache::put('pay_grade_types', $payGradeTypes, Carbon::now()->addMinutes(60));

        return $payGradeTypes;
    }

    public static function getPayGradeTypeId(string $payGradeTypeName, bool $forceReload = false): int
    {
        $payGradeTypeName = trim(strtolower($payGradeTypeName));

        // Get pay grade types with cache or force reload
        $payGradeTypes = self::getPayGradeTypes($payGradeTypeName, $forceReload);

        // Return the corresponding ID or 0 if not found
        return $payGradeTypes[$payGradeTypeName] ?? 0;
    }
}
