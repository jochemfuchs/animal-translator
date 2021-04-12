<?php

namespace AnimalTranslator\Api\Form\Http;

use AnimalTranslator\Api\Form\Http\Requests\TranslationRequest;
use AnimalTranslator\Api\Languages\Services\TranslationService;
use App\Http\Controllers\Controller;

class TranslateInputText extends Controller
{
    /**
     * @var TranslationService
     */
    private $translationService;

    /**
     * @param TranslationService $translationService
     */
    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    /**
     * @param TranslationRequest $request
     *
     * @return string
     */
    public function __invoke(TranslationRequest $request): string
    {
        return $this->translationService->translate($request);
    }
}