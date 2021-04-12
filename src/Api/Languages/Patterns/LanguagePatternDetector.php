<?php

namespace AnimalTranslator\Api\Languages\Patterns;

use AnimalTranslator\Api\Languages\Contracts\LanguagePatternDetector as LanguagePatternDetectorContract;

abstract class LanguagePatternDetector implements LanguagePatternDetectorContract
{
    /**
     * @var string
     */
    protected $inputText;

    /**
     * @var string[]
     */
    protected $wordList = [];

    /**
     * @param string $inputText
     */
    public function __construct(string $inputText)
    {
        $this->inputText = $inputText;
    }

    /**
     * @return bool
     */
    protected function checkPattern(): bool
    {
        $filteredText = $this->inputText;

        foreach ($this->wordList as $word) {
            $filteredText = str_ireplace($word, '', $filteredText);
        }

        $filteredText = trim($filteredText);

        if(empty($filteredText)) {
            return true;   
        }

        return false;
    }

    /**
     * @return bool
     */
    public function matches(): bool
    {
        return $this->checkPattern();
    }
}