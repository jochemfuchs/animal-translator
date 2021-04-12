<?php

namespace AnimalTranslator\Api\Languages\Factories;

use AnimalTranslator\Api\Languages\Languages;
use AnimalTranslator\Api\Languages\Contracts\Translator;
use AnimalTranslator\Api\Languages\Translators\ParrotTranslator;
use AnimalTranslator\Api\Languages\Translators\PoodleTranslator;
use AnimalTranslator\Api\Languages\Translators\LabradorTranslator;
use AnimalTranslator\Api\Languages\Translators\ParrakeetTranslator;

class TranslatorFactory
{
    private $translators = [
        Languages::LABRADOR  => LabradorTranslator::class,
        Languages::POODLE    => PoodleTranslator::class,
        Languages::PARRAKEET => ParrakeetTranslator::class,
        Languages::PARROT    => ParrotTranslator::class,
    ];

    /**
     * @param string $targetLanguage
     */
    public function make(string $targetLanguage): Translator
    {
        return app($this->translators[$targetLanguage]);
    }
}