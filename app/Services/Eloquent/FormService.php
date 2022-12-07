<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Models\Eloquent\Form;
use App\Models\Eloquent\FormQuestion;
use App\Models\Eloquent\FormQuestionAnswer;
use App\Interfaces\Eloquent\IFormService;
use Illuminate\Support\Facades\Crypt;

class FormService implements IFormService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            __('ServiceResponse/Eloquent/FormService.getAll.success'),
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
                __('ServiceResponse/Eloquent/FormService.getById.exists'),
                200,
                $form
            );
        } else {
            return new ServiceResponse(
                false,
                __('ServiceResponse/Eloquent/FormService.getById.notFound'),
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
                __('ServiceResponse/Eloquent/FormService.delete.success'),
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
            __('ServiceResponse/Eloquent/FormService.getByCompanyId.success'),
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
            __('ServiceResponse/Eloquent/FormService.create.success'),
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
                __('ServiceResponse/Eloquent/FormService.update.success'),
                200,
                $form->getData()
            );
        } else {
            return $form->getData();
        }
    }

    /**
     * @param int $id
     * @param bool $accessible
     *
     * @return ServiceResponse
     */
    public function updateAccessible(
        int  $id,
        bool $accessible
    ): ServiceResponse
    {
        $form = $this->getById($id);
        if ($form->isSuccess()) {
            $form->getData()->accessible = $accessible;
            $form->getData()->save();

            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/FormService.updateAccessible.success'),
                200,
                $form->getData()
            );
        } else {
            return $form->getData();
        }
    }

    /**
     * @param int $formId
     * @param array|null $formQuestions
     *
     * @return ServiceResponse
     */
    public function createFormQuestions(
        int    $formId,
        ?array $formQuestions
    ): ServiceResponse
    {
        $form = $this->getById($formId);
        if ($form->isSuccess()) {
            if ($formQuestions != null) {
                foreach ($formQuestions as $question) {
                    $formQuestion = new FormQuestion;
                    $formQuestion->form_id = $formId;
                    $formQuestion->name = $question['question'];
                    $formQuestion->type_id = $question['questionType'];
                    $formQuestion->required = $question['questionRequired'] == 'true' ? 1 : 0;
                    $formQuestion->save();

                    if (in_array($formQuestion->type_id, [3, 4, 5]) && $question['questionAnswers']) {
                        foreach ($question['questionAnswers'] as $questionAnswer) {
                            $formQuestionAnswer = new FormQuestionAnswer;
                            $formQuestionAnswer->form_question_id = $formQuestion->id;
                            $formQuestionAnswer->name = $questionAnswer;
                            $formQuestionAnswer->save();
                        }
                    }
                }
            }

            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/FormService.createFormQuestions.success'),
                200,
                $formQuestions
            );
        } else {
            return $form->getData();
        }
    }

    /**
     * @param int $formId
     *
     * @return ServiceResponse
     */
    public function getShareLink(
        int $formId
    ): ServiceResponse
    {
        $form = $this->getById($formId);
        if ($form->isSuccess()) {
            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/FormService.getShareLink.success'),
                200,
                route('share.form') . '/' . Crypt::encrypt($form->getData()->id)
            );
        } else {
            return $form->getData();
        }
    }
}
