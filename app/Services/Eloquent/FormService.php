<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Models\Eloquent\Form;
use App\Interfaces\Eloquent\IFormService;

class FormService implements IFormService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'All forms',
            200,
            Form::all()
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
        $form = Form::find($id);
        if ($form) {
            return new ServiceResponse(
                true,
                'Form',
                200,
                $form
            );
        } else {
            return new ServiceResponse(
                false,
                'Form not found',
                404,
                null
            );
        }
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
        $form = $this->getById($id);
        if ($form->isSuccess()) {
            return new ServiceResponse(
                true,
                'Form deleted',
                200,
                $form->getData()->delete()
            );
        } else {
            return $form;
        }
    }

    /**
     * @param int $companyId
     * @param int $pageIndex
     * @param int $pageSize
     * @param string|null $keyword
     *
     * @return ServiceResponse
     */
    public function getByCompanyId(
        int         $companyId,
        int         $pageIndex,
        int         $pageSize,
        string|null $keyword = null
    ): ServiceResponse
    {
        $forms = Form::where('company_id', $companyId);

        if ($keyword) {
            $forms->where('name', 'like', '%' . $keyword . '%');
        }

        return new ServiceResponse(
            true,
            'Projects',
            200,
            [
                'totalCount' => $forms->count(),
                'pageIndex' => $pageIndex,
                'pageSize' => $pageSize,
                'forms' => $pageSize == -1 ?
                    $forms->get() :
                    $forms->skip($pageSize * $pageIndex)->take($pageSize)->get()
            ]
        );
    }

    /**
     * @param int $companyId
     * @param string $name
     * @param string|null $title
     * @param string|null $description
     *
     * @return ServiceResponse
     */
    public function create(
        int         $companyId,
        string      $name,
        string|null $title = null,
        string|null $description = null
    ): ServiceResponse
    {
        $form = new Form();
        $form->company_id = $companyId;
        $form->name = $name;
        $form->title = $title;
        $form->description = $description;
        $form->save();

        return new ServiceResponse(
            true,
            'Form created',
            201,
            $form
        );
    }

    /**
     * @param int $id
     * @param string $name
     * @param string|null $title
     * @param string|null $description
     *
     * @return ServiceResponse
     */
    public function update(
        int         $id,
        string      $name,
        string|null $title = null,
        string|null $description = null
    ): ServiceResponse
    {
        $form = $this->getById($id);
        if ($form->isSuccess()) {
            $form->getData()->name = $name;
            $form->getData()->title = $title;
            $form->getData()->description = $description;
            $form->getData()->save();

            return new ServiceResponse(
                true,
                'Form updated',
                200,
                $form->getData()
            );
        } else {
            return $form->getData();
        }
    }
}
