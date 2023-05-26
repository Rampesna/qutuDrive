<?php

use Illuminate\Support\Carbon;

if (!function_exists('getLocaleList')) {
    function getLocaleList()
    {
        return [
            'en',
            'tr'
        ];
    }
}

if (!function_exists('minutesToHours')) {
    function minutesToHours($minutes)
    {
        return intval($minutes / 60);
    }
}

if (!function_exists('hoursToDays')) {
    function hoursToDays($hours)
    {
        return intval($hours / 8);
    }
}

if (!function_exists('calculateMinutes')) {
    function calculateMinutes($startDate, $endDate)
    {
        $minutes = 0;

        if (date('Y-m-d', strtotime($startDate)) == date('Y-m-d', strtotime($endDate))) {
            $minutes =
                Carbon::createFromDate($startDate)->diffInMinutes($endDate) >= 480 ?
                    480 :
                    Carbon::createFromDate($startDate)->diffInMinutes($endDate);
        } else {
            $period = Carbon::createFromDate($startDate)->diffInDays($endDate);
            for ($counter = 0; $counter <= $period; $counter++) {
                if ($counter == 0) {
                    $minutes +=
                        Carbon::createFromDate($startDate)->diffInMinutes(date('Y-m-d 18:00:00', strtotime($startDate))) >= 480 ?
                            480 :
                            Carbon::createFromDate($startDate)->diffInMinutes(date('Y-m-d 18:00:00', strtotime($startDate)));
                } else if ($counter == $period) {
                    $minutes +=
                        Carbon::createFromDate(date('Y-m-d 09:00:00', strtotime($endDate)))->diffInMinutes($endDate) >= 480 ?
                            480 :
                            Carbon::createFromDate(date('Y-m-d 09:00:00', strtotime($endDate)))->diffInMinutes($endDate);
                } else {
                    $minutes += 480;
                }
            }
        }

        return $minutes;
    }
}

if (!function_exists('getDurationForHuman')) {
    function getDurationForHuman($minutes)
    {
        $durationOfPermitMinutes = $minutes - (minutesToHours($minutes) * 60);
        $durationOfPermitHours = minutesToHours($minutes);
        $durationOfPermitDays = hoursToDays(minutesToHours($minutes));

        return
            ($durationOfPermitDays != 0 ? $durationOfPermitDays . ' Gün' : '') .
            ($durationOfPermitHours != 0 ? ' ' . $durationOfPermitHours . ' Saat' : '') .
            ($durationOfPermitMinutes != 0 ? ' ' . $durationOfPermitMinutes . ' Dakika' : '');
    }
}

if (!function_exists('checkUserPermission')) {
    function checkUserPermission($userPermissionId, $authUserPermissions)
    {
        return true;
    }
}

if (!function_exists('clearPhoneNumber')) {
    function clearPhoneNumber($phoneNumber)
    {
        $phoneNumber = str_replace(' ', '', $phoneNumber);
        $phoneNumber = str_replace('-', '', $phoneNumber);
        $phoneNumber = str_replace(')', '', $phoneNumber);
        $phoneNumber = str_replace('(', '', $phoneNumber);

        return $phoneNumber;
    }
}

if (!function_exists('getFileTypeId')) {
    function getFileTypeId(
        $fileMimeType
    )
    {
        if (
            $fileMimeType == 'application/pdf' ||
            $fileMimeType == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ||
            $fileMimeType == 'application/msword' ||
            $fileMimeType == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ||
            $fileMimeType == 'application/vnd.ms-excel' ||
            $fileMimeType == 'application/vnd.openxmlformats-officedocument.presentationml.presentation' ||
            $fileMimeType == 'application/vnd.ms-powerpoint'
        ) {
            return 3;
        } else if (
            $fileMimeType == 'application/sql'
        ) {
            return 2;
        } else {
            return 1;
        }
    }
}

if (!function_exists('checkFileTypeTest')) {
    function checkFileTypeTest($file)
    {
        $fileType = $file->getMimeType();

        if ($fileType == 'image/jpeg' || $fileType == 'image/png' || $fileType == 'image/gif') {
            return 'image';
        } else if ($fileType == 'application/pdf') {
            return 'pdf';
        } else if ($fileType == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $fileType == 'application/msword') {
            return 'word';
        } else if ($fileType == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || $fileType == 'application/vnd.ms-excel') {
            return 'excel';
        } else if ($fileType == 'application/vnd.openxmlformats-officedocument.presentationml.presentation' || $fileType == 'application/vnd.ms-powerpoint') {
            return 'powerpoint';
        } else if ($fileType == 'application/zip' || $fileType == 'application/x-rar-compressed') {
            return 'zip';
        } else {
            return 'other';
        }
    }
}

if (!function_exists('getELedgerType')) {
    function getELedgerType($short, $gib)
    {
        $eLedgerTypes = [
            [
                'type' => 'kebir',
                'id' => 1,
                'short' => 'K'
            ],
            [
                'type' => 'yevmiye',
                'id' => 2,
                'short' => 'Y'
            ],
            [
                'type' => 'kebirberat',
                'id' => 3,
                'short' => 'KB'
            ],
            [
                'type' => 'yevmiyeberat',
                'id' => 4,
                'short' => 'YB'
            ],
            [
                'type' => 'defterraporu',
                'id' => 7,
                'short' => 'DR'
            ]
        ];

        $gibELedgerTypes = [
            [
                'type' => 'gibkebirberat',
                'id' => 5,
                'short' => 'KB'
            ],
            [
                'type' => 'gibyevmiyeberat',
                'id' => 6,
                'short' => 'YB'
            ]
        ];

        if ($gib == 1) {
            foreach ($gibELedgerTypes as $gibELedgerType) {
                if ($gibELedgerType['short'] == $short) {
                    return $gibELedgerType['id'];
                }
            }
        } else {
            foreach ($eLedgerTypes as $eLedgerType) {
                if ($eLedgerType['short'] == $short) {
                    return $eLedgerType['id'];
                }
            }
        }
    }
}

if (!function_exists('getLogoPath')) {
    function getLogoPath(
        $domain
    )
    {
        $domain = str_replace('http://', '', $domain);
        $domain = str_replace('https://', '', $domain);
        $domain = str_replace('www.', '', $domain);
        $exploded = explode('.', $domain);
        array_pop($exploded);
        $domain = end($exploded);

        if ($domain == 'qutudrive') {
            return asset('logos/qutudrive.png');
        } else if ($domain == 'uyumyedek') {
            return asset('logos/uyumyedek.png');
        } else {
            return asset('logos/logo.png');
        }
    }
}
