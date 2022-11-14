<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IFirmalarService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse;

    /**
     * @param string $taxNumber
     *
     * @return ServiceResponse
     */
    public function getByTaxNumber(
        string $taxNumber
    ): ServiceResponse;

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
    ): ServiceResponse;
}
