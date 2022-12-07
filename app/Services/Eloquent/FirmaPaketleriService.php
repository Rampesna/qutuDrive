<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IFirmaPaketleriService;
use App\Models\Eloquent\Firmalar;
use App\Models\Eloquent\Firmapaketleri;
use App\Models\Eloquent\Paketbilgileri;

class FirmaPaketleriService implements IFirmaPaketleriService
{
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
                __('ServiceResponse/Eloquent/FirmaPaketleriService.getByCompanyId.success'),
                200,
                $company->packages
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/FirmaPaketleriService.getByCompanyId.companyNotFound'),
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
    public function getById(
        int $id
    ): ServiceResponse
    {
        $companyPackage = Firmapaketleri::find($id);
        if ($companyPackage) {
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/FirmaPaketleriService.getById.exists'),
                200,
                $companyPackage
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/FirmaPaketleriService.getById.notFound'),
                404,
                null
            );
        }
    }

    /**
     * @param int $companyId
     * @param int $packageId
     * @param float $packagePrice
     * @param string $startDate
     * @param string $endDate
     * @param int $status
     * @param int $paymentType
     *
     * @return ServiceResponse
     */
    public function create(
        int    $companyId,
        int    $packageId,
        float  $packagePrice,
        string $startDate,
        string $endDate,
        int    $status,
        int    $paymentType
    ): ServiceResponse
    {
        $company = Firmalar::find($companyId);
        if ($company) {
            $package = Paketbilgileri::find($packageId);
            if ($package) {
                $companyPackage = new Firmapaketleri;
                $companyPackage->FIRMAAPIKEY = $company->APIKEY;
                $companyPackage->PAKETKODU = $package->PAKETKODU;
                $companyPackage->PAKETADI = $package->PAKETADI;
                $companyPackage->PAKETBOYUTU = $package->PAKETBOYUTU;
                $companyPackage->PAKETFIYATI = $packagePrice;
                $companyPackage->BASLANGICTARIHI = $startDate;
                $companyPackage->BITISTARIHI = $endDate;
                $companyPackage->DURUM = $status;
                $companyPackage->ODEMESEKLI = $paymentType;
                $companyPackage->save();

                return new ServiceResponse(
                    true,
                    __('ServiceResponse/Eloquent/FirmaPaketleriService.create.success'),
                    201,
                    $companyPackage
                );
            } else {
                return new ServiceResponse(
                    false,
                    __('ServiceResponse/Eloquent/FirmaPaketleriService.create.packageNotFound'),
                    404,
                    null
                );
            }
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/FirmaPaketleriService.create.companyNotFound'),
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
        $companyPackage = $this->getById($id);
        if ($companyPackage->isSuccess()) {
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/FirmaPaketleriService.delete.success'),
                200,
                $companyPackage->getData()->delete()
            );
        } else {
            return $companyPackage;
        }
    }
}
