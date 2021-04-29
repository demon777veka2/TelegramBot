<?php


namespace App\Services;

use Illuminate\Support\Facades\Validator;

class Palindrom
{
    public function palindrom($text)
    {

        $arrayText = array('text' => $text);

        $validator = Validator::make($arrayText, [
            'text' => 'required|max:255|regex:/^[A-z]+$/'
        ]);

        if ($validator->fails()) {
            return 'Ошибка ввода данных';
        }

        $text = strtolower($text);
        $text = str_replace(' ', '', $text);
        $textRevers = strrev($text);

        if ($text  != $textRevers)
            return 'строка не палиндром';
        else
            return 'ура, это палиндром!';
    }
}
