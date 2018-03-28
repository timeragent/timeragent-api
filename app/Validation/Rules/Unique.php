<?php

namespace App\Validation\Rules;

use Illuminate\Validation\Rules\Unique as BaseUnique;

class Unique extends BaseUnique
{
    /**
     * The name of the ID column.
     *
     * @var string
     */
    protected $idColumn = 'uuid';
}
