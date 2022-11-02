<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Models\Eloquent\Syncdosyahareket;
use App\Interfaces\Eloquent\ISyncDosyaHareketService;

class SyncDosyaHareketService implements ISyncDosyaHareketService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'All Syncdosyahareket',
            200,
            Syncdosyahareket::all()
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
        $syncklasorler = Syncdosyahareket::find($id);
        if ($syncklasorler) {
            return new ServiceResponse(
                true,
                'Syncdosyahareket',
                200,
                $syncklasorler
            );
        } else {
            return new ServiceResponse(
                false,
                'Syncdosyahareket not found',
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
                'Syncdosyahareket deleted',
                200,
                $syncklasorlerResponse->getData()->delete()
            );
        } else {
            return $syncklasorlerResponse;
        }
    }

    /**
     * @param string $sunucuKlasorId
     *
     * @return ServiceResponse
     */
    public function getBySunucuKlasorId(
        string $sunucuKlasorId
    ): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'Syncdosyahareket',
            200,
            Syncdosyahareket::where('SUNUCUKLASORLERID', $sunucuKlasorId)->get()
        );
    }
}
