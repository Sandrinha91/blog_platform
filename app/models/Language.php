<?php

namespace App\Models;


class Language
{
    protected $words = [
        'WordsEn' => [],
        'WordsSr' => []
    ];

    public static function load($file)
    {
        $words = new static;
    
        require $file;
        return $words;
    }

    public function toEnglish($key,$value)
    {
        $this->words['WordsEn'][$key] = $value;
    }

    public function toSerbian($key,$value)
    {
        $this->words['WordsSr'][$key] = $value;
    }

    public function getEnWords()
    {
        return $this->words['WordsEn'];
    }

    public function getSrWords()
    {
        return $this->words['WordsSr'];
    }

    public static function sessionStart()
    {
        return session_start();
    }
}

?>