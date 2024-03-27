<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute field must be accepted.',
    'accepted_if' => 'The :attribute field must be accepted when :other is :value.',
    'active_url' => 'The :attribute field must be a valid URL.',
    'after' => 'The :attribute field must be a date after :date.',
    'after_or_equal' => 'The :attribute field must be a date after or equal to :date.',
    'alpha' => 'The :attribute field must only contain letters.',
    'alpha_dash' => 'The :attribute field must only contain letters, numbers, dashes, and underscores.',
    'alpha_num' => 'The :attribute field must only contain letters and numbers.',
    'array' => 'A(z) :attribute mező típusának tömbnek (array) kell lennie.',
    'ascii' => 'The :attribute field must only contain single-byte alphanumeric characters and symbols.',
    'before' => 'The :attribute field must be a date before :date.',
    'before_or_equal' => 'The :attribute field must be a date before or equal to :date.',
    'between' => [
        'array' => 'A(z) :attribute mező tartalma :min és :max elemek száma között lehet.',
        'file' => 'A(z) :attribute mező mérete :min és:max kilobájt között lehet.',
        'numeric' => 'A(z) :attribute mező értéke :min és :max között lehet.',
        'string' => 'A(z) :attribute mező tartalmának hossza :min és :max lehet.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'can' => 'The :attribute field contains an unauthorized value.',
    'confirmed' => 'A(z) :attribute értéke nem egyezik meg a megerősítendő mezővel.',
    'current_password' => 'Érvénytelen jelszó',
    'date' => 'The :attribute field must be a valid date.',
    'date_equals' => 'The :attribute field must be a date equal to :date.',
    'date_format' => 'The :attribute field must match the format :format.',
    'decimal' => 'The :attribute field must have :decimal decimal places.',
    'declined' => 'The :attribute field must be declined.',
    'declined_if' => 'The :attribute field must be declined when :other is :value.',
    'different' => 'A(z) :attribute mező és a(z) :other mező tartalmának különböznie kell.',
    'digits' => 'A(z) :attribute mező tartalma csak :digits számjegyből állhat.',
    'digits_between' => 'A(z) :attribute mező tartalma :min és :max számjegyek között lehet.',
    'dimensions' => 'The :attribute field has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'doesnt_end_with' => 'The :attribute field must not end with one of the following: :values.',
    'doesnt_start_with' => 'The :attribute field must not start with one of the following: :values.',
    'email' => 'A(z) :attribute mező tartalma csak érvényes email cím lehet.',
    'ends_with' => 'The :attribute field must end with one of the following: :values.',
    'enum' => 'The selected :attribute is invalid.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'A(z) :attribute mező tartalmának fájl (file) típusúnak kell lennie.',
    'filled' => 'A(z) :attribute mezőhöz értékadás kötelező.',
    'gt' => [
        'array' => 'The :attribute field must have more than :value items.',
        'file' => 'The :attribute field must be greater than :value kilobytes.',
        'numeric' => 'The :attribute field must be greater than :value.',
        'string' => 'The :attribute field must be greater than :value characters.',
    ],
    'gte' => [
        'array' => 'The :attribute field must have :value items or more.',
        'file' => 'The :attribute field must be greater than or equal to :value kilobytes.',
        'numeric' => 'The :attribute field must be greater than or equal to :value.',
        'string' => 'The :attribute field must be greater than or equal to :value characters.',
    ],
    'image' => 'A(z) :attribute mező értékének képnek (image) kell lennie.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field must exist in :other.',
    'integer' => 'The :attribute field must be an integer.',
    'ip' => 'The :attribute field must be a valid IP address.',
    'ipv4' => 'The :attribute field must be a valid IPv4 address.',
    'ipv6' => 'The :attribute field must be a valid IPv6 address.',
    'json' => 'The :attribute field must be a valid JSON string.',
    'lowercase' => 'The :attribute field must be lowercase.',
    'lt' => [
        'array' => 'The :attribute field must have less than :value items.',
        'file' => 'The :attribute field must be less than :value kilobytes.',
        'numeric' => 'The :attribute field must be less than :value.',
        'string' => 'The :attribute field must be less than :value characters.',
    ],
    'lte' => [
        'array' => 'The :attribute field must not have more than :value items.',
        'file' => 'The :attribute field must be less than or equal to :value kilobytes.',
        'numeric' => 'The :attribute field must be less than or equal to :value.',
        'string' => 'The :attribute field must be less than or equal to :value characters.',
    ],
    'mac_address' => 'The :attribute field must be a valid MAC address.',
    'max' => [
        'array' => 'A(z) :attribute mező tartalma nem lehet több :max elemnél.',
        'file' => 'A(z) :attribute mező mérete nem lehet több :max kilobájtnál.',
        'numeric' => 'A(z) :attribute mező értéke nem lehet több, mint :max.',
        'string' => 'A(z) :attribute mező tartalmának hossza nem lehet több, mint :max.'
    ],
    'max_digits' => 'A(z) :attribute mező tartalma nem lehet több, mint :max számjegy.',
    'mimes' => 'A(z) :attribute mező tartalma csak a következő típusok közül engedélyezett: :values.',
    'mimetypes' => 'A(z) :attribute mező tartalma csak a következő típusok közül engedélyezett: :values.',
    'min' => [
        'array' => 'A(z) :attribute mező tartalma nem lehet kevesebb :min elemnél.',
        'file' => 'A(z) :attribute mező mérete nem lehet kevesebb :min kilobájtnál.',
        'numeric' => 'A(z) :attribute mező értéke nem lehet kevesebb, mint :min.',
        'string' => 'A(z) :attribute mező tartalmának hossza nem lehet kevesebb, mint :min.',
    ],
    'min_digits' => 'A(z) :attribute mező tartalma nem lehet kevesebb, mint :min számjegy.',
    'missing' => 'The :attribute field must be missing.',
    'missing_if' => 'The :attribute field must be missing when :other is :value.',
    'missing_unless' => 'The :attribute field must be missing unless :other is :value.',
    'missing_with' => 'The :attribute field must be missing when :values is present.',
    'missing_with_all' => 'The :attribute field must be missing when :values are present.',
    'multiple_of' => 'The :attribute field must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute field format is invalid.',
    'numeric' => 'A(z) :attribute mező tartalmának szám típusúnak (numeric) kell lennie.',
    'password' => [
        'letters' => 'The :attribute field must contain at least one letter.',
        'mixed' => 'The :attribute field must contain at least one uppercase and one lowercase letter.',
        'numbers' => 'The :attribute field must contain at least one number.',
        'symbols' => 'The :attribute field must contain at least one symbol.',
        'uncompromised' => 'The given :attribute has appeared in a data leak. Please choose a different :attribute.',
    ],
    'present' => 'The :attribute field must be present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => 'A(z) :attribute mező formátuma nem megfelelő.',
    'required' => 'A(z) :attribute mező kitöltése kötelező.',
    'required_array_keys' => 'The :attribute field must contain entries for: :values.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_if_accepted' => 'The :attribute field is required when :other is accepted.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'A(z) :attribute mező tartalmának meg kell egyeznie a(z) :other mező tartalmával',
    'size' => [
        'array' => 'A(z) :attribute mezőnek muszáj tartalmaznia :size számú elemet.',
        'file' => 'A(z) :attribute mezőnek mérete csak :size kilobájt lehet.',
        'numeric' => 'A(z) :attribute mező értéke csak :size lehet',
        'string' => 'A(z) :attribute mező tartalmának hossza csak :size lehet',
    ],
    'starts_with' => 'A(z) :attribute mező tartalma a következő értékekkel kell kezdődnie: :values.',
    'string' => 'A(z) :attribute mező tartalmának szöveges típusúnak (string) kell lennie.',
    'timezone' => 'The :attribute field must be a valid timezone.',
    'unique' => 'Ez a(z) :attribute már foglalt.',
    'uploaded' => 'The :attribute failed to upload.',
    'uppercase' => 'The :attribute field must be uppercase.',
    'url' => 'The :attribute field must be a valid URL.',
    'ulid' => 'The :attribute field must be a valid ULID.',
    'uuid' => 'The :attribute field must be a valid UUID.',
    // 'postal_code' => 'Invalid postal/zip code in the following countries: :countries',
    'postal_code' => 'Érvénytelen irányítószám a következő országokban: :countries',
    'postal_code_with' => 'Érvénytelen irányítószám',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
