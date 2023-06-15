<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IFirmalarService;
use App\Models\Eloquent\Firmalar;
use App\Services\JqxGrid\JqxGridService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class FirmalarService implements IFirmalarService
{
    /**
     * @param mixed $request
     *
     * @return ServiceResponse
     */
    public function jqxGrid(Request $request): ServiceResponse
    {
        $jqxGridService = new JqxGridService(
            'firmalar',
            [
                'ID',
                'DURUM',
                'FIRMAUNVAN',
                'APIKEY',
                'AD',
                'SOYAD',
                'TELEFON',
                'MAIL',
                'VKNTCKN',
                'EDEFTERKAYNAKTURU',
                'KAYITTARIHI'
            ],
            $request
        );

        $jqxGrid = $jqxGridService->jqxGrid();

        return new ServiceResponse(
            true,
            'jqxGrid success',
            200,
            [
                [
                    'TotalRows' => $jqxGrid['TotalRows'],
                    'Rows' => $jqxGrid['Rows']->map(function ($company) {
                        $company->DURUM = $company->DURUM === 1 ? '<span class="badge badge-light-success">AKTİF</span>' : '<span class="badge badge-light-danger">PASİF</span>';
                        return $company;
                    })
                ]
            ]
        );
    }

    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/FirmalarService.getAll.success'),
            200,
            Firmalar::all()
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
        $company = Firmalar::find($id);
        if ($company) {
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/FirmalarService.getById.exists'),
                200,
                $company
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/FirmalarService.getById.notFound'),
                404,
                null
            );
        }
    }

    /**
     * @param int $companyId
     *
     * @return ServiceResponse
     */
    public function getCompanyUsers(
        int $companyId
    ): ServiceResponse
    {
        $company = $this->getById($companyId);
        if ($company->isSuccess()) {
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/FirmalarService.getCompanyUsers.success'),
                200,
                $company->getData()->users
            );
        } else {
            return $company;
        }
    }

    /**
     * @param string $taxNumber
     * @param int|null $exceptId
     *
     * @return ServiceResponse
     */
    public function getByTaxNumber(
        string $taxNumber,
        int    $exceptId = null
    ): ServiceResponse
    {
        $company = Firmalar::where('VKNTCKN', $taxNumber);

        if ($exceptId) {
            $company->where('ID', '!=', $exceptId);
        }

        $company = $company->first();

        if ($company) {
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/FirmalarService.getByTaxNumber.success'),
                200,
                $company
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/FirmalarService.getByTaxNumber.notFound'),
                404,
                null
            );
        }
    }

    /**
     * @param string $email
     * @param int|null $exceptId
     *
     * @return ServiceResponse
     */
    public function getByEmail(
        string $email,
        int    $exceptId = null
    ): ServiceResponse
    {
        $company = Firmalar::where('MAIL', $email);

        if ($exceptId) {
            $company->where('ID', '!=', $exceptId);
        }

        $company = $company->first();

        if ($company) {
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/FirmalarService.getByEmail.success'),
                200,
                $company
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/FirmalarService.getByEmail.notFound'),
                404,
                null
            );
        }
    }

    /**
     * @param string|null $title
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
        ?string $title,
        string  $taxNumber,
        ?string $name,
        ?string $surname,
        ?string $taxOffice,
        ?string $address,
        ?string $phone,
        ?string $email,
        ?string $dealerCode,
        int     $eLedgerSourceType
    ): ServiceResponse
    {
        $checkCompanyByTaxNumber = $this->getByTaxNumber($taxNumber);
        if ($checkCompanyByTaxNumber->isSuccess()) {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/FirmalarService.create.taxNumberExists'),
                400,
                null
            );
        }

//        if ($email) {
//            $checkCompanyByEmail = $this->getByEmail($email);
//            if ($checkCompanyByEmail->isSuccess()) {
//                return new ServiceResponse(
//                    false,
//                    __('ServiceResponse/Eloquent/FirmalarService.create.emailExists'),
//                    400,
//                    null
//                );
//            }
//        }

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
            __('ServiceResponse/Eloquent/FirmalarService.create.success'),
            201,
            $company
        );
    }

    /**
     * @param mixed $file
     *
     * @return ServiceResponse
     */
    public function createBatch(
        mixed $file
    ): ServiceResponse
    {
        $companies = [];
        $companiesFromFile = Excel::toCollection(null, $file);

        foreach ($companiesFromFile[0] as $companyFromFile) {
            if ($companyFromFile[0] === 'VKN/TCKN') {
                continue;
            }

            $checkTaxNumber = Firmalar::where('VKNTCKN', $companyFromFile[0])->first();
            if ($checkTaxNumber) {
                continue;
            }

//            $checkEmail = Firmalar::where('MAIL', $companyFromFile[4])->first();
//            if ($checkEmail) {
//                continue;
//            }

            $companies[] = [
                'VKNTCKN' => $companyFromFile[0],
                'AD' => $companyFromFile[1],
                'SOYAD' => $companyFromFile[2],
                'FIRMAUNVAN' => $companyFromFile[3],
                'MAIL' => $companyFromFile[4],
                'TELEFON' => $companyFromFile[5],
                'VERGIDAIRESI' => $companyFromFile[6],
                'ADRES' => $companyFromFile[7],
                'DURUM' => 1,
                'APIKEY' => Str::uuid()->toString(),
            ];


        }

        Firmalar::insert($companies);

        return new ServiceResponse(
            true,
            'Companies created successfully.',
            201,
            $companies
        );
    }

    /**
     * @param int $id
     * @param string $title
     * @param string $taxNumber
     * @param string|null $name
     * @param string|null $surname
     * @param string|null $taxOffice
     * @param string|null $address
     * @param string|null $phone
     * @param string $email
     * @param string|null $dealerCode
     * @param int|null $eLedgerSourceType
     *
     * @return ServiceResponse
     */
    public function update(
        int     $id,
        string  $title,
        string  $taxNumber,
        ?string $name,
        ?string $surname,
        ?string $taxOffice,
        ?string $address,
        ?string $phone,
        string  $email,
        ?string $dealerCode,
        ?int    $eLedgerSourceType
    ): ServiceResponse
    {
        $company = $this->getById($id);
        if ($company->isSuccess()) {
            $company->getData()->FIRMAUNVAN = $title;
            $company->getData()->VKNTCKN = $taxNumber;
            if ($name) $company->getData()->AD = $name;
            if ($surname) $company->getData()->SOYAD = $surname;
            if ($taxOffice) $company->getData()->VERGIDAIRESI = $taxOffice;
            if ($address) $company->getData()->ADRES = $address;
            if ($phone) $company->getData()->TELEFON = $phone;
            $company->getData()->MAIL = $email;
            $company->getData()->BAYIKODU = $dealerCode;
            $company->getData()->DURUM = 1;
            if ($eLedgerSourceType) $company->getData()->EDEFTERKAYNAKTURU = $eLedgerSourceType;
            $company->getData()->save();

            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/FirmalarService.update.success'),
                200,
                $company->getData()
            );
        } else {
            return $company;
        }
    }

    /**
     * @param int $companyId
     * @param int $userId
     *
     * @return ServiceResponse
     */
    public function detachCompanyUser(
        int $companyId,
        int $userId
    ): ServiceResponse
    {
        $company = $this->getById($companyId);
        if ($company->isSuccess()) {
            $company->getData()->users()->detach($userId);
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/FirmalarService.detachCompanyUser.success'),
                200,
                null
            );
        } else {
            return $company;
        }
    }

    /**
     * @param int $companyId
     *
     * @return ServiceResponse
     */
    public function delete(
        int $companyId
    ): ServiceResponse
    {
        $company = $this->getById($companyId);
        if ($company->isSuccess()) {
            $company->getData()->DURUM = 2;
            $company->getData()->save();
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/FirmalarService.delete.success'),
                200,
                null
            );
        } else {
            return $company;
        }
    }
}
