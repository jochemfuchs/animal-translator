<?php

namespace AnimalTranslator\Api\Languages\Rules;

use AnimalTranslator\Api\Languages\Services\LanguageDetectorService;
use Illuminate\Contracts\Validation\Rule;

class LanguageMatchesText implements Rule
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
     * @return bool
     */
    public function passes($attribute, $value)
    {
        /** @var LanguageDetectorService $languageDetector */
        $languageDetector = app(LanguageDetectorService::class);
        $detectedLanguage = $languageDetector->detect(strip_tags($value));

        return $detectedLanguage === $this->sourceLanguage;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('languages.source_language_doesnt_match_text');
    }
}
