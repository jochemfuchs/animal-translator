<?php

namespace AnimalTranslator\Api\Languages\Translators;

use AnimalTranslator\Api\Languages\Contracts\Translator;

class ParrotTranslator extends LanguageTranslator
{
    /**
     * @inheritDoc
     */
    public function translate(): Translator
    {
        $this->outputText = trans('languages.parrot_line') . ' ' . $this->inputText;

        return $this;
    }
}