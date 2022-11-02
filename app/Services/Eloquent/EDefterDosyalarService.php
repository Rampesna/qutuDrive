<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Models\Eloquent\Edefterdosyalar;
use App\Interfaces\Eloquent\IEDefterDosyalarService;

class EDefterDosyalarService implements IEDefterDosyalarService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'Edefterdosyalar',
            200,
            Edefterdosyalar::all()
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
        $eDefterDosyalar = Edefterdosyalar::where('ID', $id)->where('DURUM', 1)->first();
        if ($eDefterDosyalar) {
            return new ServiceResponse(
                true,
                'Edefterdosya',
                200,
                $eDefterDosyalar
            );
        } else {
            return new ServiceResponse(
                false,
                'Edefterdosya not found',
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
        $eDefterDosyalar = $this->getById($id);
        if ($eDefterDosyalar->isSuccess()) {
            return new ServiceResponse(
                true,
                'Edefterdosya deleted',
                200,
                $eDefterDosyalar->getData()->delete()
            );
        } else {
            return $eDefterDosyalar;
        }
    }

    /**
     * @param string $donemId
     *
     * @return ServiceResponse
     */
    public function getByDonemId(
        string $donemId
    ): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'Edefterdosyalar',
            200,
            Edefterdosyalar::where('DONEMLERID', $donemId)->get()
        );
    }
}
