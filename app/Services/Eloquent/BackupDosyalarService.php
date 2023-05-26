<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Models\Eloquent\Backupdosyalar;
use App\Interfaces\Eloquent\IBackupDosyalarService;
use App\Models\Eloquent\Firmalar;
use Illuminate\Support\Facades\DB;

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

    /*
     * return ServiceResponse
     * */
    public function getUsage(
        int $companyId
    ): ServiceResponse
    {
        $company = Firmalar::find($companyId);
        $usage = DB::select("
        SELECT SUM(DOSYABOYUTU) AS BackupDosyalarUsage FROM backupdosyalar WHERE FIRMAAPIKEY='$company->APIKEY' AND BACKUPDURUMU='Aktif'
        ");

        return new ServiceResponse(
            true,
            'backupdosyalar usage',
            200,
            $usage
        );
    }

    /**
     * @param int $id
     *
     * @return ServiceResponse
     * */
    public function getById(
        int $id
    ): ServiceResponse
    {
        $backupDosyalar = Backupdosyalar::find($id);
        if ($backupDosyalar) {
            return new ServiceResponse(
                true,
                'backupdosyalar',
                200,
                $backupDosyalar
            );
        } else {
            return new ServiceResponse(
                false,
                'backupdosyalar not found',
                404,
                null
            );
        }
    }
}
