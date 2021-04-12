<?php

namespace AnimalTranslator\Api\Languages\Translators;

use AnimalTranslator\Api\Languages\Contracts\Translator;

class PoodleTranslator extends LanguageTranslator
{
    /**
     * @return Translator
     */
    public function translate(): Translator
    {
        $this->outputText = $this->replaceWords();

        return $this;
    }

    /**
     * @return string
     */
    private function replaceWords(): string
    {
        $words    = str_word_count($this->inputText, 1);
        $replaces = collect($words)
            ->map(function($word){
                return $this->replaceWithMatchingCase($word, 'woefie');
            })
            ->toArray();

        $wordPatterns = collect($words)
            ->map(function($word){
                return $this->getWordBounderyPattern($word);
            })
            ->toArray();

        return preg_replace($wordPatterns, $replaces, $this->inputText);
    }
}