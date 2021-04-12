<?php

namespace AnimalTranslator\Api\Form\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use AnimalTranslator\Api\Languages\Rules\LanguageMatchesText;
use AnimalTranslator\Api\Languages\Rules\TargetLanguageAllowed;

class TranslationRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'sourceLanguage' => 'required',
            'drunk'          => 'required|boolean',
            'targetLanguage' => [
                'required',
                new TargetLanguageAllowed($this->get('sourceLanguage'))
            ],
            'inputText'      => [
                'required',
                'min:1',
                new LanguageMatchesText($this->get('sourceLanguage'))
            ],
        ];
    }

    /**
     * @return string
     */
    public function getInputText(): string
    {
        return strip_tags($this->get('inputText'));
    }

    /**
     * @return string
     */
    public function getTargetLanguage(): string
    {
        return $this->get('targetLanguage');
    }

    /**
     * @return string
     */
    public function isDrunk(): string
    {
        return $this->get('drunk') === true;
    }
}