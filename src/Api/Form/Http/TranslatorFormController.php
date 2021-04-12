<?php

namespace AnimalTranslator\Api\Form\Http;

use InvalidArgumentException;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use AnimalTranslator\Api\Form\Http\Requests\DetectLanguageRequest;
use AnimalTranslator\Api\Languages\Services\LanguageDetectorService;

class TranslatorFormController extends Controller
{
    /**
     * @return Collection
     */
    public function getAvailableSourceLanguages(): Collection
    {
        return collect(config()->get('translator.languages'))
            ->mapWithKeys(function ($language) {
                return [$language => trans('languages.' . $language)];
            });
    }

    /**
     * @param string $sourceLanguage
     *
     * @return Collection
     */
    public function getAvailableTargetLanguages(string $sourceLanguage): Collection
    {
        if(!config()->has('translator.translationTargets.' . $sourceLanguage)) {
            throw new InvalidArgumentException("Invalid language, source language $sourceLanguage has no translation targets.");
        }

        $availableTargetLanguages = collect(config()->get('translator.translationTargets.' . $sourceLanguage));

        return $availableTargetLanguages->mapWithKeys(function($language) {
            return [$language =>  trans('languages.' . $language)];
        });
    }

    /**
     * @param DetectLanguageRequest $request
     * @param LanguageDetectorService $detectorService
     *
     * @return array
     */
    public function autodetectLanguage(DetectLanguageRequest $request, LanguageDetectorService $detectorService): array
    {
        $detectedLanguage = $detectorService->detect($request->getInputText());

        return [
            'languages'         => $this->getAvailableTargetLanguages($detectedLanguage),
            'detected_language' => $detectedLanguage
        ];
    }
}
