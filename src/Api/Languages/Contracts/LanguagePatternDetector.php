<?php

namespace AnimalTranslator\Api\Languages\Contracts;

interface LanguagePatternDetector
{
    /**
     * @return bool
     */
    public function matches(): bool;
}