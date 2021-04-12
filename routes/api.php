<?php

use Illuminate\Support\Facades\Route;
use AnimalTranslator\Api\Form\Http\TranslateInputText;
use AnimalTranslator\Api\Form\Http\TranslatorFormController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/available-languages',  [TranslatorFormController::class, 'getAvailableSourceLanguages']);
Route::get('/available-languages/{sourceLanguage}', [TranslatorFormController::class, 'getAvailableTargetLanguages']);
Route::post('/autodetect-language',  [TranslatorFormController::class, 'autodetectLanguage']);

Route::post('/translate',  TranslateInputText::class);