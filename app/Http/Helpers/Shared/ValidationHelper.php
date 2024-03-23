<?php

namespace App\Http\Helpers\Shared;

enum ROLES : string {
    case ADMIN = 'Admin';
    case MODERATOR = 'Moderator';
    case SELLER = 'Seller';
    case CUSTOMER = 'Customer';
}

class ValidationHelper {

    public const BASIC_NAME_REGEX = "/^[A-Z][a-z]+\s[a-zA-Z\s\.]+/";

    public const STRICT_NAME_REGEX = "/^[A-ZÁÉÍÓÖŐÚÜŰ][a-záéíóöőúüű]{1,}\s[A-ZÁÉÍÓÖŐÚÜŰ][a-záéíóöőúüű]{2,}$/u";

    public const PASSWORD_REGEX = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";

    public const PHONE_NUMBER_REGEX = "/^([0-9\s\-\+\(\)]*)$/";
}
