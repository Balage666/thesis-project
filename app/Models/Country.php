<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Country extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'phone_code',
    ];

    public function Phones() : Relation {

        return $this->hasMany(Phone::class, 'country_iso2code', 'iso2code');

    }
}
