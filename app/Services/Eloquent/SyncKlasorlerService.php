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
            __('ServiceResponse/Eloquent/SyncKlasorlerService.getAll.success'),
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
                __('ServiceResponse/Eloquent/SyncKlasorlerService.getById.exists'),
                200,
                $syncklasorler
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/SyncKlasorlerService.getById.notFound'),
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
                __('ServiceResponse/Eloquent/SyncKlasorlerService.delete.success'),
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
                __('ServiceResponse/Eloquent/SyncKlasorlerService.getByCompanyId.success'),
                200,
                Syncklasorler::where('FIRMAAPIKEY', $company->APIKEY)->get()
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/SyncKlasorlerService.getByCompanyId.companyNotFound'),
                404,
                null
            );
        }
    }
}
