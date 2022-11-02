<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Models\Eloquent\Edefterdonemler;
use App\Interfaces\Eloquent\IEDefterDonemlerService;
use App\Models\Eloquent\Firmalar;

class EDefterDonemlerService implements IEDefterDonemlerService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'Edefterdonemler',
            200,
            Edefterdonemler::all()
        );
    }

    /**
     * @param string $id
     *
     * @return ServiceResponse
     */
    public function getById(
        string $id
    ): ServiceResponse
    {
        $eDefterDonemler = Edefterdonemler::where('ID', $id)->where('DURUM', 1)->first();
        if ($eDefterDonemler) {
            return new ServiceResponse(
                true,
                'Edefterdonem',
                200,
                $eDefterDonemler
            );
        } else {
            return new ServiceResponse(
                false,
                'Edefterdonem not found',
                404,
                null
            );
        }
    }

    /**
     * @param string $id
     *
     * @return ServiceResponse
     */
    public function delete(
        string $id
    ): ServiceResponse
    {
        $eDefterDonemler = $this->getById($id);
        if ($eDefterDonemler->isSuccess()) {
            return new ServiceResponse(
                true,
                'Edefterdonemler deleted',
                200,
                $eDefterDonemler->getData()->delete()
            );
        } else {
            return $eDefterDonemler;
        }
    }

    /**
     * @param int $companyId
     * @param string $year
     * @param string $month
     * @param int $typeId
     *
     * @return ServiceResponse
     */
    public function getEDefterDonem(
        int    $companyId,
        string $year,
        string $month,
        int    $typeId
    ): ServiceResponse
    {
        $company = Firmalar::find($companyId);
        if ($company) {
            $eDefterDonem = Edefterdonemler::where('FIRMAAPIKEY', $company->APIKEY)
                ->where('YIL', $year)
                ->where('AY', $month)
                ->where('DEFTERTURKODU', $typeId)
                ->first();
            if ($eDefterDonem) {
                return new ServiceResponse(
                    true,
                    'Edefterdonem',
                    200,
                    $eDefterDonem
                );
            } else {
                return new ServiceResponse(
                    false,
                    'Edefterdonem not found',
                    404,
                    null
                );
            }
        } else {
            return new ServiceResponse(
                false,
                'Company not found',
                404,
                null
            );
        }
    }
}
