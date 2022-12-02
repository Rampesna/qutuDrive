<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Models\Eloquent\Backupdosyalar;
use App\Interfaces\Eloquent\IBackupDosyalarService;
use App\Models\Eloquent\Firmalar;

class BackupDosyalarService implements IBackupDosyalarService
{
    /**
     * @param int $companyId
     * @param string|null $keyword
     *
     * @return ServiceResponse
     */
    public function getByCompanyId(
        int     $companyId,
        ?string $keyword = null
    ): ServiceResponse
    {
        $company = Firmalar::find($companyId);
        if ($company) {
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/BackupDosyalarService.getByCompanyId.company.exists'),
                200,
                Backupdosyalar::where('FIRMAAPIKEY', $company->APIKEY)->when($keyword, function ($query) use ($keyword) {
                    return $query->where('VERITABANIADI', 'like', '%' . $keyword . '%')->orWhere('DOSYAADI', 'like', '%' . $keyword . '%');
                })->get()
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/BackupDosyalarService.getByCompanyId.company.notFound'),
                404,
                null
            );
        }
    }
}
