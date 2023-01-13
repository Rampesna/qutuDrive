<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IGibSaklamaOzelListeService;
use App\Models\Eloquent\Firmalar;
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
            __('ServiceResponse/Eloquent/GibSaklamaOzelListeService.getAll.success'),
            200,
            Gibsaklamaozelliste::all()
        );
    }

    /**
     * @param int $companyId
     *
     * @return ServiceResponse
     */
    public function create(
        int $companyId
    ): ServiceResponse
    {
        $company = Firmalar::find($companyId);
        if ($company) {
            $gibSaklamaOzelListe = new Gibsaklamaozelliste;
            $gibSaklamaOzelListe->FIRMAAPIKEY = $company->APIKEY;
            $gibSaklamaOzelListe->VKNTCKN = $company->VKNTCKN;
            $gibSaklamaOzelListe->UNVAN = $company->FIRMAUNVAN;
            $gibSaklamaOzelListe->DURUM = 1;
            $gibSaklamaOzelListe->TARIH = date('Y-m-d H:i:s');
            $gibSaklamaOzelListe->VIP = 1;
            $gibSaklamaOzelListe->save();

            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/GibSaklamaOzelListeService.create.success'),
                200,
                $gibSaklamaOzelListe
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/GibSaklamaOzelListeService.create.companyNotFound'),
                404,
                null
            );
        }
    }
}
