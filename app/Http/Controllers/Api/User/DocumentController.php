<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Core\HttpResponse;
use App\Http\Requests\Api\User\DocumentController\CreateRequest;
use App\Http\Requests\Api\User\DocumentController\DeleteRequest;
use App\Http\Requests\Api\User\DocumentController\UpdateRequest;
use App\Interfaces\Eloquent\IDocumentService;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    use HttpResponse;

    private $documentService;

    public function __construct(IDocumentService $documentService)
    {
        $this->documentService = $documentService;
    }


    public function getAll(Request $request)
    {
        $response = $this->documentService->getAll();

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    public function getById(Request $request)
    {
        $response = $this->documentService->getById(
            $request->id
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    public function create(CreateRequest $request)
    {
        $response = $this->documentService->create(
            $request->name,
            $request->file
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    public function update(UpdateRequest $request)
    {
        $response = $this->documentService->update(
            $request->id,
            $request->name,
            $request->file
        );
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    public function delete(DeleteRequest $request)
    {
        $response = $this->documentService->delete(
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
