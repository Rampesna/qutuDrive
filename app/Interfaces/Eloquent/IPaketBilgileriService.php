<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IPaketBilgileriService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse;

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function getById(
        int $id
    ): ServiceResponse;

    /**
     * @param string|null $dealerCode
     * @param string|null $code
     * @param string|null $name
     * @param string|null $size
     * @param string|null $price
     * @param boolean|null $status
     *
     * @return ServiceResponse
     */
    public function create(
        ?string $dealerCode = null,
        ?string $code = null,
        ?string $name = null,
        ?string $size = null,
        ?string $price = null,
        ?bool   $status = null
    ): ServiceResponse;


    /**
     * @param int $id
     * @param string|null $dealerCode
     * @param string|null $code
     * @param string|null $name
     * @param string|null $size
     * @param string|null $price
     * @param boolean|null $status
     *
     * @return ServiceResponse
     */
    public function update(
        int     $id,
        ?string $dealerCode = null,
        ?string $code = null,
        ?string $name = null,
        ?string $size = null,
        ?string $price = null,
        ?bool   $status = null
    ): ServiceResponse;

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function delete(
        int $id
    ): ServiceResponse;
}
