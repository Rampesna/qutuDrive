<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Http\Requests\Api\User\CompanyController\GetAllRequest;
use App\Http\Requests\Api\User\CompanyController\GetByIdRequest;
use App\Http\Requests\Api\User\CompanyController\GetByTaxNumberRequest;
use App\Http\Requests\Api\User\CompanyController\CreateRequest;
use App\Http\Requests\Api\User\CompanyController\UpdateRequest;
use App\Http\Requests\Api\User\CompanyController\DeleteRequest;
use App\Interfaces\Eloquent\IFirmalarService;
use App\Core\HttpResponse;

class CompanyController extends Controller
{
    use HttpResponse;

    /**
     * @var $firmalarService
     */
    private $firmalarService;

    /**
     * @var IFirmalarService $firmalarService
     */
    public function __construct(IFirmalarService $firmalarService)
    {
        $this->firmalarService = $firmalarService;
    }

    /**
     * @param GetAllRequest $request
     */
    public function getAll(GetAllRequest $request)
    {
        $response = $this->firmalarService->getAll();

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param GetByIdRequest $request
     */
    public function getById(GetByIdRequest $request)
    {
        $response = $this->firmalarService->getById(
            $request->id
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param GetByTaxNumberRequest $request
     */
    public function getByTaxNumber(GetByTaxNumberRequest $request)
    {
        $response = $this->firmalarService->getByTaxNumber(
            $request->taxNumber,
            $request->exceptId
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param CreateRequest $request
     */
    public function create(CreateRequest $request)
    {
        $response = $this->firmalarService->create(
            $request->title,
            $request->taxNumber,
            $request->name,
            $request->surname,
            $request->taxOffice,
            $request->address,
            $request->phone,
            $request->email,
            $request->dealerCode,
            $request->eLedgerSourceType
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param UpdateRequest $request
     */
    public function update(UpdateRequest $request)
    {
        $response = $this->firmalarService->update(
            $request->id,
            $request->title,
            $request->taxNumber,
            $request->name,
            $request->surname,
            $request->taxOffice,
            $request->address,
            $request->phone,
            $request->email,
            $request->dealerCode,
            $request->eLedgerSourceType
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param DeleteRequest $request
     */
    public function delete(DeleteRequest $request)
    {
        $response = $this->firmalarService->delete(
            $request->id
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }
}
