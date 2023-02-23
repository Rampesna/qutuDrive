<?php

namespace App\Services\Eloquent;


use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IVideoService;
use App\Models\Eloquent\Video;


/**
 *
 */
class VideoService implements IVideoService
{

    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        $videos = Video::orderBy('id', 'desc')->get();
        return new ServiceResponse(true, __('ServiceResponse/Eloquent/VideoService.getAll.success'), 200, $videos);
    }

    /**
     * @param int $id
     * @return ServiceResponse
     */
    public function getById(int $id): ServiceResponse
    {
        $video = Video::find($id);
        if ($video) {
            return new ServiceResponse(true, __('ServiceResponse/Eloquent/VideoService.getById.exists'), 200, $video);
        }else{
            return new ServiceResponse(false, __('ServiceResponse/Eloquent/VideoService.getById.notFound'), 404, null);
        }
    }

    /**
     * @param int $id
     * @return ServiceResponse
     */
    public function delete(int $id): ServiceResponse
    {
        $video = Video::find($id);
        if ($video) {
            $video->delete();
            return new ServiceResponse(true, __('ServiceResponse/Eloquent/VideoService.delete.success'), 200, null);
        }else{
            return new ServiceResponse(false, __('ServiceResponse/Eloquent/VideoService.delete.notFound'), 404, null);
        }
    }

    /**
     * @param string $name
     * @param string $url
     * @return ServiceResponse
     */
    public function create(string $name, string $url,): ServiceResponse
    {
        $video = new Video();
        $video->name = $name;
        $video->url = $url;
        $video->save();
        return new ServiceResponse(true, __('ServiceResponse/Eloquent/VideoService.create.success'), 200, $video);
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $url
     * @return ServiceResponse
     */
    public function update(int $id, string $name, string $url,): ServiceResponse
    {
        $video = Video::find($id);
        if ($video) {
            $video->name = $name;
            $video->url = $url;
            $video->save();
            return new ServiceResponse(true, __('ServiceResponse/Eloquent/VideoService.update.success'), 200, $video);
        }else{
            return new ServiceResponse(false, __('ServiceResponse/Eloquent/VideoService.update.notFound'), 404, null);
        }
    }
}
