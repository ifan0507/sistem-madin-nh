<?php

namespace App\services;

class PegonService
{
    protected array $rules;
    public function __construct()
    {
        $this->rules = config('pegon_rules');
    }

    public function generate(string $text): string
    {
        $words = explode(' ', strtolower($text));
        $processedWords = [];

        foreach ($words as $word) {
            $result = '';
            $i = 0;
            $length = strlen($word);

            while ($i < $length) {
                $char = $word[$i];
                $nextChar = ($i + 1 < $length) ? $word[$i + 1] : '';
                $combined = $char . $nextChar;

                if ($i === 0 && isset($this->rules['vowels_awal'][$char])) {
                    $result .= $this->rules['vowels_awal'][$char];
                    $i++;
                } elseif (isset($this->rules['mapping'][$combined])) {
                    $result .= $this->rules['mapping'][$combined];
                    $i += 2;
                } elseif (isset($this->rules['mapping'][$char])) {
                    $result .= $this->rules['mapping'][$char];
                    $i++;
                } elseif (isset($this->rules['punctuation'][$char])) {
                    $result .= $this->rules['punctuation'][$char];
                    $i++;
                } elseif (isset($this->rules['vowels'][$char])) {
                    $result .= $this->rules['vowels'][$char];
                    $i++;
                } else {
                    $result .= $char;
                    $i++;
                }
            }
            $processedWords[] = $result;
        }

        return implode(' ', $processedWords);
    }
}
