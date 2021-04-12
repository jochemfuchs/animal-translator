<?php

namespace AnimalTranslator\Api\Languages\Services;

class DrunkifyService
{
    /**
     * @var string
     */
    private $paragraphBreak = PHP_EOL . PHP_EOL;

    /**
     * @param string $inputText
     *
     * @return string
     */
    public function drunkify(string $inputText)
    {
        $paragraphs        = $this->splitIntoParagraphs($inputText);
        $drunkenParagraphs = [];

        foreach ($paragraphs as $paragraph) {
            $drunkenParagraphs[] = $this->drunkifyParagraph($paragraph);
        }

        return implode(
            $this->paragraphBreak . 'Proost!' . $this->paragraphBreak,
            $drunkenParagraphs
            ) . $this->paragraphBreak . 'Burp!';
    }

    /**
     * @param string $inputText
     *
     * @return string[]
     */
    private function splitIntoParagraphs(string $inputText): array
    {
        $inputText = preg_replace("/(\r?\n){2,}/", "--PARAGRAPH-BREAK--", $inputText);

        return explode("--PARAGRAPH-BREAK--", $inputText);
    }

    /**
     * @param string $paragraph
     */
    private function drunkifyParagraph(string $paragraph)
    {
        $wordCount = str_word_count($paragraph);

        if($wordCount < 4)
        {
            return $paragraph;
        }

        $words    = str_word_count($paragraph, 1);
        $words[3] = strrev($words[3]);

        return implode(' ', $words);
    }
}