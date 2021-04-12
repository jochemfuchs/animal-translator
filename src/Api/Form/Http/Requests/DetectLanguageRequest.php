<?php

namespace AnimalTranslator\Api\Form\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetectLanguageRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'inputText' => 'required|min:1'
        ];
    }

    /**
     * @return string
     */
    public function getInputText(): string
    {
        return strip_tags($this->get('inputText'));
    }
}