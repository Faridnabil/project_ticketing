<?php

namespace Database\Factories;

use Faker\Provider\Base;

class NipProvider extends Base
{
    public function nip()
    {
        return $this->generator->numerify('###########'); // 11 digit angka
    }
}
