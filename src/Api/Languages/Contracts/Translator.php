<?php

namespace AnimalTranslator\Api\Languages\Contracts;

interface Translator
{
    /**
     * @return Translator
     */
    public function translate(): Translator;

    /**
     * @param string $inputText
     *
     * @return Translator
     */
    public function setInputText(string $inputText): Translator;

    /**
     * @return Translator
     */
    public function drinkBeer(): Translator;


    /**
     * @return string
     */
    public function getTranslation(): string;
}