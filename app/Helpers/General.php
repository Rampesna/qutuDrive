<?php

use Illuminate\Support\Carbon;

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
        return in_array($userPermissionId, $authUserPermissions);
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
