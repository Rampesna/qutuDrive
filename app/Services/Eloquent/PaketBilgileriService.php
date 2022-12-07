<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IPaketBilgileriService;
use App\Models\Eloquent\Paketbilgileri;

class PaketBilgileriService implements IPaketBilgileriService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/PaketBilgileriService.getAll.success'),
            200,
            Paketbilgileri::all()
        );
    }
}
