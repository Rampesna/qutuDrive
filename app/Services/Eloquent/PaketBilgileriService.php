<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IPaketBilgileriService;
use App\Models\Eloquent\Paketbilgileri;

class PaketBilgileriService implements IPaketBilgileriService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/PaketBilgileriService.getAll.success'),
            200,
            Paketbilgileri::all()
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
        $package = Paketbilgileri::find($id);
        if ($package) {
            return new ServiceResponse(
                true,
                'paketbilgileri.getById.success',
                200,
                $package
            );
        } else {
            return new ServiceResponse(
                false,
                'paketbilgileri.getById.notFound',
                404,
                null
            );
        }
    }

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
    ): ServiceResponse
    {
        $package = new Paketbilgileri;
        $package->BAYIKODU = $dealerCode;
        $package->PAKETKODU = $code;
        $package->PAKETADI = $name;
        $package->PAKETBOYUTU = $size;
        $package->PAKETFIYATI = $price;
        $package->DURUM = $status;
        $package->save();

        return new ServiceResponse(
            true,
            'paketbilgileri.create.success',
            201,
            $package
        );
    }


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
    ): ServiceResponse
    {
        $package = $this->getById($id);
        if ($package->isSuccess()) {
            $package = $package->getData();
            $package->BAYIKODU = $dealerCode;
            $package->PAKETKODU = $code;
            $package->PAKETADI = $name;
            $package->PAKETBOYUTU = $size;
            $package->PAKETFIYATI = $price;
            $package->DURUM = $status;
            $package->save();

            return new ServiceResponse(
                true,
                'paketbilgileri.update.success',
                200,
                $package
            );
        } else {
            return $package;
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
        $package = $this->getById($id);
        if ($package->isSuccess()) {
            $package = $package->getData();
            $package->delete();

            return new ServiceResponse(
                true,
                'paketbilgileri.delete.success',
                200,
                $package
            );
        } else {
            return $package;
        }
    }
}
