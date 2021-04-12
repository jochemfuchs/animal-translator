<?php

namespace AnimalTranslator\Api\Languages\Translators;

use AnimalTranslator\Api\Languages\Contracts\Translator;
use AnimalTranslator\Api\Languages\Services\DrunkifyService;

abstract class LanguageTranslator implements Translator
{
    /**
     * @var string
     */
    protected $inputText;

    /**
     * @var string
     */
    protected $outputText = '';

    /**
     * @var DrunkifyService
     */
    private $drunkifyService;

    /**
     * @param DrunkifyService $drunkifyService
     */
    public function __construct(DrunkifyService $drunkifyService)
    {
        $this->drunkifyService = $drunkifyService;
    }

    /**
     * @param string $inputText
     *
     * @return $this
     */
    public function setInputText(string $inputText): self
    {
        $this->inputText = $inputText;

        return $this;
    }

    /**
     * @return $this
     */
    public function drinkBeer(): self
    {
        $this->outputText = $this->drunkifyService->drunkify($this->outputText);

        return $this;
    }


    /**
     * @return string
     */
    public function getTranslation(): string
    {
        return $this->outputText;
    }

    /**
     * @param $word
     * @param $replacement
     *
     * @return string
     */
    protected function replaceWithMatchingCase($word, $replacement): string
    {
        $firstChar = substr($word,0,1);

        if(ctype_upper($firstChar))
        {
            return ucfirst($replacement);
        }

        return $replacement;
    }

    /**
     * @param string $word
     *
     * @return string
     */
    protected function getWordBounderyPattern(string $word): string
    {
        return '/' . preg_quote($word) . '(?!\w)/';
    }
}