<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Http\Requests\Api\User\CommentController\GetByRelationRequest;
use App\Http\Requests\Api\User\CommentController\CreateRequest;
use App\Interfaces\Eloquent\ICommentService;
use App\Core\HttpResponse;

class CommentController extends Controller
{
    use HttpResponse;

    /**
     * @var $commentService
     */
    private $commentService;

    /**
     * @param ICommentService $commentService
     */
    public function __construct(ICommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * @param GetByRelationRequest $request
     */
    public function getByRelation(GetByRelationRequest $request)
    {
        $response = $this->commentService->getByRelation(
            $request->relationType,
            $request->relationId
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
        $response = $this->commentService->create(
            $request->relationType,
            $request->relationId,
            $request->creatorType,
            $request->creatorId,
            $request->comment
        );

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }
}
