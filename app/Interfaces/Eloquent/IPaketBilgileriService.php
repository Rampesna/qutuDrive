<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IPaketBilgileriService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse;
}
