<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\ISyncKlasorlerService;
use App\Models\Eloquent\Firmalar;
use App\Models\Eloquent\Syncklasorler;

class SyncKlasorlerService implements ISyncKlasorlerService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'All syncklasorler',
            200,
            Syncklasorler::all()
        );
    }

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function getById(
        int $id
    ): ServiceResponse
    {
        $syncklasorler = Syncklasorler::find($id);
        if ($syncklasorler) {
            return new ServiceResponse(
                true,
                'Syncklasorler',
                200,
                $syncklasorler
            );
        } else {
            return new ServiceResponse(
                false,
                'Syncklasorler not found',
                404,
                null
            );
        }
    }

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function delete(
        int $id
    ): ServiceResponse
    {
        $syncklasorlerResponse = $this->getById($id);
        if ($syncklasorlerResponse->isSuccess()) {
            return new ServiceResponse(
                true,
                'Syncklasorler deleted',
                200,
                $syncklasorlerResponse->getData()->delete()
            );
        } else {
            return $syncklasorlerResponse;
        }
    }

    /**
     * @param int $companyId
     *
     * @return ServiceResponse
     */
    public function getByCompanyId(
        int $companyId
    ): ServiceResponse
    {
        $company = Firmalar::find($companyId);
        if ($company) {
            return new ServiceResponse(
                true,
                'Syncklasorler',
                200,
                Syncklasorler::where('FIRMAAPIKEY', $company->APIKEY)->get()
            );
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
