<?php

namespace App\Http\Helpers\Shared;

class ValidationHelper {

    public const BASIC_NAME_REGEX = "/^[A-Z][a-z]+\s[a-zA-Z\s\.]+/";

    public const STRICT_NAME_REGEX = "/^[A-ZÁÉÍÓÖŐÚÜŰ][a-záéíóöőúüű]{1,}\s[A-ZÁÉÍÓÖŐÚÜŰ][a-záéíóöőúüű]{2,}$/u";

    public const PASSWORD_REGEX = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";



}
