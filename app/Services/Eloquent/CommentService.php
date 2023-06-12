<?php

namespace App\Services\Eloquent;

use App\Interfaces\Eloquent\ICommentService;
use App\Models\Eloquent\Comment;
use App\Core\ServiceResponse;

class CommentService implements ICommentService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'All comments',
            200,
            Comment::all()
        );
    }

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function getById(
        int $id
    ): ServiceResponse
    {
        $comment = Comment::find($id);
        if ($comment) {
            return new ServiceResponse(
                true,
                'Comment',
                200,
                $comment
            );
        }
        return new ServiceResponse(
            false,
            'Comment not found',
            404,
            null
        );
    }

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function delete(
        int $id
    ): ServiceResponse
    {
        $comment = $this->getById($id);
        if ($comment->isSuccess()) {
            return new ServiceResponse(
                true,
                'Comment deleted',
                200,
                $comment->getData()->delete()
            );
        }
        return $comment;
    }

    /**
     * @param string $relationType
     * @param int $relationId
     *
     * @return ServiceResponse
     */
    public function getByRelation(
        string $relationType,
        int    $relationId,
    ): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'Comments',
            200,
            Comment::where('relation_type', $relationType)
                ->where('relation_id', $relationId)
                ->get()
        );
    }

    /**
     * @param string $relationType
     * @param int $relationId
     * @param string $creatorType
     * @param int $creatorId
     * @param string $commentString
     *
     * @return ServiceResponse
     */
    public function create(
        string $relationType,
        int    $relationId,
        string $creatorType,
        int    $creatorId,
        string $commentString,
    ): ServiceResponse
    {
        $comment = new Comment;
        $comment->relation_type = $relationType;
        $comment->relation_id = $relationId;
        $comment->creator_type = $creatorType;
        $comment->creator_id = $creatorId;
        $comment->comment = $commentString;
        $comment->save();

        return new ServiceResponse(
            true,
            'Comment created',
            201,
            $comment
        );
    }
}
