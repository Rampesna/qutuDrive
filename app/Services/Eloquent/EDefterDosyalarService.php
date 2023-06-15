<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Models\Eloquent\Edefterdonemler;
use App\Models\Eloquent\Edefterdosyalar;
use App\Interfaces\Eloquent\IEDefterDosyalarService;
use App\Models\Eloquent\Firmalar;
use App\Services\AwsS3\StorageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use ZipArchive;

class EDefterDosyalarService implements IEDefterDosyalarService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/EDefterDosyalarService.getAll.success'),
            200,
            Edefterdosyalar::all()
        );
    }

    /**
     * @param string $id
     *
     * @return ServiceResponse
     */
    public function getById(
        string $id
    ): ServiceResponse
    {
        $eDefterDosyalar = Edefterdosyalar::where('ID', $id)->where('DURUM', 1)->first();
        if ($eDefterDosyalar) {
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/EDefterDosyalarService.getById.exists'),
                200,
                $eDefterDosyalar
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/EDefterDosyalarService.getById.notFound'),
                404,
                null
            );
        }
    }

    /**
     * @param string $id
     *
     * @return ServiceResponse
     */
    public function delete(
        string $id
    ): ServiceResponse
    {
        $eDefterDosyalar = $this->getById($id);
        if ($eDefterDosyalar->isSuccess()) {
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/EDefterDosyalarService.delete.success'),
                200,
                $eDefterDosyalar->getData()->delete()
            );
        } else {
            return $eDefterDosyalar;
        }
    }

    /**
     * @param string $donemId
     *
     * @return ServiceResponse
     */
    public function getByDonemId(
        string $donemId
    ): ServiceResponse
    {
        set_time_limit(86400);
        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/EDefterDosyalarService.getByDonemId.success'),
            200,
            Edefterdosyalar::where('DONEMLERID', $donemId)->get()
        );
    }

    /**
     * @param int $companyId
     * @param string $year
     * @param string $month
     * @param array $typeIds
     *
     * @return ServiceResponse
     */
    public function getByDatesAndTypeIds(
        int    $companyId,
        string $year,
        string $month,
        array  $typeIds
    ): ServiceResponse
    {
        set_time_limit(86400);
        $company = Firmalar::find($companyId);
        if ($company) {
            $eDefterDonem = Edefterdonemler::where('FIRMAAPIKEY', $company->APIKEY)
                ->where('YIL', $year)
                ->where('AY', $month)
                ->whereIn('DEFTERTURKODU', $typeIds)
                ->first();
            if ($eDefterDonem) {
                return new ServiceResponse(
                    true,
                    __('ServiceResponse/Eloquent/EDefterDosyalarService.getByDonemId.success'),
                    200,
                    Edefterdosyalar::where('DONEMLERID', $eDefterDonem->ID)->get()
                );
            } else {
                return new ServiceResponse(
                    false,
                    __('ServiceResponse/Eloquent/EDefterDonemlerService.getEDefterDonem.notFound'),
                    404,
                    null
                );
            }
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/EDefterDonemlerService.getEDefterDonem.companyNotFound'),
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
        SELECT SUM(DOSYABOYUTU) AS EDefterDosyalarUsage FROM edefterdosyalar WHERE FIRMAAPIKEY='$company->APIKEY' AND DURUM=2
        ");

        return new ServiceResponse(
            true,
            'edefterdosyalar usage',
            200,
            $usage
        );
    }

    /**
     * @param int $companyId
     * @param mixed $userApiKey
     * @param mixed $uploadedFile
     *
     * return ServiceResponse
     * */
    public function singleELedgerUpload(
        int   $companyId,
        mixed $userApiKey,
        mixed $uploadedFile
    ): ServiceResponse
    {
        $company = Firmalar::find($companyId);

        $zip = new ZipArchive;
        $res = $zip->open($uploadedFile->getPathname());

        if ($res === TRUE) {
            $pattern = public_path('zipExtractFolder/');
            $zip->extractTo($pattern);

            $extractedFiles = glob($pattern . '*');
            foreach ($extractedFiles as $file) {
                $fileName = basename($file);
                // save file to public path
                $path = $zip->statName($fileName)['name'];


                $explodedFileName = explode('-', $fileName);

                if (count($explodedFileName) == 5) {
                    $year = substr($explodedFileName[2], 0, 4);
                    $month = substr($explodedFileName[2], 4, 2);
                    $eLedgerType = getELedgerType($explodedFileName[3], 1);
                } else {
                    $year = substr($explodedFileName[1], 0, 4);
                    $month = substr($explodedFileName[1], 4, 2);
                    $eLedgerType = getELedgerType($explodedFileName[2], 0);
                }

                $edefterDonemlerUuid = Str::uuid()->toString();
                $edefterDonemler = new Edefterdonemler;
                $edefterDonemler->ID = $edefterDonemlerUuid;
                $edefterDonemler->FIRMAAPIKEY = $company->APIKEY;
                $edefterDonemler->KULLANICIAPIKEY = $userApiKey;
                $edefterDonemler->YIL = $year;
                $edefterDonemler->AY = $month;
                $edefterDonemler->DEFTERTURKODU = $eLedgerType;
                $edefterDonemler->DURUM = 1;
                $edefterDonemler->save();

                $fileExtension = explode('.', $fileName)[1];
                $edefterDosyalarUuid = Str::uuid()->toString();
                $edefterDosyalar = new Edefterdosyalar;
                $edefterDosyalar->ID = $edefterDosyalarUuid;
                $edefterDosyalar->FIRMAAPIKEY = $company->APIKEY;
                $edefterDosyalar->KULLANICIAPIKEY = $userApiKey;
                $edefterDosyalar->DONEMLERID = $edefterDonemlerUuid;
                $edefterDosyalar->DOSYAADI = $fileName;
                $edefterDosyalar->DOSYAUZANTISI = '.' . $fileExtension;
                $edefterDosyalar->SUNUCUDOSYAADI = $edefterDosyalarUuid . '.' . $fileExtension;
                $edefterDosyalar->DOSYABOYUTU = $zip->statName($fileName)['size'] / 1024 / 1024;
                $edefterDosyalar->KAYITTARIHI = date('Y-m-d H:i:s');
                $edefterDosyalar->DURUM = 2;
                $edefterDosyalar->ZIPDOSYABOYUTU = $uploadedFile->getSize() / 1024 / 1024;
                $edefterDosyalar->GIBDURUM = 1;
                $edefterDosyalar->SERVISDURUMU = 2;
                $edefterDosyalar->save();

                $storageService = app(StorageService::class);
                $storageResponse = $storageService->storeFromAsset(
                    $pattern . $path,
                    $edefterDosyalarUuid . '.' . $fileExtension
                );
            }

            $zip->close();

            return new ServiceResponse(
                false,
                'E-ledger file(s) uploaded successfully.',
                200,
                null
            );


        } else {
            return new ServiceResponse(
                false,
                'Failed to open the zip file.',
                400,
                null
            );
        }
    }
}
