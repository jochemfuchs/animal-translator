<?php

namespace AnimalTranslator\Api\Languages\Services;

use AnimalTranslator\Api\Languages\Contracts\LanguagePatternDetector;
use AnimalTranslator\Api\Languages\Languages;
use AnimalTranslator\Api\Languages\Patterns\Poodle;
use AnimalTranslator\Api\Languages\Patterns\Labrador;
use AnimalTranslator\Api\Languages\Patterns\Parrakeet;

class LanguageDetectorService
{
    /**
     * @var string[]
     */
    private $patterns = [
        Languages::LABRADOR  => Labrador::class,
        Languages::POODLE    => Poodle::class,
        Languages::PARRAKEET => Parrakeet::class,
    ];

    /**
     * @var string
     */
    private $fallback = Languages::HUMAN;

    /**
     * @param string $inputText
     *
     * @return string
     */
    public function detect(string $inputText): string
    {
        foreach ($this->patterns as $language => $patternDetectorClass) {
            /** @var LanguagePatternDetector $patternDetector */
            $patternDetector = app($patternDetectorClass, ['inputText' => $inputText]);

            if($patternDetector->matches()) {
                return $language;
            }
        }

        return $this->fallback;
    }
}