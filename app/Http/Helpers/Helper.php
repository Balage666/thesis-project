<?php

use App\Http\Helpers\Shared\Domains;
use App\Http\Helpers\Shared\ROLES;
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

    public function GatherCategories() {
        return SeederHelper::BASE_CATEGORIES;
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

    public static function GetAdminRole() {
        return ROLES::ADMIN->value;
    }

}
?>
