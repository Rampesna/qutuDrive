<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IGibSaklamaOzelListeService;
use App\Models\Eloquent\Gibsaklamaozelliste;

class GibSaklamaOzelListeService implements IGibSaklamaOzelListeService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'All gib backup special list',
            200,
            Gibsaklamaozelliste::all()
        );
    }
}
