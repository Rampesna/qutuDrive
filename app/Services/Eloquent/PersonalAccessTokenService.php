<?php

namespace App\Services\Eloquent;

use App\Interfaces\Eloquent\IPersonalAccessTokenService;
use App\Core\ServiceResponse;
use Laravel\Sanctum\PersonalAccessToken;

class PersonalAccessTokenService implements IPersonalAccessTokenService
{
    /**
     * @param string $token
     *
     * @return ServiceResponse
     */
    public function findToken(
        string $token
    ): ServiceResponse
    {

        $personalAccessToken = PersonalAccessToken::findToken($token);
        if ($personalAccessToken) {
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/PersonalAccessTokenService.findToken.success'),
                200,
                $personalAccessToken
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/PersonalAccessTokenService.findToken.notFound'),
                404,
                null
            );
        }
    }
}
