<?php


namespace App\Services\ApiAyssoft;

use App\Interfaces\ApiAyssoft\IBalanceInquiryService;
use App\Core\ServiceResponse;

class BalanceInquiryService extends ApiAyssoftService implements IBalanceInquiryService
{
    /*
     * @param string $TaxNr
     * @param string $Product
     *
     * @return ServiceResponse
     * */
    public function Index(
        string $TaxNr,
        string $Product
    ): ServiceResponse
    {
        $endpoint = "BalanceInquiry/Index";
        $headers = [
            'Authorization' => 'Bearer ',
        ];

        $parameters = [
            'TaxNr' => $TaxNr,
            'Product' => $Product
        ];

        $response = $this->callApi($this->baseUrl . $endpoint . '?' . http_build_query($parameters), 'get', $headers, $parameters)->getBody()->getContents();

        return new ServiceResponse(
            true,
            'BalanceInquiry/Index',
            200,
            json_decode($response, true)
        );
    }
}
