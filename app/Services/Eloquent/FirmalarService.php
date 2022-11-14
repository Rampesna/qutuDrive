<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IFirmalarService;
use App\Models\Eloquent\Firmalar;
use Illuminate\Support\Str;

class FirmalarService implements IFirmalarService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'All companies',
            200,
            Firmalar::all()
        );
    }

    /**
     * @param string $taxNumber
     *
     * @return ServiceResponse
     */
    public function getByTaxNumber(
        string $taxNumber
    ): ServiceResponse
    {
        $company = Firmalar::where('VKNTCKN', $taxNumber)->first();
        if ($company) {
            return new ServiceResponse(
                false,
                'Company',
                200,
                $company
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
     * @param string $title
     * @param string $taxNumber
     * @param string|null $name
     * @param string|null $surname
     * @param string|null $taxOffice
     * @param string|null $address
     * @param string|null $phone
     * @param string $email
     * @param string|null $dealerCode
     * @param int $eLedgerSourceType
     *
     * @return ServiceResponse
     */
    public function create(
        string  $title,
        string  $taxNumber,
        ?string $name,
        ?string $surname,
        ?string $taxOffice,
        ?string $address,
        ?string $phone,
        string  $email,
        ?string $dealerCode,
        int     $eLedgerSourceType
    ): ServiceResponse
    {
        $company = new Firmalar;
        $company->APIKEY = Str::uuid();
        $company->FIRMAUNVAN = $title;
        $company->VKNTCKN = $taxNumber;
        $company->AD = $name;
        $company->SOYAD = $surname;
        $company->VERGIDAIRESI = $taxOffice;
        $company->ADRES = $address;
        $company->TELEFON = $phone;
        $company->MAIL = $email;
        $company->BAYIKODU = $dealerCode;
        $company->DURUM = 1;
        $company->EDEFTERKAYNAKTURU = $eLedgerSourceType;
        $company->KAYITTARIHI = date('Y-m-d H:i:s');
        $company->save();

        return new ServiceResponse(
            true,
            'Company created',
            201,
            $company
        );
    }
}
