<?php

namespace AnimalTranslator\Api\Languages\Services;

use AnimalTranslator\Api\Form\Http\Requests\TranslationRequest;
use AnimalTranslator\Api\Languages\Factories\TranslatorFactory;

class TranslationService
{
    /**
     * @var TranslatorFactory
     */
    private $factory;

    /**
     * @param TranslatorFactory $factory
     */
    public function __construct(TranslatorFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return string
     */
    public function translate(TranslationRequest $request): string
    {
        $translator = $this->factory->make($request->getTargetLanguage());

        $translator
            ->setInputText($request->getInputText())
            ->translate();

        if($request->isDrunk()) {
            $translator->drinkBeer();
        }

        return $translator->getTranslation();
    }
}