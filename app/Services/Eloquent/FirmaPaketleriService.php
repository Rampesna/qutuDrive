<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IFirmaPaketleriService;
use App\Models\Eloquent\Firmalar;
use App\Models\Eloquent\Firmapaketleri;

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
                'Company packages',
                200,
                $company->packages
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
                'Company package',
                200,
                $companyPackage
            );
        } else {
            return new ServiceResponse(
                false,
                'Company package not found',
                404,
                null
            );
        }
    }

    /**
     * @param int $companyId
     * @param string $packageCode
     * @param string $packageName
     * @param string $packageSize
     * @param string $packagePrice
     * @param string $startDate
     * @param string $endDate
     * @param int $status
     * @param int $paymentType
     *
     * @return ServiceResponse
     */
    public function create(
        int    $companyId,
        string $packageCode,
        string $packageName,
        string $packageSize,
        string $packagePrice,
        string $startDate,
        string $endDate,
        int    $status,
        int    $paymentType
    ): ServiceResponse
    {
        $company = Firmalar::find($companyId);
        if ($company) {
            $companyPackage = new Firmapaketleri;
            $companyPackage->FIRMAAPIKEY = $company->APIKEY;
            $companyPackage->PAKETKODU = $packageCode;
            $companyPackage->PAKETADI = $packageName;
            $companyPackage->PAKETBOYUTU = $packageSize;
            $companyPackage->PAKETFIYATI = $packagePrice;
            $companyPackage->BASLANGICTARIHI = $startDate;
            $companyPackage->BITISTARIHI = $endDate;
            $companyPackage->DURUM = $status;
            $companyPackage->ODEMESEKLI = $paymentType;
            $companyPackage->save();

            return new ServiceResponse(
                true,
                'Company package created',
                201,
                $companyPackage
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
                'Company package deleted',
                200,
                $companyPackage->getData()->delete()
            );
        } else {
            return $companyPackage;
        }
    }
}
