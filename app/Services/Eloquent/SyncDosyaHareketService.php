<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Models\Eloquent\Firmalar;
use App\Models\Eloquent\Syncdosyahareket;
use App\Interfaces\Eloquent\ISyncDosyaHareketService;
use Illuminate\Support\Facades\DB;

class SyncDosyaHareketService implements ISyncDosyaHareketService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/SyncDosyaHareketService.getAll.success'),
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
                __('ServiceResponse/Eloquent/SyncDosyaHareketService.getById.exists'),
                200,
                $syncklasorler
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/SyncDosyaHareketService.getById.notFound'),
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
                __('ServiceResponse/Eloquent/SyncDosyaHareketService.delete.success'),
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
            __('ServiceResponse/Eloquent/SyncDosyaHareketService.getBySunucuKlasorId.success'),
            200,
            Syncdosyahareket::where('SUNUCUKLASORLERID', $sunucuKlasorId)->get()
        );
    }

    /*
     * return ServiceResponse
     * */
    public function getUsage(
        int $companyId
    ): ServiceResponse
    {
        $company = Firmalar::find($companyId);
        $usage = DB::select("
        SELECT SUM(DOSYABOYUTU) AS SyncDosyaHareketUsage FROM syncdosyahareket WHERE FIRMAAPIKEY='$company->APIKEY' AND DURUM=1
        ");

        return new ServiceResponse(
            true,
            'syncdosyahareket usage',
            200,
            $usage
        );
    }

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function getByUuId(
        string $id
    ): ServiceResponse
    {
        $syncklasorler = Syncdosyahareket::where('ID', $id)->first();
        if ($syncklasorler) {
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/SyncDosyaHareketService.getById.exists'),
                200,
                $syncklasorler
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/SyncDosyaHareketService.getById.notFound'),
                404,
                null
            );
        }
    }
}
