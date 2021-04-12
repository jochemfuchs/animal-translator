<?php

namespace AnimalTranslator\Api\Languages\Translators;

use AnimalTranslator\Api\Languages\Contracts\Translator;

class ParrakeetTranslator extends LanguageTranslator
{
    private const REPLACE_VOWEL     = 'tjilp';
    private const REPLACE_CONSONANT = 'piep';

    /**
     * @inheritDoc
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
                return $this->replaceWithMatchingCase($word, $this->getReplacement($word));
            })
            ->toArray();


        $wordPatterns = collect($words)
            ->map(function($word){
                return $this->getWordBounderyPattern($word);
            })
            ->toArray();

        return preg_replace($wordPatterns, $replaces, $this->inputText);
    }

    /**
     * @param $word
     *
     * @return string
     */
    private function getReplacement($word): string
    {
        if (ctype_alpha($word) && preg_match('/^[aeiou]/i', $word))
        {
            return self::REPLACE_VOWEL;
        }

        return self::REPLACE_CONSONANT;
    }
}