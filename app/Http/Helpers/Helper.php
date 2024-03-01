<?php

use App\Http\Helpers\Shared\Domains;
use App\Http\Helpers\Shared\SeederHelper;
use App\Http\Helpers\Shared\ValidationHelper;

class Helper {

    public static function GatherStoredDomains() {
        return Domains::STORED_DOMAINS;
    }

    public static function GetUserSeed() {
        return SeederHelper::USER_SEED;
    }

    public function GatherAvailableRoles() {
        return SeederHelper::AVAILABLE_ROLES;
    }

    public static function GetAdminSeed()
    {
        return SeederHelper::ADMIN_SEED_VALUE;
    }

    public static function GetBasicNameRegex()
    {
        return ValidationHelper::BASIC_NAME_REGEX;
    }

    public static function GetStrictNameRegex()
    {
        return ValidationHelper::STRICT_NAME_REGEX;
    }

    public static function GetPasswordRegex()
    {
        return ValidationHelper::PASSWORD_REGEX;
    }

}
?>