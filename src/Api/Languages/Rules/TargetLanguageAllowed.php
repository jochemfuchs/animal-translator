<?php

namespace AnimalTranslator\Api\Languages\Rules;

use Illuminate\Contracts\Validation\Rule;

class TargetLanguageAllowed implements Rule
{
    /**
     * @var string
     */
    private $sourceLanguage;

    /**
     * @param string $sourceLanguage
     */
    public function __construct(string $sourceLanguage)
    {
        $this->sourceLanguage = $sourceLanguage;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(!config()->has('translator.translationTargets.' . $this->sourceLanguage)) {
            return false;
        }

        return in_array($value, config()->get('translator.translationTargets.' . $this->sourceLanguage));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('languages.target_language_doesnt_match_source');
    }
}
