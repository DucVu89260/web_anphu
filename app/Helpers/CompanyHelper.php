<?php

namespace App\Helpers;

use App\Models\CompanySetting;

class CompanyHelper
{
    private static $companySetting = null;

    /**
     * Lấy thông tin công ty từ database với cache
     */
    public static function getCompanySetting()
    {
        if (self::$companySetting === null) {
            self::$companySetting = CompanySetting::first();
        }
        
        return self::$companySetting;
    }
}
