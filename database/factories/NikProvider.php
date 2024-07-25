<?php

namespace Database\Factories;

use Faker\Provider\Base;

class NikProvider extends Base
{
    public function nik()
    {
        return $this->generator->numerify('###########'); // 11 digit angka
    }
}
